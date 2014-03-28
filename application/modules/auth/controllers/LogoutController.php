<?php

/**
 * Log out Controller
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Auth Module
 */

class Auth_LogoutController extends Zend_Controller_Action
{

    /**
     * Initialisation method
     *
     * @author          Siwei Mu
     * @param           void
     * @return           void
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * initiates before any action is dispatched
     * 
     * @author          Siwei Mu
     * @param	void
     * @return	void
     */
    public function preDispatch()
    {
        
        # if the user is not logged in, they can not log out
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            # display to user
            $this->_helper->Message(array("authMsg:FailLogOut"), 'warning');
            $this->_helper->Message(array("authMsg:LoginThroughForm"), 'info');
            
            # redirect login page
            $this->_helper->redirector('index', 'login', 'auth');
        }
    }

    /**
     * initiates after any action is dispatched
     * 
     * @author Siwei Mu
     * @param	void
     * @return	void
     */
    public function postDispatch()
    {
        
        parent::postDispatch();
    }

    /**
     * default method
     *
     * @author          Siwei Mu
     * @param           void
     * @return           void
     *
     */
    public function indexAction()
    {
        
        # record event
        $this->_helper->EventRecorder->record('Sign out', Zend_Auth::getInstance()->getIdentity()->getId());

        # clears users identity
        Zend_Auth::getInstance()->clearIdentity();

        # display to user
        $this->_helper->Message(array('authMsg:LogoutSuccess'), 'success');

        # redirect to login
        $this->_helper->redirector('index', 'login', 'auth');
    }
}

