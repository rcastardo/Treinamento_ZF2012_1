<?php

class Admin_ClienteController extends Zend_Controller_Action
{
	/**
	 *@property Application_Model_Cliente 
	 */
    private $_modelCliente = null;

    public function init()
    {
        $this->view = Zend_Registry::get('view');
    	$this->_modelCliente = new Application_Model_Cliente();
    }

    public function indexAction()
    {
        // action body
        $urlEditar = $this->view->url(
        	array(
        		'module' => 'admin',
        		'controller' => 'cliente',
        		'action' => 'editar'
        	),
        	null,
        	true
        );
        $this->view->assign('urlEditar', $urlEditar);
        
        //objeto
        $clientes = $this->_modelCliente->getClientes();
        
        $this->view->assign('clientes', $clientes);
        //helper
        $this->view->partialLoop()->setObjectKey('cliente');
        
        //placeholder
        $urlExcluir = $this->view->url(
        	array(
        		'module' => 'admin',
        		'controller' => 'cliente',
        		'action' => 'excluir'
        	)
        );
        
        $this->view->placeholder('url')->editar = $urlEditar;
        $this->view->placeholder('url')->excluir = $urlExcluir; 
        
        $urlLogout = $this->view->url(
        	array(
        		'module' => 'admin',
        		'controller' => 'index',
        		'action' => 'logout'
        	)
        );
        //'e o mesmo que $this->view->urlLogout 
        $this->view->assign('urlLogout', $urlLogout);
        
    }

    public function editarAction()
    {
        // action body
        $action = $this->view->url(
        	array(
        		'module' => 'admin',
        		'controller' => 'cliente',
        		'action' => 'gravar'
        	),
        	null,
        	true
        );
        $cpf = null;
        //$this->view->assign('action', $action);//chama a view
        if(isset(Zend_Registry::get('form')->editar))
        {
        	$form = Zend_Registry::get('form')->editar;
        	unset(Zend_Registry::get('form')->editar);
        }
        else
        {
        	$form = new Application_Form_Cliente();
        	$cpf = $this->_getParam('cpf', '');
        	$cliente = $this->_modelCliente->getCliente($cpf);
        	$form->setCliente($cliente);
        }
        $form->setAction($action);
        
        
        //find retorna colecao procurando pela chave
        //current 'e uma interface para retornar o elemento atual
        //$cliente = $this->_modelCliente->getMapper()->find($cpf)->current();
        
        					
		//if(empty($cliente)){
			//createRow() para criar um novo objeto
			//$cliente = $this->_modelCliente->getMapper()->createRow();
		//	$cliente = $this->_modelCliente->getCliente();
		//}
		
		//$this->view->assign('cliente', $cliente);
		$this->view->assign('form', $form);
		
		$formTelefone = new Application_Form_Telefone();
		$action = $this->view->url(
			array(
				'module' => 'admin',
				'controller' => 'cliente',
				'action' => 'gravar-telefone'//o h'iffen converte o t para T
			),
			null,
			true
		);		
		$formTelefone->setAction($action);
		$formTelefone->setCpf($cpf);
		$this->view->assign('formTelefone', $formTelefone);
		
		$this->view->partialLoop()->setObjectKey('telefone');
		$this->view->assign('telefones', $this->_modelCliente->getTelefones($cpf));
    }

    public function gravarAction()
    {
     	$form = new Application_Form_Cliente();

     	if(!$form->isValid($_POST))
     	{
     		Zend_Registry::get('form')->editar = $form;
     		$this->_redirect('admin/cliente/editar');
     		return;
     	}
    	//sem zend form utiliza a valida'cao no null
     	$post = new Zend_Filter_Input($this->_modelCliente->getFilter(), null, $_POST);
     	
        $cpf = $post->cpf;
        $nome = $post->nome;
        
        //$modelCliente = new Application_Model_Cliente();
        //entidade
        $cliente = $this->_modelCliente->getCliente($cpf);
        $cliente->cpf = $cpf;
        $cliente->nome = $nome;
        $mensagem = $this->_modelCliente->save($cliente);
        $this->view->assign('mensagem', $mensagem);
        
        $urlIndex = $this->view->url(
        	array(
        		'module' => 'admin',
        		'controller' => 'cliente',
        		'action' => 'index',
        	),
        	null,
        	true
        );
        $this->view->assign('urlIndex', $urlIndex); 
    }

    public function excluirAction()
    {
        // action body
        $cpf = $this->_getParam('cpf');
        $this->_modelCliente->excluirCliente($cpf);
        $this->_redirect('admin/cliente');
    }

    public function gravarTelefoneAction()
    {
    	$cpf = $_POST['cpf'];
    	$numero = $_POST['numero'];
    	
    	$telefone = $this->_modelCliente->getTelefone();
    	//Zend_Db_Table_Row -> campo cpf e numero
    	$telefone->cpf = $cpf;
    	$telefone->numero = $numero;
    	$this->_modelCliente->save($telefone);
    	
    	$this->_redirect('admin/cliente/editar/cpf/' . $cpf);
    }

}







