<?php

class Application_Model_Cambio implements Zend_Currency_CurrencyInterface
{

	public function getRate($from, $to)
	{
		if($from == 'USD')
		{
			if($to == 'BRL')
			{
				return 0.5;
			}
			if($to == 'EUR')
			{
				return 1.5;
			}
		}
		
		if($from == 'BRL')
		{
			if($to == 'USD')
			{
				return 2;
			}
			if($to == 'EUR')
			{
				return 3;
			}
		}
	}
}