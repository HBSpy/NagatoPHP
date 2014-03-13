<?php 

use Phalcon\Mvc\Router;

$router = new Router();

$router->setDefaultModule("frontend");
$router->setDefaultNamespace("NagatoPHP\Frontend\Controllers");

$router->add('/login', array(
	'controller' => 'guest',
	'action' => 'login',
));

return $router;
