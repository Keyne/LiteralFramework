<?php
/**
 * Literal Framework
 */
namespace Literal\Routing\Route;


use Literal\Common\Parameters\ArrayParameters,
    Literal\Routing\Resolver\RouteResolverInterface;

/**
 * The Route interface
 */
interface RouteInterface
{
    /**
     * Initializes the route
     * @param string $pattern
     * @param string $target
     * @param RouteResolverInterface|null $routerResolver
     */
    public function __construct($pattern,
                                $target,
                                RouteResolverInterface $routerResolver = null);

    /**
     * Returns the route pattern
     * @return string
     */
    public function getPattern();

    /**
     * Returns the route target
     * @return string
     */
    public function getTarget();

    /**
     * @return ArrayParameters
     */
    public function getParameters();

    /**
     * @param ArrayParameters $parameters
     */
    public function setParameters(ArrayParameters $parameters);

    /**
     * @return ArrayParameters
     */
    public function getFilteredParameters();

    /**
     * @return string The target class
     */
    public function getResolvedTarget();

    /**
     * Resolves the target and filter its parameters
     * @param string $target
     * @param array $params
     */
    public function resolveTarget();

    /**
     * @return RouteResolverInterface
     */
    public function getRouteResolver();

    /**
     * @param RouteResolverInterface $routerResolver
     * @return $this
     */
    public function setRouteResolver(RouteResolverInterface $routerResolver);
}
