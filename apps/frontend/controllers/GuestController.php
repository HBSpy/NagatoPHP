<?php

namespace NagatoPHP\Frontend\Controllers;
use NagatoPHP\Models\User as User;
use Phalcon\Mvc\Controller;

/**
 *
 * Guest类
 *
 * 处理用户登录、注册、密码找回等无需登录的相关功能
 *
 */
class GuestController extends Controller {

    public function indexAction(){

    }

	/**
	 * 登录
	 *
	 * @Route('login')
	 * @Post 	username 	用户名
	 * @Post 	password 	密码
	 */
	public function loginAction(){
		if($this->request->isGet()){
			if($this->session->get('uid')){
				$this->flash->success("您已登录");
				$this->response->redirect('index');
			}
		}

		if($this->request->isAjax()){
			$username = $this->request->getPost("username");
			$password = $this->request->getPost("password");

			$user = User::findFirstByUsername($username);
			if($user){
				if(1){
					$this->session->set('uid', $user->uid);
					$this->flash->success("欢迎回来！ {$user->username}");
					$this->tool->ajaxReturn(array('success' => TRUE));
				} else {
					$this->tool->ajaxReturn(array('error' => 'PWD'));
				}
			} else {
				$this->tool->ajaxReturn(array('error' => 'USER'));
			}
		}
	}

	public function regAction(){

	}
}

