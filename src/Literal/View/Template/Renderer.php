<?php
/**
 * Literal Framework
 */
namespace Literal\View\Template;

use Literal\View\View;

/**
 * Template Renderer
 */
class Renderer
{
    /**
     * @param string $templateFile
     * @param View $view
     * @return string
     * @throws \InvalidArgumentException
     */
    public function renderTemplate($templateFile, View $view)
    {
        if(!file_exists($templateFile)) {
            throw new \InvalidArgumentException('Template not found');
        }

        ob_start();
        extract(array('view' => $view));
        include $templateFile;
        $content = ob_get_clean();

        return $content;
    }
}
