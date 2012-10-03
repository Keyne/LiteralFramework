<?php
/**
 * LiteralCMS - Default Module
 */
namespace LiteralCMS\DefaultModule\Controller;

use \Literal\Controller\Controller;

/**
 * Index Controller
 */
class IndexController extends Controller
{
    /**
     * @return array
     */
    public function indexAction()
    {
        return array('name' => 'Keyne ÔM');
    }
}
