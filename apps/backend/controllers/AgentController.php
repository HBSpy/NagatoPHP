<?php

namespace NagatoPHP\Backend\Controllers;
use NagatoPHP\Models\AgentFamily as AgentFamily;

class AgentController extends ControllerBase {

    public function indexAction() {

    }

	public function familyAction(){
		$this->view->agents = AgentFamily::find();
	}

}

