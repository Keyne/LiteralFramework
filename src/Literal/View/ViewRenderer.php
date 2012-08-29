<?php
/**
 * Literal Framework
 */
namespace Literal\View;

/**
 * View Resolver
 * By default, it determines the view file to be rendered by the application based on the target controller.
 */
class ViewRenderer
{
    public function render(array $viewModel, $viewScript)
    {
        ob_start();
        extract($viewModel);
        include $viewScript;
        return ob_get_clean();
    }
}
