<?php

namespace NagatoPHP\Models;

class AgentException extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $fid;
     
    /**
     *
     * @var string
     */
    public $name;
     
    /**
     *
     * @var string
     */
    public $peer_id_pattern;
     
    /**
     *
     * @var string
     */
    public $agent;
     
    /**
     *
     * @var string
     */
    public $remark;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'fid' => 'fid', 
            'name' => 'name', 
            'peer_id_pattern' => 'peer_id_pattern', 
            'agent' => 'agent', 
            'remark' => 'remark'
        );
    }

}
