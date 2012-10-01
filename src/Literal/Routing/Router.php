<?php
/**
 * Literal Framework
 */
namespace Literal\Routing;

use Literal\Http\Request,
    Literal\Common\Parameters\ArrayParameters,
    Literal\Routing\Resolver\RouteResolverInterface,
    Literal\Routing\Route\Route,
    Literal\Routing\Exception\RouteNotFound;

/**
 * The router component
 */
class Router implements RouterInterface
{
    /**
     * @var ArrayParameters The available routes
     */
    private $routes;

    /**
     * @var RouteResolverInterface The default route resolver
     */
    private $defaultRouteResolver;

    /**
     * @param ArrayParameters $routes
     * @param RouteResolverInterface $defaultRouteResolver
     */
    public function __construct(ArrayParameters $routes = null, RouteResolverInterface $defaultRouteResolver = null)
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
     * @throws RouteNotFound
     * @return Route
     */
    public function getRequestRoute(Request $request) {
        foreach($this->routes as $route) {
            /**
             * Checks if the route matches the pattern.
             * @var Route $route
             * @var RouteResolverInterface $routeResolver
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
                $route->resolveTarget();
                return $route;
            }
        }

        throw new RouteNotFound('No matching routes found for: ' . $request->getPathInfo());
    }

    /**
     * @throws \RuntimeException
     * @return \Literal\Routing\RouteResolverInterface
     */
    public function getDefaultRouteResolver()
    {
        if(!$this->defaultRouteResolver) {
            throw new \RuntimeException('Default route resolver not set');
        }
        return $this->defaultRouteResolver;
    }

    /**
     * @param RouteResolverInterface $defaultRouteResolver
     * @return Router
     */
    public function setDefaultRouteResolver(RouteResolverInterface $defaultRouteResolver)
    {
        $this->defaultRouteResolver = $defaultRouteResolver;
        return $this;
    }


}
