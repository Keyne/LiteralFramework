<?php
/**
 * Literal Framework
 */
namespace Literal\View\Template;

use Literal\View\Model\ViewModel;

/**
 * Template Renderer
 */
class Renderer
{
    /**
     * @param string $templatePath
     * @param ViewModel $viewModel
     * @return string
     * @throws \InvalidArgumentException
     */
    public function renderTemplate($templatePath, ViewModel $viewModel)
    {
        if(!file_exists($templatePath)) {
            throw new \InvalidArgumentException('Template not found');
        }

        ob_start();
        extract(array('viewModel' => $viewModel));
        include $templatePath;
        $content = ob_get_clean();

        return $content;
    }
}
