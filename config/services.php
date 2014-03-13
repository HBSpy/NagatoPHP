<?php

/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Flash\Session as Flash;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Backend\Xcache as XcacheBackend;
use Phalcon\Security;

/**
 * FactoryDefault
 */
$di = new FactoryDefault();

/**
 * Router from routes.php
 */
$di['router'] = function () {

    $router = include __DIR__ . '/routes.php';

    return $router;
};

/**
 * URL
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/NagatoPHP/');

    return $url;
};

/**
 * Session
 */
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
};

/**
 * Flash 
 */
$di['flash'] = function () {
	$flash = new Flash(array(
		'error' => 'alert alert-danger',
		'success' => 'alert alert-success',
		'warning' => 'alert alert-warning',
		'notice' => 'alert alert-info',
	));

	return $flash;
};

/**
 * Cache with XCache
 */
$di['cache'] = function () {
	$datafront = new DataFrontend();
	$cache = new XcacheBackend($datafront, array(
		'prefix' => '_nagato',
	));

	return $cache;
};

/**
 * Security
 */
$di['security'] = function () {
	$security = new Security();

	return $security;
};

/**
 * Ajax
 */
$di['ajax'] = function () {
	$ajax = new NagatoPHP\Common\Ajax();

	return $ajax;
};

/**
 * Db
 */
$di['db'] = function () {
	return new DbAdapter(array(
		"host" => '127.0.0.1',
		"username" => 'root',
		"password" => 'byrdev123!@#',
		"dbname" => 'NagatoPHP',
	));
};
