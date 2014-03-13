<?php

namespace NagatoPHP\Common;
use Phalcon\Mvc\User\Component;

class Ajax extends Component {

	public function ajaxReturn($data){
		header('Content-Type: application/json');
		exit(json_encode($data));
	}
}
