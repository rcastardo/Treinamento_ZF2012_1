<?php

class Application_Form_Cliente extends Zend_Form
{

    public function init()
    {
    	$modelCliente = new Application_Model_Cliente();
    	
    	/*addDecorators pode alterar o estilo do form*/
    	$element = new Zend_Form_Element_Text('cpf');
    	$element->setLabel('CPF:');
    	$validators = $modelCliente->getValidator('cpf');
    	$element->addValidators($validators);
    	$filters = $modelCliente->getFilter('cpf');
    	$element->addFilters($filters);
    	$this->addElement($element);
    	
    	$element = new Zend_Form_Element_Text('nome');
    	$element->setLabel('Nome:');
    	$validators = $modelCliente->getValidator('nome');
    	$element->addValidators($validators);
    	$filters = $modelCliente->getFilter('nome');
    	$element->addFilters($filters);
    	$this->addElement($element);
    	
    	$element = new Zend_Form_Element_Submit('gravar');
    	$this->addElement($element);
    }
    
    public function setCliente(Zend_Db_Table_Row $cliente)
    {
		$this->getElement('cpf')->setValue($cliente->cpf);
		if(!empty($cliente->cpf))
		{
			$this->getElement('cpf')->setAttrib('readonly', 'readonly');
		}
		$this->getElement('nome')->setValue($cliente->nome);    
    }
}

