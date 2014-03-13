<?php

namespace NagatoPHP\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface {

    /**
     * Registers the module auto-loader
     */
    public function registerAutoloaders() {

        $loader = new Loader();

        $loader->registerNamespaces(array(
            'NagatoPHP\Frontend\Controllers' => __DIR__ . '/controllers/',
            'NagatoPHP\Models' => __DIR__ . '/../models/',
            'NagatoPHP\Common' => __DIR__ . '/../common/',
        ));

        $loader->register();
    }

    /**
     * Registers the module-only services
     *
     * @param Phalcon\DI $di
     */
    public function registerServices($di) {

        /**
         * Setting up the view component
         */
        $di['view'] = function () {
			$view = new View();
			$view->setViewsDir(__DIR__ . '/views/');
			$view->registerEngines(array(
				'.volt' => function ($view, $di) {
					$volt = new VoltEngine($view, $di);
					$volt->setOptions(array(
						'compiledPath' => __DIR__ . '/cache/',
						'compiledSeparator' => '_' 
					)); 

					return $volt;
				},  
					'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
				)); 

			return $view;
        };
    }
}
