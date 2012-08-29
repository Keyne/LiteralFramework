<?php
/**
 * Literal Framework
 */
namespace Literal\Routing;

use Literal\Common\Parameters\ArrayParameters;

/**
 * The Route class representing a pattern to match and the target
 *
 * E.g.
 *
 * a) Default route
 * Pattern: "^\/(?P<controller>[a-z0-9-]+)/(?P<action>[a-z0-9-]+)"
 * Target: "{controller}::{action}"
 *
 * b) Custom route
 * Pattern: "^/:username"
 * Target: "UsersController::viewAction"
 *
 */
class Route
{
    /**
     * @var RouteResolverInterface The route resolver
     */
    private $routeResolver;

    /**
     * @var string The pattern to match
     */
    private $pattern;

    /**
     * @var string The target controller
     */
    private $target;

    /**
     * @var RouteTargetBuilderInterface Builder responsible for creating the target object
     */
    private $routeTargetBuilder;

    /**
     * @var string The resolve target (with its placeholders replaced if any)
     */
    private $resolvedTarget;

    /**
     * @var ArrayParameters The query string from the request uri
     */
    private $parameters;

    /**
     * @var ArrayParameters The query string from the request uri
     */
    private $filteredParameters;

    /**
     * Initializes the route
     * @param string $pattern
     * @param string $target
     * @param RouteResolverInterface|null $routerResolver
     */
    public function __construct($pattern,
                                $target,
                                RouteTargetBuilderInterface $routeTargetBuilder = null,
                                RouteResolverInterface $routerResolver = null)
    {
        $this->pattern = $pattern;
        $this->target  = $target;

        if($routeTargetBuilder) {
            $this->routeTargetBuilder = $routeTargetBuilder;
        }

        if($routerResolver) {
            $this->routerResolver = $routerResolver;
        }
    }

    /**
     * @return RouteResolverInterface
     */
    public function getRouteResolver()
    {
        return $this->routeResolver;
    }

    /**
     * @param RouteResolverInterface $routerResolver
     * @return $this
     */
    public function setRouteResolver(RouteResolverInterface $routerResolver)
    {
        $this->routeResolver = $routerResolver;
        return $this;
    }

    /**
     * @return RouteResolverInterface|null
     */
    public function getRouteTargetBuilder()
    {
        return $this->routeTargetBuilder;
    }

    /**
     * @param RouteResolverInterface $routerResolver
     * @return $this
     */
    public function setRouteTargetBuilder(RouteTargetBuilderInterface $builder)
    {
        $this->routeTargetBuilder = $builder;
        return $this;
    }

    /**
     * Returns the route pattern
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Returns the route target
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return ArrayParameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param ArrayParameters $parameters
     */
    public function setParameters(ArrayParameters $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return ArrayParameters
     */
    public function getFilteredParameters()
    {
        return $this->filteredParameters;
    }

    /**
     * Resolves the target and filter its parameters
     * @param string $target
     * @param array $params
     */
    public function resolveTarget()
    {
        // Sets the resolved target (and than checks if there's any placeholder to replace)
        $this->resolvedTarget = $this->target;

        // Clones the parameters and then...
        $filteredParams = $this->parameters;

        // ... resolves placeholders if any
        $indexesToRemove = array();
        foreach($this->parameters as $placeholder => $placeholderValue) {
            if(preg_match("/\{$placeholder\}/", $this->target)) {
                // Resolves the target
                $this->resolvedTarget = $this->routeResolver->replaceTargetParam($this->resolvedTarget, $placeholder, $placeholderValue);
                // Removes the placeholder parameter from the filtered parameters array
                $indexesToRemove[] = $placeholder;
            }
        }

        // Sets the filtered parameters
        foreach($indexesToRemove as $index) {
            $filteredParams->offsetUnset($index);
        }
        $this->filteredParameters = $filteredParams;

        return $this->resolvedTarget;
    }
}
