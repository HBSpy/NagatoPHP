<?php

namespace NagatoPHP\Backend\Controllers;
use Phalcon\Mvc\Controller;

/**
 *
 * Base类
 *
 * 后台模块控制器基类
 */

class ControllerBase extends Controller {
	public function initialize(){
		$this->loadTemplate();

	}

	/**
	 * 加载模板
	 */
	public function loadTemplate($template = 'common'){
		$this->view->setTemplateAfter($template);
		return;
	}
}
