<?php

/**
 * Login Controller
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Auth Module
 */

class Auth_LoginController extends Zend_Controller_Action
{

    /**
     * Initialisation method
     *
     * @author Siwei Mu 
     * @param void
     * @return void
     *
     */
    public function init ()
    {
        parent::init();
    }

    /**
     * initiates before any action is dispatched
     * 
     * @author Siwei Mu 
     * @param void
     * @return void
     */
    public function preDispatch ()
    {
        # if the user is logged in, they can not login again
        if (Zend_Auth::getInstance()->hasIdentity()) {
            # display to user
            $this->_helper->Message(array('authMsg:AlreadyLoggedin'), 'warning');
            
            # redirect login page
            $this->_helper->redirector('index', 'index', 'auth');
        }
    }

    /**
     * initiates after any action is dispatched
     * 
     * @author Siwei Mu 
     * @param void
     * @return void
     */
    public function postDispatch ()
    {
        parent::postDispatch();
    }

    /**
     * default method
     *
     * @author Siwei Mu 
     * @param void
     * @return void
     */
    public function indexAction ()
    {
        # title and other options
        $this->_helper->LayoutInit('Sign In', 
                array(
                        'bodyClass' => 'login-page',
                        'hasHeader' => '0',
                        'hasSidebar' => '0',
                        'hasBreadcrumb' => '0'
                ));
        
        # load form
        $this->loginForm = new Auth_Form_Login();
        
        $save = $this->authenticate();
        
        # send to view
        $this->view->loginForm = $save['form'];
        $this->view->alert = array(
                'error' => $save['alert']
        );
    }

    /**
     * Authentication method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function authenticate ()
    {
        # get form
        $form = $this->loginForm;
        if ($this->_request->isPost()) {
            # get params
            $data = $this->_request->getPost();
            # check validate form
            if ($form->isValid($data)) {
                # attempt to authentication
                $authenticate = new Auth_Adapter(
                        $this->_helper->DoctrineInit->getRepository(
                                '\Application\Entity\Account'), 
                        Zend_Registry::getInstance()->auth->hash, $data);
                $save = Zend_Auth::getInstance()->authenticate($authenticate);
                if (Zend_Auth::getInstance()->hasIdentity()) {
                    $this->_helper->Message(array('authMsg:LoginSuccess'), 'success');
                    # record event
                    $this->_helper->EventRecorder->record('Sign in',
                    Zend_Auth::getInstance()->getIdentity()->getId());
                    # send to dashboard/user page
                    $this->_helper->redirector('index', 'index', 'auth');
                } else {
                    $alert = array(
                            'authMsg:LoginFail'
                    );
                }
            }
            $form->populate($data);
        }
        return array(
                'form' => $form,
                'alert' => empty($alert) ? NULL : $alert
        );
    }

    /**
     * Login form validation method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     */
//     public function validateAction ()
//     {
//         $form = new Auth_Form_Login();
//         $form->isValid($this->_getAllParams());
//         $this->_helper->json($form->getMessages());
//     }
}
