<?php

class Default_SoapController extends Zend_Controller_Action
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
    	if(isset($_GET['wsdl']))
    	{
    		$server = new Zend_Soap_AutoDiscover();
    	}
    	else 
    	{
        	$server = new Zend_Soap_Server('http://localhost/bueno/default/soap?wsdl');
    	}	
        $server->setClass('Application_Model_Tradutor');
        echo $server->handle(); 
    }


}

