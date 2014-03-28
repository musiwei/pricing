<?php

/**
 * Index Controller
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Auth Module
 */

class Auth_IndexController extends Zend_Controller_Action
{

    /**
     * Initialisation method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * post dispatch method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function  postDispatch()
    {
        parent::postDispatch();
    }

    /**
     * default method to redirect to main module front page
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function indexAction()
    {
        $this->_helper->redirector('index', 'index', 'Pricingmanagement');
    }

    /**
     * access denied method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function deniedAction()
    {

    }


}

