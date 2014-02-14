<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 13 Feb 2014
 * @version 1.0
 */

class Pricingmanagement_Controller_Action_Helper_DoctrineInit extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Get Doctrine container
     *
     * @return A Doctrine container
     */
    public function getDoctrineContainer(){
        
    	return $this->getActionController()->getInvokeArg('bootstrap')->getResource('doctrine');
    }
    
    /**
     * Get Entity manager
     *
     * @return An entity manager
     */
    public function getEntityManager(){
        
    	$doctrine = $this->getDoctrineContainer();
        $em = $doctrine->getEntityManager();
        return $em;
    }
    
    /**
     * Get repository
     * 
     * @param string Repository path
     * @return Specific repository
     */
    public function getRepository($repository){
        
        $em = $this->getEntityManager();
        $rep = $em->getRepository($repository);
        return $rep;
    }

}