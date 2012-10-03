<?php
/**
 * Literal Framework
 */
namespace Literal\View;

use Literal\Di\Injector;

/**
 * View factory
 * It makes use of a DI component with the class definitions in order to create the view component
 */
class ViewFactory implements ViewFactoryInterface
{
    /**
     * @var Injector
     */
    private $injector;

    /**
     * @param \Literal\Di\Injector $injector
     */
    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    /**
     * Builds the application components by its names
     * @param string $class
     * @param array $args
     */
    public function buildDefault($controller, $action)
    {
        // Gets the controller file path
        $reflector = new \ReflectionClass($controller);
        $file = $reflector->getFileName();
        $controllerName = strtolower(str_replace('Controller', '', $reflector->getShortName()));
        $actionName = strtolower(str_replace('Action', '', $action));


        // Gets the module directory
        $ds = DIRECTORY_SEPARATOR;
        $dir = dirname($file);
        $dirParts = explode($ds, $dir);
        array_pop($dirParts);
        $moduleDir = implode($ds, $dirParts);

        // Resolves the view's template
        $templateFile = $moduleDir . $ds . 'templates' . $ds . $controllerName . $ds . $actionName . '.phtml';

        /**
         * Builds the view and sets its template
         * @var View $view
         */
        $view = $this->injector->build('View');
        $view->setTemplateFile($templateFile);

        return $view;
    }
}
