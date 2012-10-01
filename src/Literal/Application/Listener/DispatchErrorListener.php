<?php
/**
 * Literal Framework
 */
namespace Literal\Application\Listener;

use Literal\Http\Request,
    Literal\Http\Response,
    Literal\Routing\Exception\RouteNotFound,
    Literal\Application\Event\RequestEvent,
    Literal\Controller\ErrorControllerInterface ;

/**
 * The request dispatcher listener
 */
class DispatchErrorListener
{
    private $errorController;

    /**
     * @param $errorController
     * @throws \InvalidArgumentException
     */
    public function __construct(ErrorControllerInterface $errorController)
    {
        $this->errorController = $errorController;
    }

    /**
     * Calls the error controller
     * @param RequestEvent $requestEvent
     * @return \Literal\Application\Event\RequestEvent
     */
    public function error(RequestEvent $requestEvent)
    {
        $controller = $this->buildController($this->errorController);
        $actionName = 'errorAction';

        $exception = $requestEvent->getException();
        $result = call_user_func_array(array($controller, $actionName), array('exception' => $exception));

        $requestEvent->setResult($result);

        // Initializes the response with the error status code
        $response = $this->buildErrorResponse($exception);
        $requestEvent->setResponse($response);

        return $requestEvent;
    }

    /**
     * Builds the error response
     * @param \Exception $exception
     * @return mixed
     */
    public function buildErrorResponse($exception)
    {
        $response = new Response();

        if($exception instanceof RouteNotFound) {
            $code = $exception->getCode();
            $response->setStatusCode($code);
        } else {
            $response->setStatusCode(500);
        }

        return $response;
    }

    /**
     * Builds the controller
     * @param string $controllerName The controller name
     * @return mixed
     */
    public function buildController($controllerName)
    {
        $controller = new $controllerName();
        return $controller;
    }
}
