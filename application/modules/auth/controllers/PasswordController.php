<?php

/**
 * Password Controller
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 * @package Auth Module
 */

class Auth_PasswordController extends Zend_Controller_Action
{

    /**
     * Initialisation method
     *
     * @author          Eddie Jaoude
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
     * @param	void
     * @return	void
     */
    public function preDispatch()
    {

    }

    /**
     * The default method
     */
    public function indexAction()
    {

    }

    /**
     * Send a new password to the emailaddress of the user
     *
     * @author	Koen Huybrechts
     * @param	void
     * @return	void
     */
    public function forgotAction()
    {
        # if the user is logged in, they can not reset the password
        if (Zend_Auth::getInstance()->hasIdentity()) {
            # display to user
            $this->_helper->Message(array('authMsg:RedirectToUpdatePassword'), 'info');
            
            # redirect password update page
            $this->_helper->redirector('update', 'password', 'auth');
        }

        # get form
        $this->passwordForm = new Auth_Form_PasswordReset();

        $send = $this->sendPassword();

        # send to view
        $this->view->passwordForm = $send;
    }

    /**
     * The user can change his password
     *
     * @author	Koen Huybrechts
     * @param	void
     * @return	void
     */
    public function updateAction()
    {
        # if the user is NOT logged in, they can not update the password
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            # display to user
            $this->_helper->Message(array('authMsg:LoginToUpdatePassword'), 'info');
            
            # redirect password update page
            $this->_helper->redirector('index', 'login', 'auth');
        }

        # get form
        $this->updateForm = new Auth_Form_PasswordUpdate();

        $send = $this->updatePassword();

        # send to view
        $this->view->updateForm = $send;
    }

    public function sendPassword()
    {
        # get form
        $form = $this->passwordForm;

        if ($this->_request->isPost()) {
            # get params
            $data = $this->_request->getPost();

            # check validate form
            if ($form->isValid($data)) {
                # attempt to resend password
                $user = $this->getRequest()->_em->getRepository('Auth_Model_Account')->findOneBy(array('email' => (string)$data['email']));

                if (count($user) === 1) {
                    $password = $this->getRequest()->_em->getRepository('Auth_Model_Account')->generatePassword($this->getRequest()->_registry->config->auth->password->minlength);

                    $user->setPassword($password, $this->getRequest()->_registry->config->auth->hash);
                    $this->getRequest()->_em->flush();

                    # send email
                    $emailReset = new Zend_Mail();
                    $emailReset->addTo($user->getEmail(), $user->getName());
                    $emailReset->setSubject('Password Reset');
                    // @ToDo Create a view file with an email template
                    $emailReset->setBodyText('New Password: ' . $password);

                    $emailReset->setFrom($this->getRequest()->_registry->config->application->system->email->address,
                                            $this->getRequest()->_registry->config->application->system->email->name);
                    if ($emailReset->send()) {
                        # record event
                        $this->_helper->event->record('reset password', $user->getId());
                        $this->getRequest()->_flashMessenger->addMessage('A new password has been sent to ' . $user->getEmail());
                        $this->_helper->redirector('index', 'index', 'default');
                    }
                } else {
                    # record event
                    // $this->_helper->event->record('reset password failed'); // removed because no account to log against
                    $this->getRequest()->_flashMessenger->addMessage('Sending failed');
                    $this->_helper->redirector('forgot', 'password', 'auth');
                }
            } else {
                # populate form
                $form->populate($data);
            }
        }
        return $form;
    }

    public function updatePassword()
    {
        # get Form
        $form = $this->updateForm;

        if ($this->_request->isPost()) {
            # get params
            $data = $this->_request->getPost();

            # check validate form
            if ($form->isValid($data)) {
                # attempt update the password
                $user = $this->_helper->DoctrineInit->getRepository('\Application\Entity\Account')->findOneBy(array('id' => Zend_Auth::getInstance()->getIdentity()->getId()));
                // @Todo Create one function where we can generate the correct hash
                $currentPassword = hash('SHA256', Zend_Registry::getInstance()->auth->hash . $data['currentPassword']);
                if (count($user) === 1 && $currentPassword == $user->getPassword()) { //User exists and posted current password matches the saved password
                    # set new password
                    $user->setPassword($data['newPassword'], Zend_Registry::getInstance()->auth->hash);
                    $this->_helper->DoctrineInit->getEntityManager()->flush();
                    
                    # record event
                    $this->_helper->EventRecorder->record('Update password', Zend_Auth::getInstance()->getIdentity()->getId());

                    # provide feedback
                    $this->_helper->Message(array('authMsg:PasswordUpdated'), 'success');
                    
                    # redirect to the secure page
                    $this->_helper->redirector('update', 'password', 'auth');
                } else {
                    # record event
                    $this->_helper->EventRecorder->record('Update password failed', Zend_Auth::getInstance()->getIdentity()->getId());

                    if($currentPassword != $user->getPassword())
                    	$this->_helper->Message(array('authMsg:PasswordUpdatePasswordNotMatch'), 'error');
                    else
                        $this->_helper->Message(array('authMsg:PasswordUpdateFail'), 'error');
                    
                    $this->_helper->redirector('update', 'password', 'auth');
                }
            } else {
                # populate form
                $form->populate($data);
            }
        }
        return $form;
    }

}
