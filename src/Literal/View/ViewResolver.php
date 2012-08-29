<?php
/**
 * Literal Framework
 */
namespace Literal\View;

use \Literal\Common\Parameters\ArrayParameters;

/**
 * View Resolver
 * By default, it determines the view file to be rendered by the application based on the target controller.
 */
class ViewResolver
{
    /**
     * @var ArrayParameters
     */
    private $addressee;

    /**
     * Sets the target addressee
     * @param array $addressee
     */
    public function setAddressee(array $addressee)
    {
        $this->addressee = $addressee;
    }

    /**
     * Returns the file path of the view script
     * @return string
     * @throws \BadFunctionCallException
     */
    public function getViewScript()
    {
        if(!isset($this->addressee['class'])) {
            throw new \BadFunctionCallException('The class name was not defined.');
        }
        if(!isset($this->addressee['action'])) {
            throw new \BadFunctionCallException('The action name was not defined.');
        }
        // We're assuming here that all classes (i.e. Controllers) will be namespaced
        $class = explode('\\', $this->addressee['class']);
        if(count($class) <= 1) {
            throw new \BadFunctionCallException('Unable to get the class namespace');
        }

        // Removes the Controller keyword from the controller name
        $controller = end($class);
        $folder = strtolower(substr($controller,0,strlen($controller)-10));

        $controllerReflector = new \ReflectionClass($this->addressee['class']);
        $viewPath = implode(DIRECTORY_SEPARATOR, array_slice(explode('\\',$controllerReflector->getFileName()), 0, -2));
        $viewPath .=  str_replace('/', DIRECTORY_SEPARATOR, sprintf('/templates/%s/', $folder));

        // Removes the Action keyword from the method name
        $action = substr($this->addressee['action'],0,strlen($this->addressee['action'])-6);

        // Transforms the action name into the template name (cammel case to dash)
        $script = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $action)) . '.phtml';
        $filePath = $viewPath . $script;

        if(!file_exists($filePath)) {
            throw new \RuntimeException('View template not found: ' . $filePath);
        }

        return $filePath;
    }
}
