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
		$this->view->categorys = $categorys;
	}

    public function indexAction() {
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
			$category = Category::findFirst($cid);

			$this->ajax->ajaxReturn($category);
		}
	}

}

