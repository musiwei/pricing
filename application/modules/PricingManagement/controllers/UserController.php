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
        $this->getResponse()->setHttpResponseCode(500);
        $this->_helper->LayoutInit('My Account');
        
        $this->_helper->Message(array('Info'), 'info');
        $this->_helper->Message(array('Success 1', 'The second success message.'), 'success');
        $this->_helper->Message(array('Warning'), 'warning');
        $this->_helper->Message(array('Error 1', 'The second error message.'), 'error');
    }
    
    
    private function samples(){
        
        # To load all users
        //$Users = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Account')->findAll();
        //$this->view->users = $Users;
        
    	# To use logger globally
        //Zend_Registry::get('logger')->log('This is a log message!', 3);
        
        # To use flash messenger globally
        // $this->_helper->Message(array(...), $namespace);
        // $this->_helper->Message(array('Error 1', 'Error2'), 'error');
        
    }
}
