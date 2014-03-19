<?php

namespace NagatoPHP\Frontend\Controllers;

class IndexController extends ControllerBase {

    public function indexAction(){
		var_dump($this->cache->get('category'));
    }
}

