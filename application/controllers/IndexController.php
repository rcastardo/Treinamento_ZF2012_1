<?php

class IndexController extends Zend_Controller_Action
{
	private $_modelCliente = null;
	
    public function init()
    {
    	$this->getHelper('layout')->setLayout('outrolayout');
    	$this->view->headTitle('telefones');
        $this->_modelCliente = new Application_Model_Cliente();
        //$this->view->assign('script', 'nome do arquivo');
        //$zf = new Zend_Layout();
        
    }

    public function indexAction()
    {
    	if($this->getRequest()->isXmlHttpRequest())
    	{
    		//desabilitando layout
     		$this->getHelper('layout')->disableLayout();
     		//desabilitando view
     		$this->getHelper('viewRenderer')->setNoRender(true);
    		echo $this->_getTelefones();
    	}
    	else 
    	{
	        $clientes = $this->_modelCliente->getClientes();
	        
	        $options = array();
	        
	        foreach($clientes as $cliente)
	        {
	        	$options[$cliente->cpf] = $cliente->nome;
	        }
	        
	        $select = $this->view->formSelect('cpf', null, null, $options);
	        $this->view->assign('select', $select);
	        
	       /* $action = $this->view->url(
	        	array(
	        		'module' => 'default',
	        		'controller' => 'index',
	        		'action' => 'ver-telefones'
	        		),
	        		null,
	        		true
	        );
	        $this->view->assign('action', $action);*/
    	}
    }

    private function _getTelefones()
    {
        $cpf = $this->_getParam('cpf');
        
        $telefones = $this->_modelCliente->getCliente($cpf)->findDependentRowsetTelefone();
        			//	->findDependentRowSet('Application_Model_DbTable_Telefone');
        $options = array();
        foreach ($telefones as $telefone)
        {
        	$options[$telefone->id] = $telefone->numero;
        }
        
        $select = $this->view->formSelect('telefone', null, null, $options);
       // $this->view->assign('select', $select);
        return $select;
    }
    
	public function localAction()
	{
		//desabilitando layout
     	$this->getHelper('layout')->disableLayout();
     	//desabilitando view
     	$this->getHelper('viewRenderer')->setNoRender(true);
     	
		$moeda = new Zend_Currency(array('precision' => 7));
		$moeda->setValue(3.1415926);
		
		$data = new Zend_Date();
		$data->set('29/02/2012', Zend_Date::DATES);
		$data->set('13:45:21', Zend_Date::TIMES);
		$data->add('30', Zend_Date::DAY);		
		
		echo $moeda,'<br>',$data;
	}
	
	
	public function traduzirAction()
	{
		$tradutor = new Application_Model_Tradutor();
		
		echo $tradutor->traduzir(`bom dia`);exit;
	}
	
	
	


}



