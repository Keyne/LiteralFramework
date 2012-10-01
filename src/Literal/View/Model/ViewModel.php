<?php
/**
 * Literal Framework
 */
namespace Literal\View\Model;

use Literal\View\Template\Variables;

/**
 * View Model
 */
class ViewModel
{
    /**
     * The template file path
     * @var string
     */
    private $templatePath;

    /**
     * @var Variables
     */
    private $variables;

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     * @return ViewModel
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
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
     * @return ViewModel
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
        return $this;
    }
}
