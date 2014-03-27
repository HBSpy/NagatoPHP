<?php

namespace NagatoPHP\Backend\Controllers;

class ConfigController extends ControllerBase {

	public function initialize(){
		parent::initialize();
		$this->view->navs = array(
			array('name' => 'site', 'title' => '站点'),
		);
	}

    public function indexAction($name) {
		$file = __DIR__ . '/../../config/' . $name . '.php';
		$configs = include $file;
		$this->view->configs = $configs;
    }

}
