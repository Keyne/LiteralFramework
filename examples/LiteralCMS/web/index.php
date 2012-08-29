<?php
/* * * * * * * * * * * * * * * *
 * Literal Framework Bootstrap *
 * * * * * * * * * * * * * * * */

// Sets the error handler
error_reporting(-1);
set_time_limit(-1);

// Creates the autoloader class
require '../../../src/Literal/Autoloader/ClassLoader.php';
$classLoader = new \Literal\Autoloader\ClassLoader();

// Register the Literal Framework namespace
$classLoader->registerNamespace('Literal', realpath('../../../src/Literal/'));

// Register the LiteralCMS (sample application) namespace
$classLoader->registerNamespace('LiteralCMS', realpath('../src/'));

// Register the autoloader
spl_autoload_register(array($classLoader, 'load'));

// Creates the request factory
$applicationFactory = new Literal\Mvc\ApplicationFactory();

// Loads the application configuration
$config = include '../src/config/application.php';

// Builds the front controller
$frontController = $applicationFactory->buildFrontController($config);

// Dispatch the request
$frontController->dispatch();

echo sprintf('<h3>Request object</h3><p><strong>Path info:</strong> %s<br /><strong>Base path:</strong> %s</p>',
            $frontController->getRequest()->getPathInfo(),
            $frontController->getRequest()->getBasePath());