<?php

/**
 * Application Bootstrap
 *
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 25 Feb 2014
 * @version 1.0
 * @package Application
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    /**
     * Auto load path for Doctrine command line interface
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initAutoloaderNamespaces()
    {
    	require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';
    	$autoloader = \Zend_Loader_Autoloader::getInstance();
    	$symfonyAutoloader = new \Doctrine\Common\ClassLoader('Symfony', 'Doctrine');
    	$autoloader->pushAutoloader(array($symfonyAutoloader, 'loadClass'), 'Symfony');
    }

    
    /**
     * Save application config into registry
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initConfiguration()
    {
    	$registry = Zend_Registry::getInstance();
    	$registry->application = new Zend_Config( $this->getOptions());
    }
    
    /**
     * Global view helper
     * To be used in all modules
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initViewHelperPaths()
    {
    	$this->bootstrap('view');
    	$view = $this->getResource('view');
    	$view->addHelperPath(APPLICATION_PATH . '/../library/Application/Global/View/Helper', 'Application_Global_View_Helper_');
    }
    
    /**
     * Store module configurations into registry
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initConfigurations()
    {
    	$registry = Zend_Registry::getInstance();
    	$registry->config = new Zend_Config( $this->getOptions() );
    }
    
    /**
     * Doctype of view
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initDoctype()
    {
    	$doctypeHelper = new Zend_View_Helper_Doctype();
    	$doctypeHelper->doctype('XHTML1_STRICT');
    }
    
    /**
     * Provide a Magento-like view and layout rendering approach
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initDesignPath ()
    {
    	$frontController = Zend_Controller_Front::getInstance();
    	$frontController->registerPlugin(new Application_Global_Controller_Plugin_SetDesignPath());
    }

    /**
     * Initialize cache.
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initCacheFrontControllerPlugins ()
    {
    	# register plugin to handle cache
    	$frontController = Zend_Controller_Front::getInstance();
    	$frontController->registerPlugin(new Application_Global_Controller_Plugin_CacheInit());
    }
    
    /**
     * Initialize translation cache.
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initTranslateCache (){
        # use cache to speed up translation
        Zend_Translate::setCache(Zend_Registry::get('cache'));
    }
    
    /**
     * Initialize translation and locale.
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initTranslate1 ()
    {
//         $this->bootstrap('frontController');
//         $frontController = $this->getResource('frontController');
//         $router = $frontController->getRouter(); // router is a singleton
//         $request = new Zend_Controller_Request_Http();
//         $router->route($request);
        
//         $moduleName = $request->getModuleName();
        
//         // Fetch translate configuration
//         $conf = $this->getOption('resources');
        
//         $translateAdapter = $conf['translate']['adapter'];
        
//         $translatePath = $conf['translate']['data'];
//         $translateDelimiter = $conf['translate']['options']['delimiter'];
        
//         // Use cache to speed up translation
//         Zend_Translate::setCache(Zend_Registry::get('cache'));
        
//         // Automatically install all the language files
//         $translate = new Zend_Translate($translateAdapter, $translatePath, null, 
//                 array(
//                         'scan' => Zend_Translate::LOCALE_DIRECTORY,
//                         'delimiter' => $translateDelimiter
//                 ));
        
//         $registry = Zend_Registry::getInstance();
//         $registry->set('Zend_Translate', $translate);
        
//         // Set default locale
//         $translate->setLocale('en');
    }
    
    /**
     * Initialize flash messenger.
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initFlashMessengerFrontControllerPlugins ()
    {
    
    	# register plugin to handle cache
    	$frontController = Zend_Controller_Front::getInstance();
    	$frontController->registerPlugin(new Application_Global_Controller_Plugin_Alert());
    }
    
    /**
     * Initialize routing strategy.
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initRoutes ()
    {
        
        # get router from front controller
        $this->bootstrap('frontController');
        $front = $this->getResource('frontController');
        $router = $front->getRouter();
        
        # create route with language id (lang)
        $routeLang = new Zend_Controller_Router_Route(':lang', 
                array(
                        'lang' => 'en'
                ), array(
                        'lang' => '[a-z]{2}'
                ));
        
        # instantiate default module route
        $routeDefault = new Zend_Controller_Router_Route_Module(array(), 
                $front->getDispatcher(), $front->getRequest());
        
        # chain it with language route
        $routeLangDefault = $routeLang->chain($routeDefault);
        
        # add both language route chained with default route and plain language route
        $router->addRoute('default', $routeLangDefault);
        $router->addRoute('lang', $routeLang);
        
        # register plugin to handle language changes
        $front->registerPlugin(new Application_Global_Controller_Plugin_LanguageSet());
    }
    
    /**
     * ZFDebug.
     * 
     * GitHub project https://github.com/jokkedk/ZFDebug
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initZFDebug()
    {
    	if ('development' == APPLICATION_ENV) {
    		$autoloader = Zend_Loader_Autoloader::getInstance();
    		$autoloader->registerNamespace('ZFDebug');
    		
    		$em = $this->bootstrap('doctrine')->getResource('doctrine')->getEntityManager();
    		$em->getConnection()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());
    		
    		$options = array(
    				'plugins' => array('Variables',
    						//'Database' => array('adapter' => $dbAdapter),
    						'File' => array('basePath' => APPLICATION_PATH .
    						'..'),
    						'Cache' => array('backend' => Zend_Registry::get('cache')->getBackend()),
    						'Exception',
    				        'Html',
    				        'Memory',
    				        'Time',
    				        'Registry',
    				        'Application_Global_Controller_Plugin_Debug_Plugin_Doctrine2'  => array(
    				        		'entityManagers' => array($em),
    				        ),
    				)
    		);
    		$debug = new Application_Global_Controller_Plugin_Debug($options);
    
    		$this->bootstrap('frontController');
    		$frontController = $this->getResource('frontController');
    		$frontController->registerPlugin($debug);
    	}
    }
    
    /**
     * Logger
     *
     * @EXAMPLE: $logger->log('This is a log message!', Zend_Log::INFO);
     * @EXAMPLE: $logger->info('This is a log message!');
     *
     * From anywhere use...
     * @EXAMPLE: Zend_Registry::get('logger')->log('This is a log message!', Zend_Log::INFO);
     *
     * EMERG   = 0;  // Emergency: system is unusable
     * ALERT   = 1;  // Alert: action must be taken immediately
     * CRIT    = 2;  // Critical: critical conditions
     * ERR     = 3;  // Error: error conditions
     * WARN    = 4;  // Warning: warning conditions
     * NOTICE  = 5;  // Notice: normal but significant condition
     * INFO    = 6;  // Informational: informational messages
     * DEBUG   = 7;  // Debug: debug messages
     *
     * REQUIREMENTS: FirePHP & FireBug (firephp enabled & net tab enabled on firebug)
     *
     * @author          Siwei Mu
     * @param           void
     * @return          void
     *
     */
    protected function _initLogger ()
    {
        # log file
        $logs = new Zend_Config($this->getApplication()->getOption('logs'));
        $error_log = $logs->tmpDir . DIRECTORY_SEPARATOR . $logs->error;
        
        # create log file if does not exist
        if (! file_exists($error_log)) {
            $date = new Zend_Date();
            file_put_contents($error_log, 
                    'Error log file created on: ' .
                             $date->toString('YYYY-MM-dd HH:mm:ss') . "\n\n");
        }
        
        # check log file is writable
        if (! is_writable($error_log)) {
            throw new Exception(
                    'Error: log file is not writable ( ' . $error_log .
                             '), check folder/file permissions');
        }
        
        # create logger object
        if ('development' == APPLICATION_ENV) {
            $writer = new Zend_Log_Writer_Firebug();
        } else {
            $writer = new Zend_Log_Writer_Stream($error_log);
        }
        $logger = new Zend_Log($writer);
        
        Zend_Registry::getInstance()->set('logger', $logger);
    }
}

