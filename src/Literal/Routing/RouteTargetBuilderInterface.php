<?php
/**
 * Literal Framework
 */
namespace Literal\Routing;

/**
 * Builds the route target class (e.g. A controller with its services)
 */
interface RouteTargetBuilderInterface
{
    /**
     * Builds the route target class
     * @return Object
     */
    public function buildTarget();
}
