<?php

namespace NagatoPHP\Frontend\Controllers;

use NagatoPHP\Common\Torrent as TorrentTool,
	NagatoPHP\Models\Torrent,
	NagatoPHP\Models\TorrentInfo;

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
						$torrent_file->is_private(TRUE);
						$torrent_file->source("[" . $this->cache->get('config')['SITE_URL'] . "]" . $this->cache->get('config')['SITE_NAME']);

						// TODO 文件过滤

						$torrent = new Torrent();
						$torrent->infohash = $torrent_file->hash_info();
						$torrent->owner = $this->session->get('uid');
						$torrent->status = 'NORMAL';
						$torrent->size = $torrent_file->size();
						$torrent->sid = $sid;
						$torrent->addtime = date('Y-m-d H:i:s');
						foreach($this->request->getPost() as $key => $value){
							$torrent->$key = $value;
						}
						if($torrent->create()){

							// 保存种子文件
							$torrent_file_dir = __DIR__ . '/../../../public/files/torrents/' . date("Ym");
							if(!is_dir($torrent_file_dir)){
								mkdir($torrent_file_dir);
							}
							$torrent_file_name = $torrent_file_dir . '/' . $torrent->tid . '_' . crc32($torrent_file->name()) . '.torrent';
							$torrent_file->save($torrent_file_name);

							$torrent_info = new TorrentInfo();
							$torrent_info->tid = $torrent->tid;
							$torrent_info->filename = $torrent_file_name;
							$torrent_info->saveas = $torrent_file->name();
							$torrent_info->intro = $this->request->getPost('intro');
							$torrent_info->file = $torrent_file->content();
							if($torrent_info->create()){
								$this->ajax->success($this->url->get("torrent/{$torrent->tid}"));
							}
						} else {
							foreach($torrent->getMessages() as $message){
								$errors[]= array(
									'field'  	=> $message->getField(),
									'message' 	=> $message->getMessage(),
								);
							}
							$this->ajax->error($errors);
						}
					} else {
						$this->ajax->error(array('field' => 'torrent', 'message' => '非种子文件'));
					}
				} else {
					$this->ajax->error(array('field' => 'torrent', 'message' => '请选择种子文件'));
				}
			}
		} else {
			$this->flash->warning('分区ID不存在');
		}
	}
}

