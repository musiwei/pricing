<?php

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

    protected function _initCacheFrontControllerPlugins ()
    {
        
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->registerPlugin(
                new Pricingmanagement_Controller_Plugin_CacheInit());
    }
    
    protected function _initTranslate()
    {
        
        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $router = $frontController->getRouter(); // router is a singleton 
        $request =  new Zend_Controller_Request_Http(); 
        $router->route($request); 

        $moduleName = $request->getModuleName(); 
        
        // Fetch translate configuration
        $conf = $this->getOption('resources');
        
        $translateAdapter = $conf['translate']['adapter'];
        $translatePath = $conf['translate']['data'];
        $translateDelimiter = $conf['translate']['options']['delimiter'];
        
        // Automatically install all the language files 
    	$translate = new Zend_Translate($translateAdapter,
    			$translatePath,
    			null,
    			array('scan' => Zend_Translate::LOCALE_DIRECTORY, 'delimiter' => $translateDelimiter));
    	
    	$registry = Zend_Registry::getInstance();
    	$registry->set('Zend_Translate', $translate);
    	$translate->setLocale('en');
    }

    protected function _initRoutes ()
    {
        
        // Now get router from front controller
        $this->bootstrap('frontController');
        $front = $this->getResource('frontController');
        $router = $front->getRouter();
        
        // Create route with language id (lang)
        $routeLang = new Zend_Controller_Router_Route(
                ':lang', 
                array(
                        'lang' => 'en'
                ), 
                array(
                        'lang' => '[a-z]{2}'
                ));
        
        // Instantiate default module route
        $routeDefault = new Zend_Controller_Router_Route_Module(array(), 
                $front->getDispatcher(), $front->getRequest());
        
        // Chain it with language route
        $routeLangDefault = $routeLang->chain($routeDefault);
        
        // Add both language route chained with default route and
        // plain language route
        $router->addRoute('default', $routeLangDefault);
        $router->addRoute('lang', $routeLang);
        
        // Register plugin to handle language changes
        $front->registerPlugin(new Pricingmanagement_Controller_Plugin_Getlocale());
    }
}