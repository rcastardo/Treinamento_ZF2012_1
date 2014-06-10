<?php

class Servicos_FinanceiroController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

	public function obterTaxaAction()
	{
		$referencia = $this->_getParam('referencia', 0);
		$regiao = $this->_getParam('regiao', 'nenhuma');
		$this->view->assign('taxa', $referencia * 41342);
		$this->view->assign('regiao', $regiao);
	}
}

