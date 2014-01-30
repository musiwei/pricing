<?php  
class Pricingmanagement_View_Helper_CssHelper extends Zend_View_Helper_Abstract 
{ 
    function cssHelper() { 
        $request = Zend_Controller_Front::getInstance()->getRequest(); 
        $file_uri = 'skin/custom/' . $request->getModuleName() . '/' . $request->getControllerName() . '/'. $request->getActionName() . '.css';
        
        if (file_exists($file_uri)) { 
            $this->view->headLink()->appendStylesheet('/' . $file_uri); 
        } 
         
        return $this->view->headLink(); 
         
    } 
    function abc(){
    	echo 1;
    }
}