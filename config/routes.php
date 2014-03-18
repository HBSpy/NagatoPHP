<?php 

use Phalcon\Mvc\Router;

$router = new Router(FALSE);

$router->removeExtraSlashes(TRUE);
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

// Category
$router->add('/admin/category/:action/:int', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 1,
	'cid' => 2,
));

$router->add('/admin/category/add', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'add',
));

$router->add('/admin/category', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
));

// Torrent
$router->add('/upload/{category:[a-zA-Z]+}', array(
	'controller' => 'torrent',
	'action' => 'add',
));

return $router;
