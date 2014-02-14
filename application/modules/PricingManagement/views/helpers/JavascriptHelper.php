<?php 

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 */

class Pricingmanagement_View_Helper_JavascriptHelper extends Zend_View_Helper_Abstract
{   
    
    /**
     * Auto load exclusive javascript file for action
     *
     * @return javascript html reference
     */
    function javascriptHelper() {
        
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = Zend_Registry::getInstance()->path->customskin . $request->getModuleName() . DIRECTORY_SEPARATOR . $request->getControllerName() . DIRECTORY_SEPARATOR . $request->getActionName() . '.js';
        
        if (file_exists($file_uri)) {
            $this->view->headScript()->appendFile('/' . $file_uri);
        }
        
        return $this->view->headScript();
    }
}