<?php

class Default_DbController extends Zend_Controller_Action
{

	public function init()
    {
     	//desabilitando layout
     	$this->getHelper('layout')->disableLayout();
     	//desabilitando view
     	$this->getHelper('viewRenderer')->setNoRender(true);
    }

    public function indexAction()
    {
        $mapper = new Application_Model_DbTable_Cliente();
                
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        
        $profiler = $db->getProfiler();
        $profiler->setEnabled(true);
        
        $select = $mapper->select();
        $select->setIntegrityCheck(false)
        ->from(array('c' => 'clientes'), array('nome', 'd' => new Zend_Db_Expr('DATE_FORMAT(NOW(), "%d/%m/%Y")')))
        ->joinLeft(array('t' => 'telefones'), 'c.cpf = t.cpf')
        ->order('c.nome');
        //$select->columns('nome');
        
        //sem o argumento realiza um query comum
        $rows = $mapper->fetchAll($select);
        
        $log = Zend_Registry::get('log');
        $profile = $profiler->getLastQueryProfile();
        $log->debug($profile->getQuery());
        
        /*echo '<pre>';
        print_r($rows);
        echo '</pre>';*/
        foreach ($rows as $row)
        {
        	echo "{$row->nome} {$row->numero} {$row->d}<br>";
        }
    }


}

