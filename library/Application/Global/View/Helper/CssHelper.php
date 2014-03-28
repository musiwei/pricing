<?php 

/**
 * Global CSS Helper
 * Automatically search and append CSS file as long as it exists
 * e.g. search in custom skin folder, if found: skin\custom\moduleName\controllerName\actionName.css, then append to view
 *
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 25 Feb 2014
 * @version 1.0
 * @package Application
 */

class Application_Global_View_Helper_CssHelper extends Zend_View_Helper_Abstract 
{ 
    
    /**
     * Auto load exclusive css file for action
     *
     * @author          Siwei Mu
     * @param           void
     * @return          css html reference
     *
     */
    function cssHelper() { 
        
        $request = Zend_Controller_Front::getInstance()->getRequest(); 
        $file_uri = Zend_Registry::getInstance()->config->path->customskin . $request->getModuleName() . '/' . $request->getControllerName() . '/'. $request->getActionName() . '.css';
        
        if (file_exists($file_uri)) { 
            $this->view->headLink()->appendStylesheet('/' . $file_uri); 
        } 
        
        return $this->view->headLink(); 
    } 
}