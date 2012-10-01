<?php
/**
 * Literal Framework
 */
namespace Literal\Controller;

use Literal\EventHandler\EventHandler,
    Literal\Http\Response;

/**
 * Provides a single entry point for the whole application.
 */
interface FrontControllerInterface
{
    /**
     * @param EventHandler $eventHandler
     */
    public function __construct(EventHandler $eventHandler);

    /**
     * @return Response
     */
    public function processRequest();

    /**
     * Calls the processRequest() method and sends the response to the browser
     */
    public function dispatch();
}