<?php

namespace NagatoPHP\Models;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class CategorySub extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $sid;

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

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'sid' => 'sid', 
            'cid' => 'cid', 
            'name' => 'name', 
            'title' => 'title', 
        );
    }

}
