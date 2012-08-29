<?php
/**
 * Literal Framework
 */
namespace Literal\Routing;

use \Literal\Http\Request,
    Literal\Common\Parameters\ArrayParameters;

/**
 * The router component
 */
class Router
{
    /**
     * @var ArrayParameters The available routes
     */
    private $routes;

    /**
     * @var RouteResolver The default route resolver
     */
    private $defaultRouteResolver;

    /**
     * @param ArrayParameters $routes
     * @param RouteResolver $defaultRouteResolver
     */
    public function __construct(ArrayParameters $routes = null, RouteResolver $defaultRouteResolver = null)
    {
        if(!$routes) {
            $routes = new ArrayParameters();
        }
        $this->setRoutes($routes);

        if($defaultRouteResolver) {
            $this->defaultRouteResolver = $defaultRouteResolver;
        }
    }

    /**
     * Sets the routes
     * @param ArrayParameters $routes
     */
    public function setRoutes(ArrayParameters $routes) {
        $this->routes = $routes;
    }

    /**
     * Returns the routes
     * @return array
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * Adds a new route
     * @param Route $route
     */
    public function addRoute(Route $route) {
        $this->routes[] = $route;
    }

    /**
     * Returns the routing matching the request
     * @param Request $request
     * @throws \InvalidArgumentException
     * @return Route
     */
    public function process(Request $request) {
        foreach($this->routes as $route) {
            /**
             * Checks if the route matches the pattern.
             * @var Route $route
             * @var RouteResolver $routeResolver
             */
            $routeResolver = $route->getRouteResolver();
            if(!$routeResolver) {
                $routeResolver = $this->getDefaultRouteResolver();
                $route->setRouteResolver($routeResolver);
            }

            $matches = $routeResolver->match($request->getPathInfo(), $route->getPattern());
            // If yes, sets the parameters
            if($matches) {
                $route->setParameters($matches);
                return $route;
            }
        }

        // TODO: Throws an RouteNotFoundException
        throw new \InvalidArgumentException('No matching routes found for: ' . $request->getPathInfo());
    }

    /**
     * @throws \RuntimeException
     * @return \Literal\Routing\RouteResolver
     */
    public function getDefaultRouteResolver()
    {
        if(!$this->defaultRouteResolver) {
            throw new \RuntimeException('Default route resolver not set');
        }
        return $this->defaultRouteResolver;
    }

    /**
     * @param RouteResolver $defaultRouteResolver
     * @return Router
     */
    public function setDefaultRouteResolver(RouteResolver $defaultRouteResolver)
    {
        $this->defaultRouteResolver = $defaultRouteResolver;
        return $this;
    }


}
