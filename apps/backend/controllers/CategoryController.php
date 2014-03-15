<?php

namespace NagatoPHP\Backend\Controllers;
use NagatoPHP\Models\Category as Category;

/**
 *
 * 分区管理类
 *
 */

class CategoryController extends ControllerBase {

	protected $categorys = array();

	public function initialize(){
		parent::initialize();
		$categorys = Category::find();
		foreach($categorys as $category){
			$file = __DIR__ . '/../../config/category/' . $category->name . '.json';
			$category->tags = is_readable($file) ? (object)json_decode(file_get_contents($file)) : (object)array();
			$this->categorys += array($category->cid => $category);
		}
	}


    public function indexAction() {
		$this->view->categorys = $this->categorys;
    }
	
	/**
	 * 添加分区
	 *
	 * @Router('admin/category/add')
	 * @Post 	name 	分区标识符
	 * @Post 	title 	分区名
	 */
	public function addAction(){
		if($this->request->isAjax()){
			$category = new Category();
			if($category->create($this->request->getPost(), array('name', 'title'))){
				$this->ajax->ajaxReturn(array('success' => TRUE));
			} else {
				foreach($category->getMessages() as $message){
					$ret[]= array('field' => $message->getField(), 'error' => $message->getMessage());
				}
				$this->cache->delete('category');
				$this->ajax->ajaxReturn($ret);
			}
		}

	}

	/**
	 * 添加分区TAG
	 *
	 * @Router('admin/category/addtag/:int')
	 * @Param 	cid 	分区ID
	 * @Post 	tag 	TAG
	 * @Post 	item 	标签项
	 */
	public function addtagAction($cid){
		if($this->request->isAjax()){
			$category = $this->categorys[$cid];
			$tags = (array)$category->tags;

			$newtag = $this->request->getPost();
		   	$newtag = array($newtag['tag'] => array('title' => $newtag['title'], 'item' => $newtag['item'], 'search' => isset($newtag['search']) ? TRUE : FALSE));
			$tags = array_merge($tags, $newtag);
			$file = __DIR__ . '/../../config/category/' . $category->name . '.json';
			if(file_put_contents($file, json_encode($tags))){
				$this->cache->delete('category');
				$this->ajax->ajaxReturn(TRUE);
			}
		}
	}

	/**
	 * 删除分区TAG
	 *
	 * @Router('admin/category/removetag/:int')
	 * @Param 	cid 	分区ID
	 * @Post 	tag 	TAG_ID
	 */
	public function removetagAction($cid){
		if($this->request->isAjax()){
			$category = $this->categorys[$cid];
			$tags = (array)$category->tags;

			$removetag = $this->request->getPost('removetag');
			unset($tags[$removetag]);
			$file = __DIR__ . '/../../config/category/' . $category->name . '.json';
			if(file_put_contents($file, json_encode($tags))){
				$this->cache->delete('category');
				$this->ajax->ajaxReturn(TRUE);
			}
		}
	}

}

