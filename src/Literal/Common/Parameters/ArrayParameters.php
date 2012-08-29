<?php
/**
 * Literal Framework
 */
namespace Literal\Common\Parameters;

use \ArrayObject;

/**
 * Common library - Parameters Object
 *
 * Provides access to parameters in an object-oriented way.
 */
class ArrayParameters extends ArrayObject implements ParametersInterface
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = null)
    {
        $parameters = ($parameters) ?: array();
        parent::__construct($parameters, ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * @param string $parameterName
     * @param mixed $default
     * @return mixed
     */
    public function get($parameterName, $default = null)
    {
        if (isset($this[$parameterName])) {
            return parent::offsetGet($parameterName);
        }

        return $default;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function set($name, $value)
    {
        $this[$name] = $value;
        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->exchangeArray($parameters);
        return $this;
    }
}
