<?php
/**
 * Literal Framework
 */
namespace Literal\Application;

use Literal\Di\Injector;

/**
 * Factory interface
 */
interface FactoryInterface
{
    /**
     * Builds the application components by its names
     * @param string $class
     * @param array $args
     * @return object|mixed
     */
    public function build($class, array $args = array());
}
