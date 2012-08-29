<?php
/**
 * Literal Framework
 */
namespace Literal\View;

/**
 * View Layer Factory
 */
class ViewFactory
{
    public function buildViewResolver()
    {
        $viewResolver = new ViewResolver();
        return $viewResolver;
    }

    public function buildViewRenderer()
    {
        $viewRenderer = new ViewRenderer();
        return $viewRenderer;
    }
}
