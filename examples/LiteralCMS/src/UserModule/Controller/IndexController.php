<?php
/**
 * LiteralCMS - Default Module
 */
namespace LiteralCMS\UserModule\Controller;

/**
 * Builds the route target class (e.g. A controller with its services)
 */
class IndexController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        return array('param1' => 'ok');
    }
}
