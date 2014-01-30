<?php

class Pricingmanagement_Controller_Plugin_Getlocale extends Zend_Controller_Plugin_Abstract
{

    /**
     * Called after the router finishes routing the request.
     *
     * @param Zend_Controller_Request_Abstract $request            
     */
    public function routeShutdown (Zend_Controller_Request_Abstract $request)
    {
        $lang = $request->getParam('lang', null);
        
        $translate = Zend_Registry::get('Zend_Translate');
        
        // Change language if available
        if ($translate->isAvailable($lang)) {
            $translate->setLocale($lang);
        } else {
            // Otherwise get default language
            $locale = $translate->getLocale();
            if ($locale instanceof Zend_Locale) {
                $lang = $locale->getLanguage();
            } else {
                $lang = $locale;
            }
        }
        
        // Set language to global param so that our language route can
        // fetch it nicely.
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->setGlobalParam('lang', $lang);
    }
}