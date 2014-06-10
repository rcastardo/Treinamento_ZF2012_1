<?php

class Default_RestController extends Zend_Controller_Action
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
    	$server = new Zend_Rest_Server();
        $server->setClass('Application_Model_Tradutor');
        echo $server->handle(); 
    }
    
    public function testeAction()
    {
		$model = new Application_Model_Tradutor();
		echo $model->traduzir('bom dia');
    }
    


}

