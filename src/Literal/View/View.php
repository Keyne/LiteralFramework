<?php
/**
 * Literal Framework
 */
namespace Literal\View;

use Literal\View\Template\Renderer,
    Literal\View\Template\Variables;

/**
 * Base view class representing a given window
 */
class View
{
    /**
     * @var Renderer The template engine
     */
    private $renderer;

    /**
     * The template file path
     * @var string
     */
    private $templateFile;

    /**
     * The template variables
     * @var Variables
     */
    private $variables;

    /**
     * @var array ViewCollection representing dependent parts of the current view
     */
    private $children;

    /**
     * @param Template\Renderer $renderer
     */
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->variables = new Variables();
    }

    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    /**
     * @param string $templateFile
     * @return View
     */
    public function setTemplateFile($templateFile)
    {
        $this->templateFile = $templateFile;
        return $this;
    }

    /**
     * @return \Literal\View\Template\Variables
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param \Literal\View\Template\Variables $variables
     */
    public function setVariables(Variables $variables)
    {
        $this->variables = $variables;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($name, $default = null)
    {
        if(!isset($this->variables[$name])) {
            if($default !== null) {
                return $default;
            }
            throw new \InvalidArgumentException('Trying to get a nonexistent view variable');
        }
        return $this->variables[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * Adds a dependent view (partial)
     * @param string $name
     * @param View $view
     */
    public function addChild($name, View $view)
    {
        $this->children[$name] = $view;
    }

    /**
     * Returns a given child view in order to render a template partial
     * @param string $name The partial name
     */
    public function renderPartial($name)
    {
        if(!isset($this->children[$name])) {
            throw new \InvalidArgumentException('Nonexistent view: ' . $name);
        }

        return $this->children[$name]->render();
    }

    /**
     * Renders the current view
     */
    public function render()
    {
        return $this->renderer->renderTemplate($this->templateFile, $this);
    }
}
