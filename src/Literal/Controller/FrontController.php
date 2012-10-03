<?php
/**
 * Literal Framework
 */
namespace Literal\Controller;

use Literal\EventHandler\EventHandler,
    Literal\Application\Event\RequestEvent,
    Literal\Http\Response,
    Literal\Common\Parameters\ArrayParameters;


/**
 * MVC FrontController
 */
class FrontController implements FrontControllerInterface
{
    /**
     * @var EventHandler
     */
    private $eventHandler;

    /**
     * @param EventHandler $eventHandler
     */
    public function __construct(EventHandler $eventHandler)
    {
        $this->eventHandler = $eventHandler;
    }

    /**
     * Factory method: Returns the request event
     * @return Event\RequestEvent
     */
    public function buildRequestEvent()
    {
        $requestEvent = new RequestEvent();

        return $requestEvent;
    }

    /**
     * @return Response
     */
    public function processRequest()
    {
        // Creates the request event
        $requestEvent = $this->buildRequestEvent();

        // Mounts the signals chain
        // (all signals are included with exception of dispatch.error and response.send, which is handled at the end
        // of this code)
        $signals = array(
            'request.init', // Starts the request
            'route.init', // Resolves the request route
            'dispatch.send', // Dispatches the request
            'response.init', // Prepares the response
        );

        // Sends the signals
        try {
            foreach($signals as $signal) {
                $result = $this->eventHandler->trigger($signal, $requestEvent);

                // Short-circuit the chain if the listener returns a response object
                if($result instanceof Response) {
                    break;
                }
            }
        } catch(\Exception $e) {
            // Sets the request exception
            $requestEvent->setException($e);

            // Handles the exception
            $this->eventHandler->trigger('dispatch.error', $requestEvent);
        }

        // Sends the response
        $this->eventHandler->trigger('response.send', $requestEvent);
    }

    /**
     * Dispatches the request and sends the response to the browser
     * (Just a proxy method)
     */
    public function dispatch()
    {
        $this->processRequest();
    }
}
