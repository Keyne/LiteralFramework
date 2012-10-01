<?php
/**
 * Literal Framework
 */
namespace Literal\Controller;

use Literal\EventHandler\EventHandler,
    Literal\Http\Request,
    Literal\Http\Response,
    Literal\Common\Parameters\ArrayParameters;


/**
 * MVC FrontController
 */
class Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $eventHandler
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Literal\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
