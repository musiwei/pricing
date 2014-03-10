<?php 

/**
 * Global Translator
 *
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 25 Feb 2014
 * @version 1.0
 * @package Application
 */

class Application_View_Helper_T extends Zend_View_Helper_Abstract 
{ 
    /**
     * Translate string
     *
     * @author          Siwei Mu
     * @param           string $string
     * @return          string $translatedString
     *
     */
    public function T($string)
    {
        $translatedString = Zend_Registry::get('Zend_Translate')->translate($string);
        return $translatedString;
    }
}