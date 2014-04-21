<?php

namespace NagatoPHP\Backend\Controllers;

class CacheController extends ControllerBase {

    public function indexAction() {
		$caches = $this->cache->queryKeys();
		echo "<pre>";
		foreach($caches as $cache){
			var_dump($cache);
			var_dump($this->cache->get(substr($cache, 7)));	
		}
		echo "</pre>";
    }

}

