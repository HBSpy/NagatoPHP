<?php

namespace NagatoPHP\Models;

class Torrent extends \Phalcon\Mvc\Model {
	public function initialize(){
		$this->skipAttributes(array(
			'complete', 
			'promotion', 
			'promotion_time', 
			'promotion_until',
			'sticky',
			'sticky_until',
			'last_active',
		));
	}
}
