<?php

namespace NagatoPHP\Tracker\Controllers;

use NagatoPHP\Common\Torrent as Bencode;
use NagatoPHP\Models\AgentFamily as AgentFamily;
use NagatoPHP\Models\AgentException as AgentException;
use NagatoPHP\Models\User as User;
use NagatoPHP\Models\Torrent as Torrent;
use NagatoPHP\Models\Peer as Peer;
use Phalcon\Mvc\Model\Resultset as Resultset;
use Phalcon\Mvc\Controller;

/**
 *
 * Tracker模块控制器类
 *
 * array Request:
 * 	info_hash 	urlencoded 	20-bytes 	SHA1
 * 	peer_id 	urlencoded 	20-bytes 	string
 * 	port
 * 	uploaded 	bytes
 * 	downloaded 	bytes
 * 	left 		bytes
 * 	compact 	0 || 1(only for IPv4)
 * 	no_peer_id 	0 || 1
 * 	event 		started || stopped || completed
 * 	ip 			(optional)
 * 	numwant 	(optional) default=50 peers
 * 	key 		(optional)
 * 	trackerid 	(optional)
 * 
 * array Response: (text/plain)
 * 	failure reason
 * 	warning message
 * 	interval
 * 	min interval 	(optional)
 * 	tracker id 		
 * 	complete
 * 	incomplete
 * 	peers 	array(peer id, ip, port) || compacted peers(only for IPv4)
 *
 */
class IndexController extends Controller {

	public function initialize(){
		$this->response->setContentType('text/plain', 'UTF-8');
		$this->response->sendHeaders();
		$this->cacheAgentRule();
	}

	public function announceAction(){

		$info_hash = $this->request->getQuery('info_hash');
		$peer_id = $this->request->getQuery('peer_id');
		$agent = $this->request->getUserAgent();
		$port = intval($this->request->getQuery('port', 'int'));
		$uploaded = intval($this->request->getQuery('uploaded', 'int'));
		$downloaded = intval($this->request->getQuery('downloaded', 'int'));
		$left = intval($this->request->getQuery('left', 'int'));
		$compact = $this->request->getQuery('compact', 'int');
		$no_peer_id = $this->request->getQuery('no_peer_id', 'int');
		$event = $this->request->getQuery('event', 'string');
		$ip = $this->tool->getIP();
		$numwant = $this->request->getQuery('numwant', 'int', 50);

		$passkey = $this->request->getQuery('passkey', 'alphanum');

		$this->checkPeerId($peer_id, $agent);

		try {

			$user = $this->getUser($passkey);
			$torrent = $this->getTorrent($info_hash);

			$this->saveAnnounce($torrent['tid'], $user['uid'], $peer_id, $ip, $port, $uploaded, $downloaded, $left, $event, $agent);

			$peers = $this->getPeers($torrent['tid'], $user['uid'], $event, $numwant);

			if($compact){
				$peers = $this->compactPeers($peers);
			} elseif ($no_peer_id){
				$peers = $this->removePeerId($peers);
			}

			$peer_stats = $this->getPeerStats($torrent['tid']);

			$interval = 30;

			$announce_response = array(
				'interval' 		=> $interval,
				'complete' 		=> intval($peer_stats['complete']),
				'incomplete' 	=> intval($peer_stats['incomplete']),
				'peers' 		=> $peers,
			);

			$this->response->setContent(Bencode::encode($announce_response));
			$this->response->send();

		} catch (Exception $e){
			$this->announceFailure("Fuck ♂ you!");
		}
	}

	protected function saveAnnounce($tid, $uid, $peer_id, $ip, $port, $uploaded, $downloaded, $left, $event, $agent){
		$peer = Peer::findFirst(array(
			'conditions' 	=> 'tid = ?1 AND uid = ?2',
			'bind' 			=> array(1 => $tid, 2 => $uid),
		));

		if($peer){
			switch($event){

			case 'stopped':

				$peer->delete();
				exit;

			case 'completed':
				$peer->peer_id = $peer_id;
				$peer->ip = inet_pton($ip);
				$peer->port = $port;
				$peer->uploaded = $uploaded;
				$peer->downloaded = $downloaded;
				$peer->left = 0;
				$peer->seeder = TRUE;
				$peer->agent = $agent;

				$peer->update();
				return;

			default:
				$peer->peer_id = $peer_id;
				$peer->ip = inet_pton($ip);
				$peer->port = $port;
				$peer->uploaded = $uploaded;
				$peer->downloaded = $downloaded;
				$peer->left = $left;
				$peer->seeder = FALSE;
				$peer->agent = $agent;

				$peer->update();
				return;
			}
		} else {
			switch($event){

			case 'stopped':

				exit;

			case 'completed':
				$peer = new Peer();
				$peer->tid = $tid;
				$peer->uid = $uid;
				$peer->peer_id = $peer_id;
				$peer->ip = inet_pton($ip);
				$peer->port = $port;
				$peer->uploaded = $uploaded;
				$peer->downloaded = $downloaded;
				$peer->left = 0;
				$peer->seeder = TRUE;
				$peer->agent = $agent;

				$peer->create();
				return;

			default:
				$peer = new Peer();
				$peer->tid = $tid;
				$peer->uid = $uid;
				$peer->peer_id = $peer_id;
				$peer->ip = inet_pton($ip);
				$peer->port = $port;
				$peer->uploaded = $uploaded;
				$peer->downloaded = $downloaded;
				$peer->left = $left;
				$peer->seeder = FALSE;
				$peer->agent = $agent;

				$peer->create();
				return;
			}
		}
	}

