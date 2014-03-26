<?php

namespace NagatoPHP\Models;

class AgentFamily extends \Phalcon\Mvc\Model
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
    public $family;
     
    /**
     *
     * @var string
     */
    public $peer_id_pattern;
     
    /**
     *
     * @var string
     */
    public $agent_pattern;
     
    /**
     *
     * @var string
     */
    public $exception;
     
    /**
     *
     * @var string
     */
    public $comment;
     
    /**
     *
     * @var integer
     */
    public $hits;
     
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'fid' => 'fid', 
            'family' => 'family', 
            'peer_id_pattern' => 'peer_id_pattern', 
            'agent_pattern' => 'agent_pattern', 
            'exception' => 'exception', 
            'comment' => 'comment', 
            'hits' => 'hits'
        );
    }

}
