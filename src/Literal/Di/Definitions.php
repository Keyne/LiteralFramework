<?php
/**
 * Literal Framework
 */
namespace Literal\Di;

use  \Literal\Common\Parameters\ArrayParameters;

/**
 * The injector definitions
 */
class Definitions extends ArrayParameters
{
    /**
     * Checks if a given string is a valid definition placeholder
     * @param string $definition
     * @return bool
     */
    public function isDefinition($definition)
    {
        if(preg_match('/^@.*/', $definition)) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getDependencies()
    {
        return $this->offsetGet('dependencies');
    }
}
