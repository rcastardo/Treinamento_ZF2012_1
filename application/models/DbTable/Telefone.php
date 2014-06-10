<?php

class Application_Model_DbTable_Telefone extends Zend_Db_Table_Abstract
{
    protected $_name = 'telefones';
    protected $_referenceMap = array(
    			'PertenceACliente' => array(
    				'columns' => 'cpf',//ligado ao tampo cpf referenciado pela dbtable cliente
    				'refColumns' => 'cpf',
    				'refTableClass' => 'Application_Model_DbTable_Cliente' 
    				)
    		  );//relacionamentos FK - cada elemento e um relacionamento
    
}