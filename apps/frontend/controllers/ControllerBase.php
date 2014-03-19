<?php

namespace NagatoPHP\Frontend\Controllers;
use Phalcon\Mvc\Controller;
use NagatoPHP\Models\Category as Category;
use NagatoPHP\Models\CategorySub as CategorySub;

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
				$subs = array();
				foreach(CategorySub::findByCid($category->cid) as $sub){
					$tags = array();
					$file = __DIR__ . '/../../config/category/' . $sub->sid . '.json';
					if(is_readable($file)){
						foreach(json_decode(file_get_contents($file), TRUE) as $key => $tag){
							$tag['items'] = empty($tag['item']) ? array() : array_map('trim', explode(',', $tag['item']));
							unset($tag['item']);
							$tags[$key] = $tag;
						}
					}
					$subs[$sub->sid] = array('title' => $sub->title, 'tags' => $tags);
				}
				$cacheCategory[$category->cid] = array('name' => $category->name, 'title' => $category->title, 'default' => $category->default, 'subs' => $subs);
				$cacheCategory[$category->name] = array('cid' => $category->cid, 'title' => $category->title, 'default' => $category->default, 'subs' => $subs);
			}
			$this->cache->save('category', $cacheCategory);
		}
		return;
	}
}
