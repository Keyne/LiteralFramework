<?php
/**
 * Literal Framework
 */
namespace Literal\Application\Listener;

use Literal\Http\Request,
    Literal\Routing\Router,
    Literal\Http\ServerParameters,
    Literal\Application\Event\RequestEvent;

/**
 * Route resolver listener
 */
class RouterListener
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Resolves the route
     * @param RequestEvent $requestEvent
     * @return RequestEvent
     */
    public function init(RequestEvent $requestEvent)
    {
        $route = $this->router->getRequestRoute($requestEvent->getRequest());
        $target = $route->getResolvedTarget();
        $params = $route->getFilteredParameters();

        $request = $requestEvent->getRequest();

        // Sets the URI parameters
        foreach($params as $key => $param) {
            $request->setQuery($key, $params);
        }

        // Sets the controller and action name
        $class = explode('::', $target);
        $request->setOption('controller', $class[0]);
        $request->setOption('action', $class[1]);

        return $requestEvent;
    }
}
