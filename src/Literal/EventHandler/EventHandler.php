<?php
/**
 * Literal Framework
 */
namespace Literal\EventHandler;

use Literal\Di\Injector,
    Literal\Http\Response,
    Literal\Application\FactoryInterface;

/**
 * Event Handler - Dispatches events and notify observers
 */
class EventHandler
{
    /**
     * @var FactoryInterface
     */
    private $listenersFactory;

    /**
     * @var array The listeners list for each event type
     */
    private $listeners = array();

    /**
     * @param FactoryInterface $listenersFactory
     */
    public function __construct(FactoryInterface $listenersFactory)
    {
        $this->listenersFactory = $listenersFactory;
    }

    /**
     * @param string $eventName
     * @param AbstractEvent $event
     * @return bool|AbstractEvent
     */
    public function trigger($eventName, AbstractEvent $event)
    {
        if(!isset($this->listeners[$eventName])) {
            return false;
        }
        foreach($this->listeners[$eventName] as $listenerPriority) {
            // Loop through the listeners priorities
            foreach($listenerPriority as $listener) {
                $listener = $this->buildListener($listener, $event);
                $eventParts = explode('.', $eventName);
                $method = end($eventParts);
                $result = call_user_func(array($listener, $method), $event);

                // Short-circuit the chain if the listener returns a response object
                if($result instanceof Response) {
                    return $result;
                }
            }
        }
        return $event;
    }

    /**
     * @var string The callable string
     * @return mixed
     */
    public function buildListener($listener, AbstractEvent $event)
    {
        $listener = $this->listenersFactory->build($listener, array('%event%' => $event));
        return $listener;
    }

    /**
     * @param string $eventName The event name following a dot and the method to be executed (i.e eventName.methodName)
     * @param string $listener The class name to be passed as parameter to the factory
     * @param int $priority
     * @throws \RuntimeException
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->listeners[$eventName][$priority][] = $listener;
        ksort($this->listeners[$eventName]);
    }
}