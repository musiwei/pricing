<?php

/**
 * Auth registration form
 *
 * @author 			Eddie Jaoude
 * @category   		Real Browser
 * @package 		Auth Module
 * @version 		SVN: $Id:$
 *
 */
class Auth_Form_Register extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post')
            ->setAction($this->getView()->url(array(
                    'module' => 'auth',
                    'controller' => 'register',
                    'action' => 'index')))
            ->setAttrib('class', 'box')
            ->setName('Register');

        # First Name
        $firstName = new Zend_Form_Element_Text('first_name');
        $firstName->setLabel('First Name')
            ->setRequired(TRUE)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
        
        # Last Name
        $lastName = new Zend_Form_Element_Text('last_name');
        $lastName->setLabel('Last yName')
        ->setRequired(TRUE)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('NotEmpty');

        # Email
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
            ->setRequired(TRUE)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addFilter('StringToLower')
            ->addValidator('NotEmpty')
            ->addValidator('EmailAddress');

        # Password
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
            ->setRequired(TRUE)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->addValidator('StringLength', false, 
                array(
                        'min' => Zend_Registry::getInstance()->auth->password->minlength,
                        'max' => Zend_Registry::getInstance()->auth->password->maxlength));
        
        # terms and conditions
        $terms = new Zend_Form_Element_Checkbox('terms');
        $terms->setUncheckedValue('')
        ->setCheckedValue('I agree')
        ->setRequired(TRUE)
        ->addValidator('NotEmpty', False, array('messages'=>'You must agree to the terms'));
        
        # Submit
        $submit = new Zend_Form_Element_Submit('Register');

        # Create
        $this->addElements(array($firstName, $lastName, $email, $password, $terms, $submit));
        
        # Set decorator
        $this->setDecorators(array(
        array('viewScript', array('viewScript' => '/_form_viewscript/_register.phtml'))
        ));
    }
}

