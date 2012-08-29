<?php
/* * * * * * * * * * * * * *
 *  Routing configuration  *
 * * * * * * * * * * * * * */

use Literal\Routing\Route;

$routes = array(
    'default' => new Route('/{controller}/{action}', '\LiteralCMS\UserModule\Controller\{controller}Controller::{action}Action'),
    'index' => new Route('/', '\LiteralCMS\UserModule\Controller\IndexController::indexAction'),
    'test' => new Route('/test', '\LiteralCMS\UserModule\Controller\IndexController::testAction')
);

return new \Literal\Common\Parameters\ArrayParameters($routes);