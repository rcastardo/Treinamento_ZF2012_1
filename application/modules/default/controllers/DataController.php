<?php

class Default_DataController extends Zend_Controller_Action
{

    public function init()
    {
        //desabilitando layout
     	$this->getHelper('layout')->disableLayout();
     	//desabilitando view
     	$this->getHelper('viewRenderer')->setNoRender(true);
     	date_default_timezone_set('America/Sao_Paulo');
    }

    public function indexAction()
    {
    	$locale = $this->_getParam('locale', 'pt_BR');
    	
        $data = new Zend_Date($locale);
        echo $data, '<br>';
        echo $data->get(Zend_Date::DATETIME_FULL);
    }


}

