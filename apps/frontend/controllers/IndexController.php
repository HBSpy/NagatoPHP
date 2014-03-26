<?php

namespace NagatoPHP\Frontend\Controllers;

class IndexController extends ControllerBase {

    public function indexAction(){
		$this->view->disable();
		var_dump($this->cache->queryKeys());
		$a = array(1 => 'a');
		$b = array(1 => 'b');
		var_dump(array_merge($a, $b));
    }
}

