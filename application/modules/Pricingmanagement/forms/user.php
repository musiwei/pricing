<?php

class Pricingmanagement_Form_User extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');

		$this->addElement(
				'text', 'name', array(
						'label' => 'Username:',
						'required' => true,
						'filters'    => array('StringTrim'),
				));//->addElementPrefixPath('Decorator', 'Decorator/', 'decorator');

		$this->addElement('password', 'password', array(
				'label' => 'Password:',
				'required' => true,
		));
		
		// Add a captcha
		/*$this->addElement('captcha', 'captcha', array(
				'label'      => 'Please enter the 5 letters displayed below:',
				'required'   => true,
				'captcha'    => array(
						'captcha' => 'Figlet',
						'wordLen' => 5,
						'timeout' => 300
				)
		));*/

		$this->addElement('submit', 'submit', array(
				'ignore'   => true,
				'label'    => 'Login',
		));
		
	}
}