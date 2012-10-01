<?php
/**
 * Literal Framework
 */
namespace Literal\Routing\Exception;

use Literal\Common\Parameters\ArrayParameters;

/**
 * The Route interface
 */
class RouteNotFound extends \Exception
{
    protected $message = 'Route not found';
    protected $code = 404;
}
