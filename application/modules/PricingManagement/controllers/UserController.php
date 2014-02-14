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
                        'label' => 'Page 2',
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
        
        $userGateway = new Pricingmanagement_Model_UserGateway();
        $row = $userGateway->fetchUserById(1);
        
        // $this->view->user = $users->current()->username;
        
        $this->view->user = $row->last_name;
        
        $this->_helper->LayoutInit('My Account', 
                array(
                        'sectionId' => 'content'
                ));
    }
    


    public function loginAction ()
    {
        // Title and other options
        $this->_helper->LayoutInit('Login', 
                array(
                        'bodyClass' => 'login-page',
                        'hasHeader' => '0',
                        'hasSidebar' => '0',
                        'hasBreadcrumb' => '0'
                ));
        
        $Users = $this->_helper->DoctrineInit->getRepository('\Application\Entity\User')->findAll();
        Zend_Registry::get('logger')->log('This is a log message!', 3);
        $this->view->users = $Users;
        foreach($Users as $user)
            echo $user->getId();
        
    }
}
