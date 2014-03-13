<?php

namespace NagatoPHP\Frontend\Controllers;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
	public function initialize(){
		if(!$this->session->get('uid')){
			$this->response->redirect('login');
		}
	}

}
