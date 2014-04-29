<?php

namespace NagatoPHP\Models;

class TorrentInfo extends \Phalcon\Mvc\Model {
	
	public $tid;
	public $filename;
	public $saveas;
	public $intro;
	public $file;

	public function beforeSave(){
		$this->file = json_encode($this->file);
	}

	public function afterFetch(){
		$this->file = json_decode($this->file);
	}
}
