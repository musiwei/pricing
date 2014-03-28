<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 * @package Pricingmanagement Module
 */

class Pricingmanagement_IndexController extends Zend_Controller_Action
{

    public function indexAction ()
    {
        
        $this->_helper->redirector('index', 'dashboard', 'Pricingmanagement');
    }
}

