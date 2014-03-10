<?php

/**
 * Auth Module Bootstrap
 *
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 25 Feb 2014
 * @version 1.0
 * @package Auth Module
 */

class Auth_Bootstrap extends Zend_Application_Module_Bootstrap
{
    
    /**
     * Save module config into registry
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initConfiguration()
    {
    	$registry = Zend_Registry::getInstance();
    	$registry->auth = new Zend_Config( $this->getApplication()->getOption('auth') );
    }

}

