<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 */
class Pricingmanagement_UserController extends Zend_Controller_Action
{

    public function init ()
    {}

    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $array = array(
                array(
                        'label' => 'Homepage',
                        'id' => 'home-link',
                        'action' => 'index',
                        'controller' => 'index'
                ),
                array(
                        'label' => 'Account',
                        'controller' => 'user',
                        'pages' => array(
                                array(
                                        'label' => 'user\'s index',
                                        'action' => 'index',
                                        'controller' => 'user',
                                        'class' => 'special-one',
                                        'title' => 'This element has a special class',
                                        'active' => true
                                ),
                                array(
                                        'label' => 'user\'s login',
                                        'action' => 'login',
                                        'controller' => 'user',
                                        'class' => 'special-two',
                                        'title' => 'This element has a special class too'
                                )
                        )
                )
        );
        
        $this->view->zendNavigationContainer = new Zend_Navigation($array);
        
        $this->_helper->LayoutInit('My Account', 
                array(
                        'sectionId' => 'content'
                ));
    }
    


    public function loginAction ()
    {
        # Title and other options
        $this->_helper->LayoutInit('Login', 
                array(
                        'bodyClass' => 'login-page',
                        'hasHeader' => '0',
                        'hasSidebar' => '0',
                        'hasBreadcrumb' => '0'
                ));
        
        $Users = $this->_helper->DoctrineInit->getRepository('\Application\Entity\User')->findAll();
        $this->view->users = $Users;
    }
    
    private function samples(){
        
    	# To use logger globally
        //Zend_Registry::get('logger')->log('This is a log message!', 3);
        
        # To use flash messenger globally
        // $this->_helper->FlashMessenger->addMessage('Record Saved!');
    }
}
