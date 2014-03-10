<?php
class Application_Global_Resource_Translate extends Zend_Application_Resource_ResourceAbstract
{
	const DEFAULT_REGISTRY_KEY = 'Zend_Translate';

	/**
	 * @var Zend_Translate
	 */
	protected $_translate;

	/**
	 * Defined by Zend_Application_Resource_Resource
	 *
	 * @return Zend_Translate
	 */
	public function init()
	{
		/*
		 * The translate settings for the application.ini should be loaded first
		* to set all necessary defaults, most importantly the adapter to use
		*
		* Since we can't know the load order of modules and/or application bootstrap
		* we set the application translate as dependecy if we are not the main Bootstrap
		*/

		if ('Bootstrap' !== get_class($this->getBootstrap())) {
			$this->getBootstrap()->getApplication()->bootstrap('translate');
		}
		return $this->getTranslate();
	}

	/**
	 * Retrieve translate object
	 *
	 * @return Zend_Translate
	 */
	public function getTranslate()
	{
		$options = $this->getOptions();

		if (!isset($options['data'])) {
			throw new Zend_Application_Resource_Exception(
					'No translation source data provided in the ini file for: '
					. get_class($this->getBootstrap()).'.'
			);
		}

		$adapter = isset($options['adapter']) ? $options['adapter'] : Zend_Translate::AN_ARRAY;
		$locale = isset($options['locale']) ? $options['locale'] : null;
		$translateOptions = isset($options['options']) ? $options['options'] : array();

		$key = ( isset ($options['registry_key']) && !is_numeric($options['registry_key']))
		? $options['registry_key']
		: self::DEFAULT_REGISTRY_KEY;

		// If no translate object was set in the registry we create it.
		if (!Zend_Registry::isRegistered($key)) {
			$this->_createTranslation($adapter, $options['data'], $locale, $translateOptions);
			
			// if there is, we should add a translation source to the existing translate object
		} elseif (Zend_Registry::isRegistered($key)) {
			$this->_translate = Zend_Registry::get($key);
			$this->_addTranslation($options['data'], $locale, $translateOptions);
		}
		
		Zend_Registry::set($key, $this->_translate);

		return $this->_translate;
	}

	protected function _createTranslation($adapter, $data, $locale, $options)
	{
		$this->_translate = new Zend_Translate(
				$adapter, $data, $locale, $options
		);
	}

	protected function _addTranslation($data, $locale, $options)
	{
		$this->_translate->addTranslation(
				$data, $locale, $options
		);
	}
}