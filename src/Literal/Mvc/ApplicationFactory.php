<?php
/**
 * Literal Framework
 */
namespace Literal\Mvc;

use \Literal\Http\Request,
    \Literal\Http\ServerParameters,
    \Literal\Common\Parameters\ArrayParameters;

/**
 * Application Factory
 *
 * Initializes the application FrontController with its dependencies and provides separated builders for each
 * of the necessary components, such as the request, router, view resolver and view renderer objects.
 */
class ApplicationFactory
{
    /**
     * Builds the request object
     * @return Request
     */
    public function buildRequest()
    {
        $serverParameters = $this->buildServerParameters();

        $request = new Request($serverParameters);
        $request->load($_GET, $_POST, $_FILES, $_COOKIE);

        return $request;
    }

    /**
     * Builds the front controller
     * @return \Literal\Mvc\FrontController
     */
    public function buildFrontController(ArrayParameters $config)
    {
        // Builds the request
        $request = $this->buildRequest();

        // Builds the router
        if(!file_exists($config->routes)) {
            throw new \InvalidArgumentException('Routes configuration not found in path: ' , $config->routes);
        }
        $routes = include $config->routes;
        $router = $this->buildRouter($routes);

        // Creates the view factory
        $viewFactory = new \Literal\View\ViewFactory();

        // Builds the FrontController
        $frontController = new \Literal\Mvc\FrontController($config);
        $frontController->setRequest($request)
                        ->setRouter($router)
                        ->setViewFactory($viewFactory);

        return $frontController;
    }

    /**
     * @param ArrayParameters $routes
     * @return \Literal\Routing\Router
     */
    public function buildRouter(ArrayParameters $routes)
    {
        $router = new \Literal\Routing\Router($routes);

        // Sets the default route resolver
        $routeResolver = $this->buildDefaultRouteResolver();
        $router->setDefaultRouteResolver($routeResolver);

        return $router;
    }

    /**
     * @return \Literal\Routing\RouteResolver
     */
    public function buildDefaultRouteResolver()
    {
        $routeResolver = new \Literal\Routing\RouteResolver();
        return $routeResolver;
    }

    /**
     * Builds the server parameters object
     * @return ServerParameters
     */
    public function buildServerParameters()
    {
        $serverParameters = new ServerParameters($_SERVER);
        return $serverParameters;
    }
}
