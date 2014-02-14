<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 */

class Pricingmanagement_Bootstrap extends Zend_Application_Module_Bootstrap
{

    
    
    protected function _initAutoload ()
    {
        
        /*
         * If you don't register namespace You will get error : Fatal error:
         * Class 'Pricingmanagement_Controller_Plugin_Param' not found in
         * ...\library\Zend\Application\Resource\Frontcontroller.php on line 92
         */
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Pricingmanagement_');
        $autoloader->suppressNotFoundWarnings(true);
    }
    
    protected function _initPaths()
    {
    	$registry = Zend_Registry::getInstance();
    	$registry->path = new Zend_Config( $this->getApplication()->getOption('path') );
    }
    
    protected function _initNavigation()
    {
    	$this->bootstrap('layout');
    	$layout = $this->getResource('layout');
    	$view = $layout->getView();
    	
    	$config = new Zend_Config_Xml(Zend_Registry::getInstance()->path->modulePath . 'configs/navigation.xml');
    	
    	$navigation = new Zend_Navigation($config);
    	$view->navigation($navigation);
    }
    

    protected function _initCacheFrontControllerPlugins ()
    {
        
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->registerPlugin(
                new Pricingmanagement_Controller_Plugin_CacheInit());
    }
    


    
}