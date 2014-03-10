<?php

/**
 * Pricingmanagement Module Bootstrap
 *
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 * @package Pricingmanagement Module
 */

class Pricingmanagement_Bootstrap extends Zend_Application_Module_Bootstrap
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
    	$registry->Pricingmanagement = new Zend_Config( $this->getApplication()->getOption('Pricingmanagement') );
    }
    
    /**
     * Load site map
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initNavigation()
    {
//     	$this->bootstrap('layout');
//     	$layout = $this->getResource('layout');
//     	$view = $layout->getView();
    	
    	$config = new Zend_Config(require Zend_Registry::getInstance()->config->path->modulePath . 'configs/navigations/navigation.php');// Zend_Config_Xml(Zend_Registry::getInstance()->path->modulePath . 'configs/navigation.xml');
    	
    	$navigation = new Zend_Navigation($config);
    	
    	# Navigation can be fetched in all views
    	$view = Zend_Layout::startMvc()->getView();
    	$view->navigation($navigation);
    }
}