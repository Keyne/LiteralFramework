<?php
/**
 * Literal Framework
 */
namespace Literal\Application\Event;

use Literal\EventHandler\AbstractEvent,
    Literal\Http\Request,
    Literal\Http\Response,
    Literal\Http\ServerParameters,
    Literal\Common\Parameters\ArrayParameters;

/**
 * Route request event
 */
class RequestEvent extends AbstractEvent
{
    /**
     * @var Request
     */
    private $request;

    /**
     * A PHP callable string
     * @var string
     */
    private $target;

    /**
     * @var ArrayParameters
     */
    private $parameters;

    /**
     * @var mixed The request result
     */
    private $result;

    /**
     * @var Response The http response
     */
    private $response;

    /**
     * @var \Exception The request exception if any
     */
    private $exception;

    /**
     * Initializes the object
     */
    public function __construct()
    {
        $this->parameters = new ArrayParameters();
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Sets the request target
     * @param string $target
     * @throws \RuntimeException
     * @return void
     */
    public function setTarget($target)
    {
        if(!is_callable($target)) {
            throw new \RuntimeException('The target "%s" is not a PHP callable.');
        }

        $this->target = $target;
    }

    /**
     * @return string A PHP callable
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets the request parameters
     * @param ArrayParameters $parameters
     */
    public function setParameters(ArrayParameters $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the request parameters
     * @return ArrayParameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Returns the request parameters
     * @return array
     */
    public function getParametersArray()
    {
        return $this->parameters->getArrayCopy();
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return RequestEvent
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return \Literal\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @return RequestEvent
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param \Exception $exception
     * @return RequestEvent
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
        return $this;
    }
}
