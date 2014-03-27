<?php

namespace NagatoPHP\Backend\Controllers;
use NagatoPHP\Models\AgentFamily as AgentFamily;
use NagatoPHP\Models\AgentException as AgentException;

class AgentController extends ControllerBase {

    public function indexAction() {

    }

	public function ruleAction(){
		$agents = AgentFamily::find(array(
			'order' => 'hits DESC',
		));
		$this->view->agents = $agents;
	}

}

