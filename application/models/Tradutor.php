<?php

class Application_Model_Tradutor extends Zend_Translate
{
	
	public function __construct($options = array())
	{
		$options = array(
				'adapter' => 'Array',
				'content' => APPLICATION_PATH . DIRECTORY_SEPARATOR . 
				'resources' . DIRECTORY_SEPARATOR .  
				'traducao_' . Zend_Registry::get('Zend_Locale') . '.php'
			);
		parent::__construct($options);
	}
	
	/**
	 * 
	 * @param string $_texto
	 * @return string
	 */
	public function traduzir($_texto)
	{
		return $this->_($_texto);
	}
}

