<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 * @package Pricingmanagement Module
 */

class Pricingmanagement_Controller_Action_Helper_LayoutInit extends Zend_Controller_Action_Helper_Abstract
{
    private $_view = null;
    
    /**
     * Set layout
     *
     * @author Siwei Mu
     * @param string $pageTitle value of page title
     * @param array $options list of options corresponding to placeholders
     */
    public function direct($pageTitle = null, $options = array())
    {
        
        $this->_view = Zend_Layout::getMvcInstance()->getView();
        
        # Set page title
        $this->_view->headTitle($pageTitle)->setSeparator(' - ');
        
        foreach ($options as $key => $value)
            $this->_view->placeholder($key)->set($value);
    }
}