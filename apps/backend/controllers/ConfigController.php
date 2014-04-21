<?php

namespace NagatoPHP\Backend\Controllers;

class ConfigController extends ControllerBase {

	private $nagato = array();

	public function initialize(){
		parent::initialize();
		$this->nagato = include __DIR__ . '/../../config/nagato.php';
		$this->view->navs = array(
			array('name' => 'site', 'title' => '站点'),
		);
	}

    public function indexAction($name) {
		$file = __DIR__ . '/../../config/' . $name . '.php';
		$configs = include $file;
		if($this->request->isGet()){
			$this->view->configs = $configs;
		}
		if($this->request->isAjax()){
			$this->view->disable();
			foreach($newConfigs = $this->request->getPost() as $key => $value){
				$configs[$key]['value'] = $value;
			}
			file_put_contents($file, "<?php\nreturn " . var_export($configs, TRUE) . "\n?>", LOCK_EX);
			file_put_contents(__DIR__ . '/../../config/nagato.php', "<?php\nreturn " . var_export(array_merge($this->nagato, $newConfigs), TRUE) . "\n?>", LOCK_EX);
			$this->cache->delete('config');

			$this->flash->success("保存成功");
			$this->tool->ajaxReturn(TRUE);
		}
    }

}
