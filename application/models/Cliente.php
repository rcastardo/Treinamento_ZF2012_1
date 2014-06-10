<?php

class Application_Model_Cliente
{
	/**
	 *@property Zend_Db_Table_Abstract 
	 */
	private $_mapper = array('cliente' => null, 'telefone' => null);
	private $_validators = array();
	private $_filters = array();
	/*protected $_metadata = array(
		'cpf' => array(
						'COLUMN_NAME' => '$cpf',
						'DATA_TYPE' => 'VARCHAR',
						'DEFAULT' => ' ',
						'NULLABLE' => false,
						'LEHGTH' => 30,
						'PRIMARY' => true
	 				  )	
	);*/
		
	public function __construct()
	{
		$this->_mapper['cliente'] = new Application_Model_DbTable_Cliente();
		$this->_mapper['telefone'] = new Application_Model_DbTable_Telefone();
		
		$this->_validators = array(
			'cpf' => array(
				new Zend_Validate_Int(),
				new Zend_Validate_NotEmpty(),
				),
		    'nome' => array(
					new Zend_Validate_Alpha(),
					new Zend_Validate_StringLength(
						array('min' => 4,
						'max' => 10
						)
					)
				)		
		);
		
		$this->_filters = array(
			'cpf' => array(new Zend_Filter_Int()),
			'nome' => array(new Zend_Filter_StringToUpper())	
		);
	}
	
	public function getValidator($element)
	{
		return $this->_validators[$element];
	}
	
	public function getFilter($element = null)
	{
		if(is_null($element))
		{
			return $this->_filters;
		}
		return $this->_filters[$element];
	}
	
	public function getCliente($cpf = null)
	{
		$cliente = null;
		if(!empty($cpf))
		{
			$cliente = $this->_mapper['cliente']->find($cpf)->current();			
		}
		if(empty($cliente))
		{
			$cliente = $this->_mapper['cliente']->createRow();
		}
		return $cliente;
	}
	
	public function save(Zend_Db_Table_Row $row)
	{
		$mensagem = 'Registro gravado com sucesso';
		try {
			$row->save();	
		} catch (Exception $e) {
			$mensagem = $e->getMessage();
		}
		return $mensagem;
	}
	
	public function getClientes()
	{
		return $this->_mapper['cliente']->fetchAll();
	}
	
	public function excluirCliente($cpf)
	{
		$where = $this->_mapper['cliente']->getAdapter()->quoteInto('cpf = ?', $cpf);
		$this->_mapper['cliente']->delete($where);
		$this->excluirTelefone(null, $cpf);
	}
	///////////////////////
	public function getTelefone($id = null)
	{
		$telefone = null;
		if(!empty($id))
		{
			$telefone = $this->_mapper['telefone']->find($id)->current();			
		}
		if(empty($telefone))
		{
			$telefone = $this->_mapper['telefone']->createRow();
		}
		return $telefone;
	}
			
	public function getTelefones($cpf)
	{
		//comentado pois agora utiliza plugin anhanguera
		//$where = $this->_mapper['telefone']->getAdapter()->quoteInto('cpf = ?', $cpf);
		//return $this->_mapper['telefone']->fetchAll($where);

		$cliente = $this->getCliente($cpf);
		if(empty($cliente->cpf)) return array();
		return $cliente->findDependentRowsetTelefone();
	}
	
	public function excluirTelefone($id = null, $cpf = null)
	{
		$adapter = $this->_mapper['telefone']->getAdapter();
		if(empty($id))
		{
			$where = $adapter->quoteInto('cpf = ?', $cpf);
		}
		else 
		{
			$where = $adapter->quoteInto('id = ?', $id);
		}
		$this->_mapper['telefone']->delete($where);
	}
}

