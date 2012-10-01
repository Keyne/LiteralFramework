<?php
/**
 * Literal Framework
 */
namespace Literal\Routing;

use \Literal\Http\Request,
    Literal\Common\Parameters\ArrayParameters,
    Literal\Routing\Resolver\RouteResolverInterface,
    Literal\Routing\Route\Route;

/**
 * The router component
 */
interface RouterInterface
{
    /**
     * @param ArrayParameters $routes The routes collection
     * @param RouteResolverInterface $defaultRouteResolver The default route resolver
     */
    public function __construct(ArrayParameters $routes = null, RouteResolverInterface $defaultRouteResolver = null);

    /**
     * Sets the routes
     * @param ArrayParameters $routes
     */
    public function setRoutes(ArrayParameters $routes);

    /**
     * Returns the routes
     * @return array
     */
    public function getRoutes();

    /**
     * Adds a new route
     * @param Route $route
     */
    public function addRoute(Route $route);

    /**
     * Returns the routing matching the request
     * @param Request $request
     * @throws \InvalidArgumentException
     * @return Route
     */
    public function getRequestRoute(Request $request);

    /**
     * Returns the default route resolver in order to check if a given route matches the URI
     * (The default will not be used in case the the route has its own resolver)
     * @throws \RuntimeException
     * @return \Literal\Routing\Resolver\RouteResolver
     */
    public function getDefaultRouteResolver();

    /**
     * @param RouteResolverInterface $defaultRouteResolver
     * @return Router
     */
    public function setDefaultRouteResolver(RouteResolverInterface $defaultRouteResolver);
}
