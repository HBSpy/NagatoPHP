<?php

namespace NagatoPHP\Models;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Category extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cid;
     
    /**
     *
     * @var string
     */
    public $name;
     
    /**
     *
     * @var string
     */
    public $title;

	public function validation(){ 
		$this->validate(new Uniqueness(array(
			'field' => 'name',
			'message' => '该分区标识已存在',
		)));

		return $this->validationHasFailed() != TRUE;
	}
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'cid' => 'cid', 
            'name' => 'name', 
            'title' => 'title', 
        );
    }

}
