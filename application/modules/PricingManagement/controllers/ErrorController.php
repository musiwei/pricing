<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 */

class Pricingmanagement_ErrorController extends Zend_Controller_Action
{

    public function init()
    {

    }
    
    
    public function errorAction()
    {
        
        $errors = $this->_getParam('error_handler');
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->responseCode = $this->getResponse()->getHttpResponseCode();
                $this->view->message = 'Page not found';
                $this->_helper->LayoutInit('Woops! Page not found',
                		array(
                				'bodyClass'     => 'minimal error-page',
                				'hasHeader'     => '0',
                				'hasSidebar'    => '0',
                		        'hasBreadcrumb' => '0'
                		));
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Application error';
                $this->_helper->LayoutInit('Woops! Application error',
                		array(
                				'bodyClass'     => 'minimal error-page',
                				'hasHeader'     => '0',
                				'hasSidebar'    => '0',
                		        'hasBreadcrumb' => '0'
                		));
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getRequest()->_logger) {
            $log->crit($this->view->message . ': ' . $errors->exception, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->parameters = var_export($errors->request->getParams(), true);
    }


}

