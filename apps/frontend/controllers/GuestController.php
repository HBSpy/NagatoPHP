<?php

namespace NagatoPHP\Frontend\Controllers;
use NagatoPHP\Models\UserCommon as UserCommon;
use Phalcon\Mvc\Controller;

class GuestController extends Controller {

    public function indexAction(){

    }

	public function loginAction(){
		if($this->request->isGet()){
		}

		if($this->request->isAjax()){
			$username = $this->request->getPost("username");
			$password = $this->request->getPost("password");

			$user = UserCommon::findFirstByUsername($username);
			if($user){
				if($this->security->checkHash($password, $user->passhash)){
					$this->session->set('uid', $user->uid);
					$this->ajax->ajaxReturn(array('redirect' => $this->url->get('index')));
				} else {
					$this->ajax->ajaxReturn(array('error' => 'PWD'));
				}
			} else {
				$this->ajax->ajaxReturn(array('error' => 'USER'));
			}
		}
	}

	public function regAction(){

	}
}

