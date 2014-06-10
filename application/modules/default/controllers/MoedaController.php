<?php

class Default_MoedaController extends Zend_Controller_Action
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
    	$value = $this->_getParam('value', 0);
        $moeda = new Zend_Currency();
        $moeda->setValue($value);
        echo $moeda;
    }
    
    public function somaAction()
    {
    	$locale1 = $this->_getParam('locale1', 'pt_BR');
    	$locale2 = $this->_getParam('locale2', 'pt_BR');
    	
    	$value1 = $this->_getParam('value1', 0);
        $moeda1 = new Zend_Currency($locale1);
        $moeda1->setValue($value1);

        $value2 = $this->_getParam('value2', 0);
        $moeda2 = new Zend_Currency(array('precision' => 4), $locale2);
        $moeda2->setValue($value2);
        
        
        echo "Moeda 1 : {$moeda1}<br>";
        echo "Moeda 2 : {$moeda2}<br>";
        
       
        $soma = clone $moeda1;
        $soma->setService(new Application_Model_Cambio());
//soma       
//echo $moeda1->add($moeda2), '<br>';
//echo $soma->add($moeda2), '<br>';
		       
        echo $soma->add($moeda2), '<br>';
        
        echo "Moeda 1 : {$moeda1}<br>";
        echo "Moeda 2 : {$moeda2}<br>";
    }

    

}

