<?php
/**
 * Literal Framework
 */
namespace Literal\Application\Listener;

use Literal\Http\Request,
    Literal\Http\ServerParameters,
    Literal\Application\Event\RequestEvent,
    Literal\Common\Parameters\ArrayParameters;

/**
 * Request builder listener
 */
class RequestListener
{
    /**
     * Initializes the request
     * @param \Literal\Application\Event\RequestEvent $requestEvent
     * @return RequestEvent
     */
    public function init(RequestEvent $requestEvent)
    {
        $serverParameters = $this->buildServerParameters($_SERVER);
        $request = $this->buildRequest($serverParameters);
        $requestEvent->setRequest($request);

        return $requestEvent;
    }

    /**
     * Builds the request object
     * @param \Literal\Http\ServerParameters $serverParameters
     * @return \Literal\Http\Request
     */
    public function buildRequest(ServerParameters $serverParameters)
    {
        $getParams = new ArrayParameters();
        $getParams->exchangeArray($_GET);

        $postParams = new ArrayParameters();
        $postParams->exchangeArray($_POST);

        $filesParams = new ArrayParameters();
        $filesParams->exchangeArray($_FILES);

        $sessionParams = new ArrayParameters();
        if(isset($_SESSION)) {
            $sessionParams->exchangeArray($_SESSION);
        }

        $cookiesParams = new ArrayParameters();
        if(isset($_COOKIE)) {
            $cookiesParams->exchangeArray($_COOKIE);
        }

        $request = new Request($serverParameters);
        $request->load($getParams, $postParams, $filesParams, $serverParameters, $cookiesParams);

        return $request;
    }

    /**
     * Returns the server parameters
     * @param array $parameters
     * @return ServerParameters
     */
    public function buildServerParameters(array $parameters)
    {
        $serverParameters = new ServerParameters($parameters);
        return $serverParameters;
    }
}
