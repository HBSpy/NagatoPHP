<?php

namespace NagatoPHP\Frontend\Controllers;
use Phalcon\Mvc\Controller;
use NagatoPHP\Models\Category as Category;

/**
 *
 * Base类
 *
 * 前台模块控制器基类
 */
class ControllerBase extends Controller {
	public function initialize(){
		$this->checkLogin();		
		$this->cacheCategory();
		$this->loadTemplate();
	}

	/**
	 * 登录验证
	 */
	protected function checkLogin(){
		if(!$this->session->get('uid')){
			$this->response->redirect('login');
		}
		return;
	}

	/**
	 * 加载模板
	 *
	 * @Param 	template 	模板名
	 */
	protected function loadTemplate($template = 'common'){
		$this->view->setTemplateAfter($template);
		$this->view->categorys = $this->cache->get('category');
		return;
	}

	/**
	 * 缓存分区信息
	 */
	protected function cacheCategory(){
		$cacheCategory = $this->cache->get('category');
		if($cacheCategory == NULL){
			$categorys = Category::find();
			foreach($categorys as $category){
				$file = __DIR__ . '/../../config/category/' . $category->name . '.json';
				if(is_readable($file)){
					$tags = array();
					foreach(json_decode(file_get_contents($file), TRUE) as $key => $tag){
						$tag['items'] = empty($tag['item']) ? array() : array_map('trim', explode(',', $tag['item']));
						unset($tag['item']);
						$tags[$key] = $tag;
					}
					$cacheCategory[$category->cid] = array('name' => $category->name, 'title' => $category->title, 'tags' => $tags);
					$cacheCategory[$category->name] = array('cid' => $category->cid, 'title' => $category->title, 'tags' => $tags);
				}
			}
			$this->cache->save('category', $cacheCategory);
		}
		return;
	}
}
