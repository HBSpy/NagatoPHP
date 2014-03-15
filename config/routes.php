<?php 

use Phalcon\Mvc\Router;

$router = new Router();

$router->setDefaultModule("frontend");
$router->setDefaultNamespace("NagatoPHP\Frontend\Controllers");

$router->add('/login', array(
	'controller' => 'guest',
	'action' => 'login',
));

$router->add('/admin', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'index',
));

$router->add('/admin/category', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
));

$router->add('/admin/category/add', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'add',
));

$router->add('/admin/category/addtag/:int', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'addtag',
	'cid' => 1,
));

$router->add('/admin/category/removetag/:int', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'removetag',
	'cid' => 1,
));
return $router;
