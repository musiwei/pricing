<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Global Controller Plugin
 */

class Application_Global_Controller_Plugin_Alert extends Zend_Controller_Plugin_Abstract
{

    /**
     * Pre dispatch
     *
     * @author Siwei Mu
     * @param Zend_Controller_Request_Abstract $request            
     * @return void
     *
     */
    public function preDispatch (Zend_Controller_Request_Abstract $request)
    {}

    /**
     * Post dispatch
     *
     * @author Siwei Mu
     * @param Zend_Controller_Request_Abstract $request            
     * @return void
     *
     */
    public function postDispatch (Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        
        $message = "";
        
        # Set up info messages
        if ($flashMessenger->setNamespace('info')->hasMessages()){
        	$message['info'] = $flashMessenger->getMessages();
        }
        
        # Set up success messages
        if ($flashMessenger->setNamespace('success')->hasMessages()){
            $message['success'] = $flashMessenger->getMessages();
        }
        
        # Set up warning messages
        if ($flashMessenger->setNamespace('warning')->hasMessages()){
        	$message['warning'] = $flashMessenger->getMessages();
        }
        
        # Set up error messages
        if ($flashMessenger->setNamespace('error')->hasMessages()){
            $message['error'] = $flashMessenger->getMessages();
        }
        
        $alert = $message;
        if (! empty($alert)) {
            $view->alert = $alert;
        }
    }
}