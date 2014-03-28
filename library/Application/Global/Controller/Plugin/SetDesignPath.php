<?php

/**
 * Provide a Magento-like view and layout rendering approach
 * 
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 16 Mar 2014
 * @version 1.0
 * @package Global Controller Plugin
 */

class Application_Global_Controller_Plugin_SetDesignPath extends Zend_Controller_Plugin_Abstract
{
    
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
	    
		# prepare paths
	    $viewPath            = Zend_Registry::getInstance()->application->path->design->view;
	    $layoutPath          = Zend_Registry::getInstance()->application->path->design->layout;
	    $themeFolderName     = Zend_Registry::getInstance()->application->theme;
	    
	    # set up view path
		$viewPath_base       = sprintf($viewPath->base, $request->getModuleName());
		$viewPath_template   = sprintf($viewPath->default, $themeFolderName, $request->getModuleName());
		$viewPath_custom     = sprintf($viewPath->custom, $themeFolderName, $request->getModuleName());
		
		# set up layout path
		$layoutPath_base     = $layoutPath->base;
		$layoutPath_template = sprintf($layoutPath->default, $themeFolderName);
		$layoutPath_custom   = sprintf($layoutPath->custom, $themeFolderName);
		
		# the following views and layout are applied in reverse adding order (last in, first apply)
		
		# base view
		$this->_addScriptAndLayoutPath($viewPath_base, $layoutPath_base);

		# template view
		$this->_addScriptAndLayoutPath($viewPath_template, $layoutPath_template);
		
		# custom view
		$this->_addScriptAndLayoutPath($viewPath_custom, $layoutPath_custom);
	}
	
	/**
	 * Add script and layout path if they exist
	 *
	 * @author Siwei Mu
	 * @param $viewPath string
	 * @param $layoutPath string
	 * @return void
	 */
	protected function _addScriptAndLayoutPath($viewPath, $layoutPath){
	    
	    # get current view
	    $view = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer')->view;
	    
	    # prepare layout file name
	    $layoutFileName = Zend_Registry::getInstance()->application->layoutFileName;
	    $layoutFileNameWithExtention = $layoutFileName.".phtml";
	    
	    # check if the view path exists
	    if (file_exists($viewPath)) {
	        
	    	$view->addScriptPath($viewPath);
	    	
	    	# check if the layout file exists
	    	if (file_exists($layoutPath.$layoutFileNameWithExtention)) {
	    		Zend_Layout::getMvcInstance()->setLayout($layoutFileName);
	    		Zend_Layout::getMvcInstance()->setLayoutPath($layoutPath);
	    	}
	    }
	}
}