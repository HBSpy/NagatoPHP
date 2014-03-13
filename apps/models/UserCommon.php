<?php

namespace NagatoPHP\Models;

class UserCommon extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $uid;
     
    /**
     *
     * @var string
     */
    public $username;
     
    /**
     *
     * @var string
     */
    public $passhash;
     
    /**
     *
     * @var string
     */
    public $status;
     
    /**
     *
     * @var integer
     */
    public $uploaded;
     
    /**
     *
     * @var integer
     */
    public $downloaded;
     
    /**
     *
     * @var string
     */
    public $passkey;
     
    /**
     *
     * @var double
     */
    public $bonus;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'uid' => 'uid', 
            'username' => 'username', 
            'passhash' => 'passhash', 
            'status' => 'status', 
            'uploaded' => 'uploaded', 
            'downloaded' => 'downloaded', 
            'passkey' => 'passkey', 
            'bonus' => 'bonus'
        );
    }

}
