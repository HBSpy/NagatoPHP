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

// {{{ 分区管理
$router->add('/admin/category/:action/:int', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 1,
	'sid' => 2,
));

$router->add('/admin/category/{category:[a-zA-Z]+}', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'view',
));

$router->add('/admin/category/setdefault/:int', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'setdefault',
	'cid' => 1,
));

$router->add('/admin/category/addsub/:int', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'addsub',
	'cid' => 1,
));

$router->add('/admin/category/remove/:int', array(
	'namespace' => 'NagatoPHP\Backend\Controllers',
	'module' => 'backend',
	'controller' => 'category',
	'action' => 'remove',
	'cid' => 1,
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
//}}}

// {{{ 种子
$router->add('/upload/{category:[a-zA-Z]+}/:int', array(
	'controller' => 'torrent',
	'action' => 'add',
	'category' => 1,
	'sid' => 2,
));
$router->add('/upload/{category:[a-zA-Z]+}', array(
	'controller' => 'torrent',
	'action' => 'add',
));
// }}}

return $router;
