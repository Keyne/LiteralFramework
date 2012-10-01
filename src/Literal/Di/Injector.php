<?php
/**
 * Literal Framework
 */
namespace Literal\Di;

use ReflectionClass;

/**
 * Dependency Injection Reflector
 * Can load objects automatically (type hint) and with an array with the classes definition.
 */
class Injector
{
    /**
     * @var Definitions Dependency definitions
     */
    private $definitions;

    /**
     * @var Parameters The optional application parameters
     */
    private $parameters;

    /**
     * Initializes the injector with the dependency definitions
     * @param Definitions $definitions
     * @param Parameters $parameters
     */
    public function __construct(Definitions $definitions = null, Parameters $parameters = null)
    {
        $this->definitions = $definitions;
        $this->parameters = ($parameters)?: new Parameters();
    }

    /**
     * @param Parameters $parameters
     */
    public function setParameters(Parameters $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Builds an object with its dependencies
     * @param string $name
     * @param array $args The object parameters
     * @throws \InvalidArgumentException
     * @return object|mixed
     */
    public function build($name, array $args = array())
    {
        $dependencies = $this->definitions->getDependencies();
        if (!isset($dependencies[$name])) {
            $result = $this->buildFromCallable($name, $args);
        } else {
            $definition = $dependencies[$name];
            if($definition instanceof \Closure) {
                /**
                 * @var \Closure $definition
                 */
                $result = $definition($this);
            } elseif(isset($definition['class'])) {
                /**
                 * @var array $definition
                 */
                $result = $this->buildFromDefinition($definition, $args);
            } else {
                throw new \UnexpectedValueException('Unable to load class definition: ' . $name);
            }
        }
        return $result;
    }

    /**
     * @param array $definition
     * @param array $args
     * @return object
     */
    public function buildFromDefinition(array $definition, array $args = array())
    {
        // Tries to instantiate the object using reflection
        $reflector  = new ReflectionClass($definition['class']);

        if(isset($definition['constructor']) && is_array($definition['constructor'])) {
            foreach($definition['constructor'] as $constructorParam => $value) {
                if($this->definitions->isDefinition($value)) {
                    $definitionKey = substr($value, 1, strlen($value)); // Removes the @
                    $args[$constructorParam] = $this->build($definitionKey, $args);
                } elseif($this->parameters->isParameter($value)) {
                    $args[$constructorParam] = $this->parameters->get($value);
                }
            }
        }

        $args = $this->parseArguments($reflector, $args);
        $object = $reflector->newInstanceArgs($args);

        // TODO: Setters initialization

        return $object;
    }

    /**
     * @param string $callable
     * @param array $args
     * @return object
     * @throws \InvalidArgumentException
     */
    public function buildFromCallable($callable, array $args = array())
    {
        // If the dependency definitions doesn't exists, checks if it's a callable
        if(!class_exists($callable)) {
            throw new \InvalidArgumentException(sprintf('Injector: Unable to load "%s" class.', $callable));
        }

        $reflector  = new ReflectionClass($callable);
        $dependencies = $this->parseArguments($reflector, $args);

        // Instantiates the object
        $object = $reflector->newInstanceArgs($dependencies);

        return $object;
    }

    /**
     * @param ReflectionClass $reflector
     * @param array $args
     * @return array The parsed parameters
     */
    public function parseArguments(ReflectionClass $reflector, $args = array())
    {
        // Maps the constructor args within the provided parameters
        $objectConstructor = $reflector->getConstructor();

        $objectParams = ($objectConstructor) ? $objectConstructor->getParameters() : array();


        $constructorParams = array();
        foreach($objectParams as $param) {
            if(isset($args[$param->getName()])) {
                $constructorParams[$param->getName()] = $args[$param->getName()];
            }
        }

        return $constructorParams;
    }

    /**
     * Sets a definition
     * @param string $name
     * @param \Closure|string $definition
     */
    public function set($name, $definition)
    {
        $this->definitions[$name] = $definition;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasDefinition($name) {
        return (array_key_exists($name, $this->definitions));
    }
}
