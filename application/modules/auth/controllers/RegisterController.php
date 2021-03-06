<?php

/**
 * Register Controller
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Auth Module
 */

class Auth_RegisterController extends Zend_Controller_Action
{

    /**
     * Initialisation method
     *
     * @author Siwei Mu
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
     * @author Siwei Mu
     * @param	void
     * @return	void
     */
    public function preDispatch()
    {
        # if the user is logged in, they can not register again
        if (Zend_Auth::getInstance()->hasIdentity()) {
            # display to user
            $this->_helper->Message(array(
            		"authMsg:RegisterWhileLoggingin"
            ), 'warning');
            
            # redirect login page
            $this->_helper->redirector('index', 'index', 'auth');
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
     * @author Siwei Mu
     * @param           void
     * @return           void
     *
     */
    public function indexAction()
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
        $form = new Auth_Form_Register;

        # attempt to save
        $save = $this->save($form);

        # send to view
        $this->view->registerForm = $save['form'];
        $this->view->alert = array('error' => $save['alert']);
    }

     /**
     * successful method
     *
     * @author Siwei Mu
     * @param           void
     * @return           void
     *
     */
    public function successAction()
    {
        $this->_helper->redirector('index', 'login', 'auth');
    }

    /**
     * save method
     *
     * @author Siwei Mu
     * @param	void
     * @return	void
     */
    private function save($form)
    {
        $message = NULL;
        if ($this->_request->isPost()) {
            # get params
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                # check for existing email
                $accountExist = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Account')->findBy(array('email' => (string)$data['email']));
                if (count($accountExist) == 0) {
                    # register account
                    $account = new Application\Entity\Account();
                    $account->setFirstName($data['first_name']);
                    $account->setLastName($data['last_name']);
                    $account->setEmail($data['email']);
                    $account->setPassword($data['password'], Zend_Registry::getInstance()->auth->hash);
                    $date = new Zend_Date;
                    //$account->setCreated_at($date->toString('YYYY-MM-dd HH:mm:ss'));
                    $this->_helper->DoctrineInit->getEntityManager()->persist($account);
                    $this->_helper->DoctrineInit->getEntityManager()->flush();

                    # send to login page
                    $this->_helper->Message(array('authMsg:RegistrationSuccess'), 'success');
                    $this->_helper->redirector('success', 'register', 'auth');
                } else {
                    $alert = array('authMsg:AccountExists'); // move to view
                }
            }
            # populate form
            $form->populate($data);
        }
        return array('form' => $form, 'alert' => empty($alert) ? NULL : $alert );
    }


    /**
     * Login form validation method
     *
     * @author Siwei Mu
     * @param void
     * @return void
     */
    public function validateAction ()
    {
    	$form = new Auth_Form_Register();
    	$form->isValid($this->_getAllParams());
    	$this->_helper->json($form->getMessages());
    }
}

