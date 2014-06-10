<?php

class Default_XmlRpcController extends Zend_Controller_Action
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
       $server = new Zend_XmlRpc_Server();
       $server->setClass('Application_Model_Tradutor', 'tradutor');
       echo $server->handle(); 
    }


}

