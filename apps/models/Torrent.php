<?php

namespace NagatoPHP\Models;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Torrent extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $tid;
     
    /**
     *
     * @var string
     */
    public $infohash;
     
    /**
     *
     * @var string
     */
    public $filename;
     
    /**
     *
     * @var string
     */
    public $saveas;
     
    /**
     *
     * @var string
     */
    public $zhtitle;
     
    /**
     *
     * @var string
     */
    public $entitle;
     
    /**
     *
     * @var string
     */
    public $subtitle;
     
    /**
     *
     * @var string
     */
    public $status;
     
    /**
     *
     * @var integer
     */
    public $size;
     
    /**
     *
     * @var string
     */
    public $addtime;
     
    /**
     *
     * @var string
     */
    public $tag1;
     
    /**
     *
     * @var string
     */
    public $tag2;
     
    /**
     *
     * @var string
     */
    public $tag3;
     
    /**
     *
     * @var string
     */
    public $tag4;
     
    /**
     *
     * @var string
     */
    public $tag5;
     
    /**
     *
     * @var string
     */
    public $tag6;
     
    /**
     *
     * @var string
     */
    public $tag7;
     
    /**
     *
     * @var string
     */
    public $tag8;
     
    /**
     *
     * @var string
     */
    public $tag9;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'tid' => 'tid', 
            'infohash' => 'infohash', 
            'filename' => 'filename', 
            'saveas' => 'saveas', 
            'zhtitle' => 'zhtitle', 
            'entitle' => 'entitle', 
            'subtitle' => 'subtitle', 
            'status' => 'status', 
            'size' => 'size', 
            'addtime' => 'addtime', 
            'tag1' => 'tag1', 
            'tag2' => 'tag2', 
            'tag3' => 'tag3', 
            'tag4' => 'tag4', 
            'tag5' => 'tag5', 
            'tag6' => 'tag6', 
            'tag7' => 'tag7', 
            'tag8' => 'tag8', 
            'tag9' => 'tag9'
        );
    }

}
