<?php
/**
 * Literal Framework
 */
namespace Literal\Controller;

use Exception;


/**
 * MVC FrontController
 */
interface ErrorControllerInterface
{
    /**
     * Handles the exception
     * @param Exception $e
     */
    public function errorAction(Exception $e);
}
