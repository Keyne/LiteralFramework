<?php
/**
 * LiteralCMS - Default Module
 */
namespace LiteralCMS\DefaultModule\Controller;

use \Literal\Controller\Controller;

/**
 * Builds the route target class (e.g. A controller with its services)
 */
class IndexController extends Controller
{
    /**
     * @return array
     */
    public function indexAction()
    {
        /*
         if($this->getRequest()->isPost()) {
            $user = $this->getRequest()->getPost()->get('user');
            $pass = $this->getRequest()->getPost()->get('user');
            if($this->authenticationService->login($user, $pass)) {
                $this->redirect('admin')
            }
         }
        $viewModel = new ViewModel();
        $viewModel->setTemplate('sign-in/login')
        return $viewModel;
         */

        /*
        $loginViewModel = new ViewModel();
        if($this->getRequest()->isPost()) {
           $user = $this->getRequest()->getPost()->get('user');
           $pass = $this->getRequest()->getPost()->get('pass');
           $loginViewModel->setCredentials($user, $pass);
           $$loginViewModel->saveState();
           if($this->loginViewModel->isUserAuthenticated()) {
               $this->redirect('admin');
           }
        }
        return $loginViewModel;
        */
        return 'Hello world';
    }

    /**
     * @param int $user_id
     */
    public function editAction($user_id)
    {
        /*
        $user = $this->usersService->getUser($user_id);

        $userViewModel = new ViewModel();
        $userViewModel->setUser($user);
        $userViewModel->setTemplate('users/edit');

        return $userViewModel;
        */
    }
}
