<?php
/* * * * * * * * * * * * * *
 *  Routing configuration  *
 * * * * * * * * * * * * * */

use Literal\Routing\Route\Route;

$routes = array(
    'default' => new Route('/{controller}/{action}', '\LiteralCMS\DefaultModule\Controller\{controller}Controller::{action}Action'),
    'index' => new Route('/', '\LiteralCMS\DefaultModule\Controller\IndexController::indexAction'),
    'test' => new Route('/test', '\LiteralCMS\DefaultModule\Controller\IndexController::testAction')
);

return new \Literal\Common\Parameters\ArrayParameters($routes);