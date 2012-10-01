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
 * The request dispatcher listener
 */
class DispatchListener
{
    /**
     * Calls the target controller
     * @param RequestEvent $requestEvent
     * @return \Literal\Application\Event\RequestEvent
     */
    public function send(RequestEvent $requestEvent)
    {
        $request = $requestEvent->getRequest();
        $controller = $this->buildController($request->getOption('controller'), $request);
        $actionName = $request->getOption('action');

        $result = call_user_func_array(array($controller, $actionName), $requestEvent->getParametersArray());

        $requestEvent->setResult($result);

        return $requestEvent;
    }

    /**
     * Builds the controller
     * @param string $controllerName The controller name
     * @param \Literal\Http\Request $request
     * @return mixed
     */
    public function buildController($controllerName, Request $request)
    {
        /**
         * @var \Literal\Controller\Controller $controller
         */
        $controller = new $controllerName();
        $controller->setRequest($request);
        return $controller;
    }
}
