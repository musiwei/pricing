<?php 
class Pricingmanagement_View_Helper_JavascriptHelper extends Zend_View_Helper_Abstract
{   
    function javascriptHelper() {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = 'skin/custom/' . $request->getModuleName() . '/' . $request->getControllerName() . '/'. $request->getActionName() . '.js';

        if (file_exists($file_uri)) {
            $this->view->headScript()->appendFile('/' . $file_uri);
        }
        
        return $this->view->headScript();
    }
}