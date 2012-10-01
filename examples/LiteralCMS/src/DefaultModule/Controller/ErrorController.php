<?php
/**
 * Literal Framework
 */

namespace LiteralCMS\DefaultModule\Controller;

use Literal\Controller\Controller,
    Literal\Controller\ErrorControllerInterface,
    Exception;


/**
 * MVC FrontController
 */
class ErrorController extends Controller implements ErrorControllerInterface
{
    /**
     * Handles the exception
     * @param Exception $e
     */
    public function errorAction(Exception $e)
    {
        echo sprintf('<h1>%s</h1><p>%s</p><pre>%s</pre>',
                     $e->getMessage(),
                     sprintf('<strong>%s</strong> on line <strong>%s</strong>',
                             $e->getFile(),
                             $e->getLine()),
                     $e->getTraceAsString());
    }
}
