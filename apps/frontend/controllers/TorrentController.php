<?php

namespace NagatoPHP\Frontend\Controllers;

class TorrentController extends ControllerBase {

    public function indexAction(){
    }

	public function addAction($category){
		if(array_key_exists($category, $this->cache->get('category'))){
			if($this->request->isGet()){
				$category = $this->cache->get('category')[$category];
				$this->view->category = $category;
			}
			if($this->request->isAjax()){
			}
		} else {
			$this->flash->warning('分区ID不存在');
		}
	}
}

