<?php 

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 */

class Pricingmanagement_View_Helper_CssHelper extends Zend_View_Helper_Abstract 
{ 
    
    /**
     * Auto load exclusive css file for action
     *
     * @return css html reference
     */
    function cssHelper() { 
        
        $request = Zend_Controller_Front::getInstance()->getRequest(); 
        $file_uri = Zend_Registry::getInstance()->path->customskin . $request->getModuleName() . DIRECTORY_SEPARATOR . $request->getControllerName() . DIRECTORY_SEPARATOR. $request->getActionName() . '.css';
        
        if (file_exists($file_uri)) { 
            $this->view->headLink()->appendStylesheet('/' . $file_uri); 
        } 
         
        return $this->view->headLink(); 
         
    } 
}