<?php

namespace NagatoPHP\Tracker\Controllers;
use NagatoPHP\Common\Torrent as Bencode;
use NagatoPHP\Models\AgentFamily as AgentFamily;
use NagatoPHP\Models\AgentException as AgentException;
use NagatoPHP\Models\User as User;
use NagatoPHP\Models\Torrent as Torrent;
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
 * 	numwant 	(optional)default=50 peers
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
		//$this->response->setContentType('text/plain', 'UTF-8');
		$this->response->sendHeaders();
		$this->cacheAgentRule();
	}

	public function indexAction(){
		$info_hash = $this->request->getQuery('info_hash');
		$peer_id = $this->request->getQuery('peer_id');
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

		$this->checkPeerId($peer_id);

		try {

			$user_passkey = $this->checkPasskey($passkey);
			$torrent_info_hash = $this->checkInfohash($info_hash);
			if(!$torrent = $this->cache->get("torrent_tid_{$torrent_info_hash['tid']}")){
				$torrent = array(
					'interval' => 10,
					'complete' => 233,
					'incomplete' => 9,
					'peers' => array(),
				);
				$this->cache->save("torrent_tid_{$torrent_info_hash['tid']}", $torrent, 60);
			} else {
				$torrent['peers'] = array($user_passkey['uid'] => array(
					'ip' 	  => $ip,
					'port' 	  => $port,
					'peer id' => $peer_id,
				)) + $torrent['peers'];
				$this->cache->save("torrent_tid_{$torrent_info_hash['tid']}", $torrent, 60);
			}
/*
			if($compact){
				$peers = $this->compactPeers($peers);
			} elseif ($no_peer_id){
				$peers = $this->removePeerId($peers);
			}

			$peer_stats = $this->getPeerStats($info_hash);
 */
			$this->response->setContent(Bencode::encode($torrent));
			$this->response->send();

		} catch (Exception $e){
			$this->announceFailure("Fuck ♂ you!");
		}
	}

	protected function getPeers($tid){
		return $this->cache->get("torrent_{$tid}")['peers'];
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

	protected function checkPeerId($peer_id){
		if(strlen($peer_id) != 20){
			$this->announceFailure("非法的 Peer ID");
		}

		foreach($this->cache->get('agent_rule') as $rule){	
			if(preg_match($rule->peer_id_pattern, $peer_id)){
				return;
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

	protected function checkPasskey($passkey){
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
			}
		}
		return $this->cache->get("user_passkey_{$passkey}");
	}

	protected function checkInfohash($info_hash){
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
