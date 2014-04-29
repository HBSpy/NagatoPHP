<?php

namespace NagatoPHP\Common;
use Phalcon\Mvc\User\Component;

class Ajax extends Component {

	/**
	 * plain return
	 */
	public function plain($data){
		header('Content-Type: application/json');
		exit(json_encode($data));
	}

	/**
	 * success return
	 */
	public function success($redirect){
		$data = array('status' => TRUE, 'redirect' => $redirect);
		$this->plain($data);
	}
	
	/**
	 * error return
	 */
	public function error($data){
		$data = array('status' => FALSE, 'error' => $data);
		$this->plain($data);
	}
}
