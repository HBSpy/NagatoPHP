<?php

namespace NagatoPHP\Frontend\Controllers;
use NagatoPHP\Common\Torrent as TorrentTool;
use NagatoPHP\Models\Torrent as Torrent;
use NagatoPHP\Models\TorrentInfo as TorrentInfo;

class TorrentController extends ControllerBase {

	public function indexAction($category = NULL){
		$categorys = $this->cache->get('category');
		$this->view->categorys = $categorys;
		if(array_key_exists($category, $categorys)){
			$category = $categorys[$category];
			$this->view->subs = $category['subs'];
			$sid = $this->dispatcher->getParam('sid');
			$sub = $sid ? $category['subs'][$sid] : $category['subs'] [$category['default']];
			$this->view->tags = $sub['tags'];
		}

		$torrents = Torrent::find();
		$currentPage = $this->request->getQuery('p', 'int', 1);
		$paginator = new \Phalcon\Paginator\Adapter\Model(array(
			'data' => $torrents,
			'limit' => 50,
			'page' => $currentPage,
		));
		$this->view->pagebar = $this->tool->getPagebar($paginator->getPaginate());
		$this->view->torrents = $torrents;
    }

	/**
	 * 种子页面
	 *
	 */
	public function viewAction($tid){
		$torrent = Torrent::findFirst($tid);
		echo "<pre>";
		foreach($torrent as $key => $value){
			var_dump($key);
			var_dump($value);
		}
		echo "</pre>";
	}

	/**
	 * 上传种子
	 *
	 * @Router('/upload/{category:[a-zA-Z]+}')
	 * @Router('/upload/{category:[a-zA-Z]+}/:int')
	 * @Param 	category  	分区标识
	 * @Param 	sid 		二级分类ID
	 * @Post 				表单信息	
	 */
	public function addAction($category){
		if(array_key_exists($category, $this->cache->get('category'))){
			$category = $this->cache->get('category')[$category];
			$sid = $this->dispatcher->getParam('sid');
			$sid = ($sid && array_key_exists($sid, $category['subs'])) ? $sid : $category['default'];
			if($this->request->isGet()){
				$this->view->category = $category;
				$this->view->sid = $sid;
			}
			if($this->request->isAjax()){
				$this->view->disable();
				if($this->request->hasFiles()){
					$torrent_file = $this->request->getUploadedFiles()[0];
					if($torrent_file->getType() == 'application/x-bittorrent'){
						$torrent_file = new TorrentTool($torrent_file->getTempName());
						$torrent_file->announce(FALSE);
						$torrent_file->is_private(true);
						$torrent_file->source("[" . $this->cache->get('config')['SITE_URL'] . "]" . $this->cache->get('config')['SITE_NAME']);

						// 重复检测
						if(Torrent::findFirstByInfohash(pack('H*', $torrent_file->hash_info()))){
							$this->tool->ajaxReturn(array('error' => 'DUPE'));
						}

						// TODO 文件过滤

						$torrent = new Torrent();
						$torrent->infohash = pack('H*', $torrent_file->hash_info());
						$torrent->owner = $this->session->get('uid');
						$torrent->status = 'NORMAL';
						$torrent->size = $torrent_file->size();
						$torrent->sid = $sid;
						$torrent->anonymous = $this->request->getPost('anonymous') ? TRUE : FALSE;
						$torrent->addtime = date('Y-m-d H:i:s');
						foreach($this->request->getPost() as $key => $value){
							if(!in_array($key, array('anonymous', 'intro')))
							$torrent->$key = $value;
						}
						if($torrent->create()){

							// 保存种子文件
							$torrent_file_dir = __DIR__ . '/../../../public/files/torrents/' . date("Ym");
							if(!is_dir($torrent_file_dir)){
								mkdir($torrent_file_dir);
							}
							$torrent_file_name = $torrent_file_dir . '/' . $torrent->tid . '_' . crc32($torrent_file->name()) . '.torrent';
							if($torrent_file->save($torrent_file_name)){
								$torrent_file->send();
							}

							$torrent_info = new TorrentInfo();
							$torrent_info->tid = $torrent->tid;
							$torrent_info->filename = $torrent_file_name;
							$torrent_info->saveas = $torrent_file->name();
							$torrent_info->intro = $this->request->getPost('intro');
							$torrent_info->file = json_encode($torrent_file->content());
							if($torrent_info->create()){
								$this->tool->ajaxReturn(array('success' => TRUE, 'redirect' => $this->url->get("torrent/{$torrent->tid}")));
							}
						}
					} else {
						$this->tool->ajaxReturn(array('error' => 'ERRORTYPE'));
					}
				} else {
					$this->tool->ajaxReturn(array('error' => 'NOFILE'));
				}
			}
		} else {
			$this->flash->warning('分区ID不存在');
		}
	}
}

