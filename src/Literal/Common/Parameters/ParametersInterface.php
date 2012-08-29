<?php
/**
 * Literal Framework
 */
namespace Literal\Common\Parameters;

/**
 * Common library - Parameters Object
 *
 * Provide access to collection of parameters (usually an array) in an object-oriented way.
 */
interface ParametersInterface
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = null);

    /**
     * @abstract
     * @param string $parameterName
     * @param string $default
     * @return mixed
     */
    public function get($parameterName, $default = null);

    /**
     * @abstract
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function set($name, $value);

    /**
     * @abstract
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters);
}
