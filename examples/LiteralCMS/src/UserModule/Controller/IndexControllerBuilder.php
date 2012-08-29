<?php
/**
 * LiteralCMS - Default Module
 */
namespace LiteralCMS\UserModule\Controller;

/**
 * Builds the route target class (e.g. A controller with its services)
 */
class IndexControllerBuilder
{
    /**
     * @return IndexController
     */
    public function buildTarget()
    {
        $target = new IndexController();
        return $target;
    }
}
