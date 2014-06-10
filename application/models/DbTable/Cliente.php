<?php

class Application_Model_DbTable_Cliente extends Zend_Db_Table_Abstract
{

    protected $_name = 'clientes';
	protected $_dependentTables = array('Application_Model_DbTable_Telefone');//classe db_table que depende dela
	
	public function __construct($config = null)
	{
		parent::__construct($config);
		
		$this->setRowClass('Anhanguera_Db_Table_Row');
	}

}

