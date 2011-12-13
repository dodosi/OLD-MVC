<?php

/**
 * 
 * classe TExpression
 * classe abstrata para gerenciar express�es
 * @author Salve
 *
 */
abstract class TExpression
{
	//operadores l�gicos
	const AND_OPERATOR = ' AND ';
	const OR_OPERATOR = ' OR ';
	
	/**
	 * m�todo dump
	 * Deve ter implementado pelas classes-filha
	 * Retornar� a express�o resultante em forma de string
	 */
	abstract public function dump();
}
?>