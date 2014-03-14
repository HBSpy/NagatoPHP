<?php

namespace NagatoPHP\Frontend\Controllers;
use Phalcon\Mvc\Controller;

/**
 *
 * Base类
 *
 * 前台模块控制器基类
 */
class ControllerBase extends Controller {
	public function initialize(){
		$this->checkLogin();		
		$this->loadTemplate();
	}

	/**
	 * 登录验证
	 */
	public function checkLogin(){
		if(!$this->session->get('uid')){
			$this->response->redirect('login');
		}
		return;
	}

	/**
	 * 加载模板
	 */
	public function loadTemplate($template = 'common'){
		$this->view->setTemplateAfter($template);
		return;
	}

}
