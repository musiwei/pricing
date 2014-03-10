<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 */

class Application_Global_Plugin_CacheInit extends Zend_Controller_Plugin_Abstract
{

    public function __construct()
    {
        $frontendOptions = array(
        		'automatic_serialization' => true,
        		'lifetime' => 5 // unit: seconds
        
        );
        
        $backendOptions = array(
        		'cache_dir' => realpath(
        				APPLICATION_PATH . DIRECTORY_SEPARATOR . 'cache')
        );
        
        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions,
        		$backendOptions);
        
        if (! Zend_Registry::isRegistered('cache')) {
        	Zend_Registry::set('cache', $cache);
        }
    }
    
//     private function _translationCache(){

//     }
}