<?php

namespace NagatoPHP\Frontend\Controllers;
use NagatoPHP\Common\Torrent as TorrentTool;
use NagatoPHP\Models\Torrent as Torrent;

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
		foreach($torrent as $n){
			var_dump($n);
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
					if(TorrentTool::is_torrent($torrent_file->getTempName())){
						$torrent_file = new TorrentTool($torrent_file->getTempName());
						$torrent_file->announce(FALSE);
						$torrent_file->is_private(true);
						$torrent_file->source("[bt.byr.cn] BYRBT");
						var_dump(mb_detect_encoding($torrent_file->name()));
						exit;

						$torrent = new Torrent();
						$torrent->infohash = pack('H*', $torrent_file->hash_info());
						$torrent->filename = 'filename';
						$torrent->saveas = 'filename.torrent';
						$torrent->status = 'NORMAL';
						$torrent->size = $torrent_file->size();
						$torrent->addtime = date('Y-m-d H:i:s');
						foreach($this->request->getPost() as $key => $value){
							$torrent->$key = $value;
						}
						if($ret = $torrent->create()){
							
						} else {
							var_dump($ret);
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

