<?php

namespace NagatoPHP\Frontend\Controllers;
use NagatoPHP\Models\User as User;

class IndexController extends ControllerBase {

    public function indexAction(){
		$user = User::findFirst(1);
		foreach($user as $n){
			var_dump($n);
		}
    }
}