	protected function getPeers($tid, $uid, $event, $numwant){
		$peers = array();
		switch($event){

		case 'completed':
			foreach(Peer::find(array(
				'columns' 		=> 'peer_id, ip, port',
				'conditions' 	=> 'tid = ?1 AND seeder = FALSE',
				'bind' 			=> array(1 => $tid),
				'order' 		=> 'RAND()',
				'limit' 		=> $numwant,
				'hydration' 	=> Resultset::HYDRATE_ARRAYS,
			)) as $peer){
				$peer['ip'] = @inet_ntop($peer['ip']);
				$peers[]= $peer;
			}

			return $peers;

		default:
			foreach(Peer::find(array(
				'columns' 		=> 'peer_id, ip, port',
				'conditions' 	=> 'tid = ?1',
				'bind' 			=> array(1 => $tid),
				'order' 		=> 'seeder DESC, RAND()',
				'limit' 		=> $numwant,
				'hydration' 	=> Resultset::HYDRATE_ARRAYS,
			)) as $peer){
				$peer['ip'] = @inet_ntop($peer['ip']);
				$peers[]= $peer;
			}

			return $peers;
		}
	}

	protected function getPeerStats($tid){
		$ret = array();
		$ret['complete'] = Peer::count(array(
			'tid = ?1 AND seeder = TRUE',
			'bind' => array(1 => $tid),
		));

		$ret['incomplete'] = Peer::count(array(
			'tid = ?1 AND seeder = FALSE',
			'bind' => array(1 => $tid),
		));

		return $ret;
	}

	protected function announceFailure($message){
		exit(Bencode::encode(array('failure reason' => $message)));
	}

	protected function compactPeers($peers){
		$compact_peers = "";
		foreach($peers as $peer){
			$compact_peers .= pack('N', ip2long($peer['ip'])) . pack('n', $peer['port']);
		}
		return $compact_peers;
	}

	protected function removePeerId($peers){
		foreach($peers as $key => $peer){
			unset($peers[$key]['peer id']);
		}
	}

	protected function checkPeerId($peer_id, $agent){
		foreach(array('Mozilla', 'Opera', 'Links', 'Lynx', 'AppleWebKit', 'Chrome', 'Safari') as $browser){
			if(strpos($agent, $browser)){
				exit("浏览器是不行 da☆yo >_<");
			}
		}

		if(strlen($peer_id) != 20){
			$this->announceFailure("非法的 Peer ID");
		}

		foreach($this->cache->get('agent_rule') as $rule){	
			if(preg_match($rule->peer_id_pattern, $peer_id)){
				if($rule->exception){
					foreach($rule->exceptions as $exception){
						if(preg_match($rule->peer_id_pattern, $peer_id)){
							$this->announceFailure("您的客户端 {$exception->name} 由于以下原因被禁止: {$exception->remark}");
						}
					}
				} else {
					return;
				}
			}
		}
		$this->announceFailure("您的客户端目前仍未被支持，请更换或联系管理员并提供以下信息: peer_id " . rawurlencode($peer_id));
	}

	protected function getUser($passkey){
		if(strlen($passkey) != 32){
			$this->announceFailure("非法的 Passkey");
		}

		if(!$this->cache->exists("user_passkey_{$passkey}")){
			if(!$user = User::findFirstByPasskey($passkey)){
				$this->announceFailure("非法的 Passkey");
			} else {
				// TODO check user's auth or blabla...

	
	
	
	
	
	
	
				$user = array(
					'uid' => $user->uid,
				);	
				$this->cache->save("user_passkey_{$passkey}", $user);

				return $user;
			}
		}
		return $this->cache->get("user_passkey_{$passkey}");
	}

	protected function getTorrent($info_hash){
		if(strlen($info_hash) != 20){
			$this->announceFailure("非法的 Info Hash");
		}

		if(!$this->cache->exists("torrent_info_hash_{$info_hash}")){
			if(!$torrent = Torrent::findFirstByInfohash($info_hash)){
				$this->announceFailure("该种子并未在此 Tracker 注册");
			} else {
				// TODO check torrent's states and so on...








				$torrent = array(
					'tid' => $torrent->tid,
				);
				$this->cache->save("torrent_info_hash_{$info_hash}", $torrent);

				return $torrent;
			}
		}
		return $this->cache->get("torrent_info_hash_{$info_hash}");
	}

	protected function cacheAgentRule(){
		if(!$this->cache->exists('agent_rule')){
			$agent_rule = array();
			foreach(AgentFamily::find(array('order' => 'hits DESC', 'hydration' => Resultset::HYDRATE_OBJECTS)) as $family){
				foreach(AgentException::find(array("fid = {$family->fid}", 'hydration' => Resultset::HYDRATE_OBJECTS)) as $exception){
					$family->exceptions[]= $exception;
				}
				$agent_rule[]= $family;
			}
			$this->cache->save('agent_rule', $agent_rule);
		}
	}
}
