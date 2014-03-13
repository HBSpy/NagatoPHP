<?php

/**
 * Register application modules
 */
$application->registerModules(array(
    'frontend' => array(
        'className' => 'NagatoPHP\Frontend\Module',
        'path' => __DIR__ . '/../apps/frontend/Module.php'
	),
    'backend' => array(
        'className' => 'NagatoPHP\Backend\Module',
        'path' => __DIR__ . '/../apps/backend/Module.php'
    )
));
