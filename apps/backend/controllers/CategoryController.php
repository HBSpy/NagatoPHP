<?php

namespace NagatoPHP\Backend\Controllers;
use NagatoPHP\Models\Category as Category;
use NagatoPHP\Models\CategorySub as CategorySub;

/**
 *
 * 分区管理类
 *
 */

class CategoryController extends ControllerBase {

	public function initialize(){
		parent::initialize();
		$this->view->navs = Category::find();
	}


    public function indexAction() {
    }

	/**
	 * 分区管理页面
	 *
	 * @Router('/admin/category/{category:[a-zA-Z]+}')
	 * @Param 	category 	分区名
	 */
	public function viewAction($category){
		if($currentCategory = Category::findFirstByName($category)){
			$this->view->currentCategory = $currentCategory;
			$subs = array();
			foreach(CategorySub::findByCid($currentCategory->cid) as $sub){
				$file = __DIR__ . '/../../config/category/' . $sub->sid . '.json';
				$tags = is_readable($file) ? json_decode(file_get_contents($file), TRUE) : array();
				$subs[$sub->sid] = array('title' => $sub->title, 'tags' => $tags);
			}
			$this->view->subs = $subs;
		} else {
			$this->flash->warning("该分区不存在");
		}
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
			$this->view->disable();
			$category = new Category();
			if($category->create($this->request->getPost(), array('name', 'title'))){
				$this->cache->delete('category');
				$this->tool->ajaxReturn(array('success' => TRUE));
			} else {
				foreach($category->getMessages() as $message){
					$ret[]= array('field' => $message->getField(), 'error' => $message->getMessage());
				}
				$this->tool->ajaxReturn($ret);
			}
		}
	}

	/**
	 * 删除分区
	 *
	 * @Router('admin/category/remove/:int')
	 * @Param 	cid 	分区ID
	 */
	public function removeAction($cid){
		if($this->request->isAjax()){
			$this->view->disable();
			$category = Category::findFirst($cid);
			foreach(CategorySub::findByCid($cid) as $sub){
				@unlink(__DIR__ . '/../../config/category/' . $sub->sid . '.json');
				$sub->delete();
			}
			if($category->delete()){
				$this->cache->delete('category');
				$this->tool->ajaxReturn(array('success' => TRUE));
			} else {
				$this->tool->ajaxReturn(array('error' => '竟然失败了'));
			}
		}
	}

	/**
	 * 添加二级分类
	 *
	 * @Router('admin/category/addsub/:int')
	 * @Param 	cid 	分区ID
	 * @Post 	title 	二级分类名称
	 * @Post 	default 是否设为默认
	 */
	public function addsubAction($cid){
		if($this->request->isAjax()){
			$this->view->disable();
			$sub = new CategorySub();
			$sub->cid = $cid;
			$sub->title = $this->request->getPost('title');
			$sub->default = $this->request->getPost('default') ? TRUE : FALSE;
			if($sub->create()){
				if($sub->default){
					$category = Category::findFirst($cid);
					$category->default = $sub->sid;
					$category->update();	
				}
				$this->cache->delete('category');
				$this->tool->ajaxReturn(array('success' => TRUE));
			} else {
				$this->tool->ajaxReturn(array('error' => '竟然失败了'));
			}
		}
	}

	/**
	 * 设置默认二级分类
	 *
	 * @Router('admin/category/setdefault/:int')
	 * @Param 	cid 	分区ID
	 * @Post 	sid 	二级分类ID
	 */
	public function setdefaultAction($cid){
		if($this->request->isAjax()){
			$this->view->disable();
			$category = Category::findFirst($cid);
			$category->default = $this->request->getPost('sid');
			if($category->update()){
				$this->tool->ajaxReturn(array('success' => TRUE));
			} else {
				$this->tool->ajaxReturn(array('error' => '竟然失败了'));
			}
		}
	}

	/**
	 * 删除二级分类
	 *
	 * @Router('/admin/category/:action/:int')
	 * @Param 	sid 	二级分类ID
	 */
	public function removesubAction($sid){
		if($this->request->isAjax()){
			$this->view->disable();
			$sub = CategorySub::findFirst($sid);
			@unlink(__DIR__ . '/../../config/category/' . $sid . '.json');
			if($sub->delete()){
				$this->tool->ajaxReturn(array('success' => TRUE));
			} else {
				$this->tool->ajaxReturn(array('error' => '竟然失败了'));
			}
		}
	}
	
	/**
	 * 添加分区TAG
	 *
	 * @Router('admin/category/:action/:int')
	 * @Param 	sid 	二级分类ID
	 * @Post 	tag 	TAG
	 * @Post 	item 	标签项
	 * @Post 	help 	帮助信息
	 */
	public function addtagAction($sid){
		if($this->request->isAjax()){
			$this->view->disable();
			$file = __DIR__ . '/../../config/category/' . $sid . '.json';
			$tags = is_readable($file) ? json_decode(file_get_contents($file), TRUE) : array();
			
			$newtag = $this->request->getPost();
			$newtag = array($newtag['tag'] => array(
				'title' => $newtag['title'], 
				'item' => $newtag['item'], 
				'search' => isset($newtag['search']) ? TRUE : FALSE, 
				'help' => $newtag['help']
			));
			$tags = array_merge($tags, $newtag);
			if(file_put_contents($file, json_encode($tags))){
				$this->cache->delete('category');
				$this->tool->ajaxReturn(array('success' => TRUE));
			} else {
				$this->tool->ajaxReturn(array('error' => "文件 {$file} 不可写入"));
			}
		}
	}

	/**
	 * 删除分区TAG
	 *
	 * @Router('admin/category/:action/:int')
	 * @Param 	sid 	二级分类ID
	 * @Post 	tag 	TAG_ID
	 */
	public function removetagAction($sid){
		if($this->request->isAjax()){
			$this->view->disable();
			$file = __DIR__ . '/../../config/category/' . $sid . '.json';
			$tags = is_readable($file) ? json_decode(file_get_contents($file), TRUE) : array();
			
			$removetag = $this->request->getPost('removetag');
			unset($tags[$removetag]);
			if(file_put_contents($file, json_encode($tags))){
				$this->cache->delete('category');
				$this->tool->ajaxReturn(array('success' => TRUE));
			} else {
				$this->tool->ajaxReturn(array('error' => "文件 {$file} 不可写入"));
			}
		}
	}
}

