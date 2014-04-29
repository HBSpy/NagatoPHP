<?php

namespace NagatoPHP\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness,
	Phalcon\Mvc\Model\Validator\StringLength,
	Phalcon\Mvc\Model\Message;

class Torrent extends \Phalcon\Mvc\Model {

	public $tid;
	public $infohash;
	public $owner;
	public $status;
	public $addtime;
	public $sid;
	public $zhtitle;
	public $entitle;
	public $tag1;
	public $tag2;
	public $tag3;
	public $tag4;
	public $tag5;
	public $tag6;
	public $tag7;
	public $tag8;
	public $tag9;
	public $size;
	public $anonymous;
	public $complete;
	public $promotion;
	public $promotion_time;
	public $promotion_until;
	public $sticky;
	public $sticky_until;
	public $last_active;

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

	public function beforeSave(){
		$this->infohash = pack('H*', $this->infohash);
		$this->anonymous = $this->anonymous == 'on' ? TRUE : FALSE;

	}

	public function afterFetch(){
		$this->infohash = unpack('H*', $this->infohash);
	}

	public function validation(){
		$this->validate(new Uniqueness(array(
			'field'  	=> 'infohash',
			'message'  	=> '种子已存在',
		)));

		if(empty($this->zhtitle) && empty($this->entitle)){
			$message = new Message(
				'中文名与英文名二者必有其一',
				'zhtitle',
				'PresenceOf',
			);
		}

		$this->validate(new StringLength(array(
			'field' 			=> 'zhtitle',
			'max'  				=> 128,
			'messageMaximum'  	=> '最大长度128',
		)));

		return $this->validationHasFailed() != TRUE;
	}
}
