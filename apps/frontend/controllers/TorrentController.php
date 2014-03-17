<?php

namespace NagatoPHP\Frontend\Controllers;

class TorrentController extends ControllerBase {

    public function indexAction(){
    }

	public function addAction($cid){
		if(array_key_exists($cid, $this->cache->get('category'))){
			if($this->request->isGet()){
				$category = $this->cache->get('category')[$cid];
				var_dump($category);
			}
		} else {
			$this->flash->warning('分区ID不存在');
		}
	}
}

