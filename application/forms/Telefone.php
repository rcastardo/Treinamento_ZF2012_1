<?php

class Application_Form_Telefone extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$element = new Zend_Form_Element_Text('numero');
    	$element->setLabel('Numero:');
    	$this->addElement($element);
    	
    	$element = new Zend_Form_Element_Hidden('cpf');
    	$this->addElement($element);
    	
    	$element = new Zend_Form_Element_Submit('inserir');
    	$this->addElement($element);
    }

    public function setCpf($cpf)
    {
    	if(empty($cpf))
    	{
    		$this->removeElement('cpf');
    		$this->removeElement('numero');
    		$this->removeElement('inserir');
    	}
    	else
    	{
    		$this->getElement('cpf')->setValue($cpf);
    	}	
    }
}

