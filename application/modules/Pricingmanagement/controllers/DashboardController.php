<?php

/**
 * @author Siwei Mu (musiwei.work@gmail.com)
* @copyright Newton's Nerds
* @since 02 Feb 2014
* @version 1.0
* @package Pricingmanagement Module
*/

class Pricingmanagement_DashboardController extends Zend_Controller_Action
{

	public function indexAction ()
	{

		$result1 = '';
		$cache = Zend_Registry::get('cache');

		if (! $result1 = $cache->load('mydata')) {
			echo 'caching the data...';
			$data = array(
					1,
					2,
					3
			);
			$cache->save($data, 'mydata');
		} else {
			echo 'retrieving cache data...';

			Zend_Debug::dump($cache->load('mydata'));
		}

		$this->_helper->LayoutInit('Home');
	}
}

