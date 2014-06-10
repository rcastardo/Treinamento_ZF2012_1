<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $action = $this->view->url(array(
        	'module' => 'admin',
        	'controller' => 'index',
        	'action' => 'login'
        ));
        
        $mensagem = $this->getHelper('flashMessenger')
        					->getMessages();
        					
        $this->view->assign('action', $action);
        $this->view->assign('mensagem', implode(',', $mensagem));  					
    }

    public function loginAction()
    {
    	$usuario = $_POST['usuario'];
    	$senha = $_POST['senha'];
    	
    	$db = $this->getInvokeArg('bootstrap')->getResource('db');
    	$auth = new Zend_Auth_Adapter_DbTable($db, 'usuarios', 'usuario', 'senha');
    	
    	$auth->setIdentity($usuario);
    	$auth->setCredential($senha);
    	$result = $auth->authenticate();
    	
    	if($result->isValid())
    	{
    		$usuario = $auth->getResultRowObject(null, 'senha');
    		Zend_Auth::getInstance()->getStorage()->write($usuario);
    		Zend_Registry::get('seg')->acl = $this->_getAcl($usuario);
    		$this->_redirect('admin/cliente');
    	}
    	else
    	{
    		$mensagens = $result->getMessages();
    		foreach ($mensagens as $mensagem)
    		{
    			$this->getHelper('flashMessenger')->addMessage($mensagem);
    		}
    		$this->_redirect('admin/index');
    	}
    }
    
    public function logoutAction()
    {
    	Zend_Auth::getInstance()->clearIdentity();
    	Zend_Session::destroy();
    	$this->_redirect('admin/index');    	
    }
    
    private function _getAcl($usuario)
    {
    	$acl = new Zend_Acl();
    	$config  = new Zend_Config_Ini(
    		APPLICATION_PATH .
    		DIRECTORY_SEPARATOR . 
    		'configs'. 
    		DIRECTORY_SEPARATOR .
    		'acl.ini'
    	);
    	
    	$papeis = $config->papeis->toArray();
    	foreach($papeis as $papel)
    	{
    		$acl->addRole($papel);
    	}
    	$recursos = $config->recursos->toArray();
    	
    	foreach ($recursos as $recurso) 
    	{
    		$acl->addResource($recurso);
    	}
    	
    	$permissoes = $config->permissoes->toArray();
    	foreach ($permissoes as $permissao)
    	{
//    		$permissao = explode(',', $permissao);
    		list($papel, $recurso) = explode(',', $permissao);
    		//0 - papel 1 - recuso
//    		$acl->allow($permissao[0],$permissao[1]);
    		$acl->allow($papel, $recurso);
    	}
    	return $acl;
    }

}

