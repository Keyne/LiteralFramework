<?php
/**
 * Literal Framework
 */
namespace Literal\Routing\Resolver;

use Literal\Common\Parameters\ArrayParameters;

/**
 * Resolver Interface
 * Determines the action to be called based on the route configuration.
 */
interface RouteResolverInterface
{
    /**
     * Checks if a given value matches the pattern.
     * If it matches, return the parameters (which can be empty).
     * @param string $str The string to match against the pattern
     * @param string $pattern The pattern to match against
     * @return ArrayParameters|bool
     */
    public function match($str, $pattern);

    /**
     * Replaces a given placeholder (from the route target definition) with its value
     * @param string $target
     * @param string $placeholder
     * @param string $value
     * @return string
     */
    public function replaceTargetParam($target, $placeholder, $value);


}
