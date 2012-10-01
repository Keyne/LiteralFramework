<?php
/**
 * Literal Framework
 */
namespace Literal\Di;

use  \Literal\Common\Parameters\ArrayParameters;

/**
 * The injector definitions
 */
class Parameters extends ArrayParameters
{
    /**
     * Checks if a given string is a valid parameter placeholder
     * @param string $definition
     * @return bool
     */
    public function isParameter($parameter)
    {
        if(preg_match('/^%[a-zA-Z-_\.]+%$/', $parameter)) {
            return true;
        }
        return false;
    }
}
