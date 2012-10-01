<?php
/* * * * * * * * * * * * * * * *
 * Literal Framework Bootstrap *
 * * * * * * * * * * * * * * * */

// Sets the error handler
error_reporting(-1);
set_time_limit(-1);

try {
    // Creates the autoloader class
    require '../../../src/Literal/Autoloader/ClassLoader.php';
    $classLoader = new \Literal\Autoloader\ClassLoader();

    // Register the Literal Framework namespace
    $classLoader->registerNamespace('Literal', realpath('../../../src/Literal/'));

    // Register the LiteralCMS (sample application) namespace
    $classLoader->registerNamespace('LiteralCMS', realpath('../src/'));

    // Register the autoloader
    $classLoader->registerAutoloader();

    // Loads the dependencies definitions and creates the injector
    $dependencies = include '../src/dependencies.config.php';
    $injector = new \Literal\Di\Injector($dependencies);

    // Creates the application factory
    $listenersFactory = new \Literal\Application\ListenersFactory($injector);

    // Configures the event handler
    $eventHandler = new \Literal\EventHandler\EventHandler($listenersFactory);
    $eventHandler->addListener('request.init', 'RequestListener');
    $eventHandler->addListener('route.init', 'RouterListener');
    $eventHandler->addListener('dispatch.send', 'DispatchListener');
    $eventHandler->addListener('dispatch.error', 'DispatchErrorListener');
    $eventHandler->addListener('response.init', 'ResponseListener');
    $eventHandler->addListener('response.send', 'ResponseListener');

    // Builds the front controller
    $frontController = new \Literal\Controller\FrontController($eventHandler);

    // Dispatch the request
    $frontController->dispatch();
} catch(Exception $e) {

    echo sprintf('<h1>%s</h1><p>%s</p><pre>%s</pre>',
                 $e->getMessage(),
                 sprintf('<strong>%s</strong> on line <strong>%s</strong>',
                         $e->getFile(),
                         $e->getLine()),
                 $e->getTraceAsString());

}