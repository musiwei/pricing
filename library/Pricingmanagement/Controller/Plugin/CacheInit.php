<?php

class Pricingmanagement_Controller_Plugin_CacheInit extends Zend_Controller_Plugin_Abstract
{

    public function __construct()
    {
        $frontendOptions = array(
        		'automatic_serialization' => true,
        		'lifetime' => 5 // unit: seconds
        
        );
        
        $backendOptions = array(
        		'cache_dir' => realpath(
        				APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Pricingmanagement' .
        				DIRECTORY_SEPARATOR . 'cache')
        );
        
        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions,
        		$backendOptions);
        
        Zend_Registry::set('cache', $cache);
    }
    

}