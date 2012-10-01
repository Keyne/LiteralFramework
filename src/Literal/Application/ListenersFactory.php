<?php
/**
 * Literal Framework
 */
namespace Literal\Application;

use Literal\Di\Injector;

/**
 * Generic application factory
 * It makes use of a DI component with the class definitions in order to populate objects
 */
class ListenersFactory implements FactoryInterface
{
    /**
     * @var Injector
     */
    private $injector;

    /**
     * @param \Literal\Di\Injector $injector
     */
    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    /**
     * Builds the application components by its names
     * @param string $class
     * @param array $args
     */
    public function build($class, array $args = array())
    {
        return $this->injector->build($class, $args);
    }
}
