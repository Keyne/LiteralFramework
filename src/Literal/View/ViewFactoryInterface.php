<?php
/**
 * Literal Framework
 */
namespace Literal\View;

/**
 * View Factory interface
 */
interface ViewFactoryInterface
{
    /**
     * Builds the default view component
     * @param string $controller The controller callable
     * @return View
     */
    public function buildDefault($controller, $action);
}
