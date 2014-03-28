<?php

/**
 * Account Controller
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Auth Module
 */

class Auth_AccountController extends Zend_Controller_Action
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
     * initiates before any action is dispatched
     *
     * @param Siwei Mu
     * @return void
     */
    public function preDispatch()
    {
        
        # if the user is not logged in, they can not access secure pages
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            
            # redirect login page
            $this->_helper->redirector('denied', 'index', 'auth');
        }
    }

    /**
     * post dispatch method
     *
     * @author          Eddie Jaoude
     * @param void
     * @return void
     *
     */
    public function  postDispatch()
    {
        
        parent::postDispatch();
    }

    /**
     * default method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function indexAction()
    {

    }

    /**
     * history method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function eventAction()
    {

        $this->_helper->LayoutInit('Event activity');
        
        $account = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Account')->findOneBy(array('id' => Zend_Auth::getInstance()->getIdentity()->getId()));
        $events = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Accountevent')->findBy(array('accountId' => Zend_Auth::getInstance()->getIdentity()->getId()));
        echo Zend_Registry::getInstance()->application->path->design->default;
        # send to view
        $this->view->events = $events;
        $this->view->account = $account;
        
        
        //$response->setBody(preg_replace('/(<\/head>)/i', $this->_helper->DoctrineInit->getRepository('\Application\Entity\Accountevent')->javascriptOutput().'$1', $response->getBody()));
    }

    /**
     * Fetch events to popolate into datatable
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function fetcheventAction ()
    {
        
        # return processed account events in json format
        $this->_helper->json(
            $this->_helper->DoctrineInit->getRepository('\Application\Entity\Accountevent')->fetchAccountEvents($_GET)
        );
    }

    /**
     * Update data modified by X-Editable plugin
     *
     * @author Siwei Mu
     * @param void
     * @return void
     *
     */
    public function ajaxupdateAction ()
    {
        
        $this->_helper->json(
                $this->_helper->DoctrineInit->getRepository('\Application\Entity\Accountevent')->updateAccountEvents($_POST['pk'], $_POST['name'], $_POST['value'])
        );
    }
}