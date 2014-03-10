<?php 

/**
 * Global JavaScript Helper
 * Automatically search and append JS file as long as it exists
 * e.g. search in custom skin folder, if found: skin\custom\moduleName\controllerName\actionName.js, then append to view
 *
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 25 Feb 2014
 * @version 1.0
 * @package Application
 */

class Application_View_Helper_JavascriptHelper extends Zend_View_Helper_Abstract
{   
    
    /**
     *  Auto load exclusive javascript file for action
     *
     * @author          Siwei Mu
     * @param           void
     * @return          javascript html reference
     *
     */
    function javascriptHelper() {
        
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = Zend_Registry::getInstance()->config->path->customskin . $request->getModuleName() . DIRECTORY_SEPARATOR . $request->getControllerName() . DIRECTORY_SEPARATOR . $request->getActionName() . '.js';
        
        if (file_exists($file_uri)) {
            $this->view->headScript()->appendFile('/' . $file_uri);
        }
        
        return $this->view->headScript();
    }
}