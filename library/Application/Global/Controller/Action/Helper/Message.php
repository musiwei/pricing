<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 24 Feb 2014
 * @version 1.0
 */

class Application_Global_Controller_Action_Helper_Message extends Zend_Controller_Action_Helper_Abstract
{
    private $_view = null;
    
    /**
     * Set layout
     *
     * @param string $pageTitle value of page title
     * @param array $options list of options corresponding to placeholders
     */
    public function direct($messages, $namespace)
    {
        
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        $flashMessenger->setNamespace($namespace);
        foreach ($messages as $msg)
            $flashMessenger->addMessage($msg);
    }
}