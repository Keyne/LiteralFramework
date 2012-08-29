<?php
/**
 * Literal Framework
 */
namespace Literal\Autoloader;

/**
 * Simple autoloader for classes using namespaces within the standard directory structure.
 */
class ClassLoader
{
    private $namespaceMap = array();

    /**
     * Requires a given class
     * @param string $className
     * @throws \BadMethodCallException
     */
    public function load($className)
    {
        $classNameParts = explode('\\', $className);
        $namespace = array_shift($classNameParts);

        if(!isset($this->namespaceMap[$namespace])) {
            throw new \BadMethodCallException('Class not found: ' . $className);
        }

        $filePath = implode(DIRECTORY_SEPARATOR, $classNameParts);
        $filePath = $this->namespaceMap[$namespace] . DIRECTORY_SEPARATOR . $filePath . '.php';
        require $filePath;
    }

    public function registerNamespace($namespace, $path)
    {
        $this->namespaceMap[$namespace] = $path;
    }
}
