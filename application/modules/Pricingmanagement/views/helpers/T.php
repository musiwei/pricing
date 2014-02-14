<?php 

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 02 Feb 2014
 * @version 1.0
 */

class Pricingmanagement_View_Helper_T extends Zend_View_Helper_Abstract 
{ 

   /**
    * Translator
    * 
    * @param string $string The string to be translated
    * @return string $translated The translated string
    */
    public function T($string)
    {
        $translated = Zend_Registry::get('Zend_Translate')->translate($string);
        return $translated;
    }
}