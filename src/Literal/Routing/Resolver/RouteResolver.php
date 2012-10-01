<?php
/**
 * Literal Framework
 */
namespace Literal\Routing\Resolver;

use Literal\Common\Parameters\ArrayParameters;

/**
 * Controller Resolver
 * It determines the class and action name to be called by the application based on the routing configuration.
 * Any namespace on the target string can be replaced by a given param.
 */
class RouteResolver implements RouteResolverInterface
{
    /**
     * Checks if a given value matches the pattern.
     * If it matches, return the parameters (which can be empty).
     * @param string $str The string to match against the pattern
     * @param string $pattern The pattern to match against
     * @return ArrayParameters|bool
     */
    public function match($str, $pattern)
    {
        /*
         * Replace the placeholders with a regex in order to check if the given string matches the route
         * i.e. /{controller}/{action} will be replaced by
         * /(?<controller>[A-Za-z0-9-_\.\+% ]+)/(?<action>[A-Za-z0-9-_\.\+% ]+)/
         */
        $replacePattern = '/{([A-Za-z0-9-_]+)}/';
        $regex = "(?<$1>[A-Za-z0-9-_\.\+% ]+)";
        $pattern = preg_replace($replacePattern, $regex, $pattern);

        // Now checks if it matches the route
        $pattern = str_replace('/', '\/', $pattern);
        preg_match(sprintf('/^%s\/?$/x', $pattern), $str, $matches);

        if($matches) {
            $parameters = new ArrayParameters($matches);
            return $parameters;
        }
        return false;
    }

    /**
     * Replaces a given placeholder (from the route target definition) with its value
     * @param string $target
     * @param string $placeholder
     * @param string $value
     * @return string
     */
    public function replaceTargetParam($target, $placeholder, $value)
    {
        $value = $this->normalizeTargetParam($value);

        $placeholder = sprintf('{%s}', $placeholder);
        $resolvedTarget = str_replace($placeholder, $value, $target);

        return $resolvedTarget;
    }

    /**
     * Normalizes the placeholder value changing the first letter to camel case
     * and also any words beginning after an hyphen or underline
     *
     * @param $string
     * @param bool $capitalizeFirstCharacter
     * @return array|mixed
     */
    private function normalizeTargetParam($string, $capitalizeFirstCharacter = false)
    {
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);

        $str = str_replace(' ', '', ucwords($string));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}
