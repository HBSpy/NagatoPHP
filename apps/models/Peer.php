<?php

namespace NagatoPHP\Models;

class Peer extends \Phalcon\Mvc\Model {

	public $tid;
	public $uid;
	public $peer_id;
	public $ip;
	public $port;
	public $uploaded;
	public $downloaded;
	public $left;
	public $seeder;
	public $agent;

	public function beforeSave(){
		$this->ip = inet_pton($this->ip);
	}

	public function afterFetch(){
		$this->ip = inet_ntop($this->ip);
	}

}
