<?php

/**
 * 
 * classe TFilter
 * Esta classe prov� uma interface para defini��o de filtros de sele��o
 * @author Salve
 *
 */
class TFilter extends TExpression
{
	private $_variavel;
	private $_operador;
	private $_valor;
	
	/*
	 * CONSTRUTOR
	 * Instancia um novo filtro
	 * @param $_variavel = vari�vel
	 * @param $_operador = operador de compara��o 
	 * @param $_valor = valor a ser comparado 
	 * */
	public function __construct($variavel, $operador, $valor)
	{
		$this->_variavel = $variavel;
		$this->_operador = $operador;
		$this->_valor = $valor;
			
	}
	
	
	/*
	 * m�todo transform
	 * Recebe um valor e faz as modifica��es necess�rias para 
	 * ele ser interpretado pelo banco de dados, podendo ser
	 * integer/string/boolean ou array contendo estes itens.
	 * @param $valor = valor a ser transformado
	 * */
	function transform($valor)
	{
		if(is_array($valor))
		{
			// percorre os valores
			foreach ($valor as $x) 
			{
				if(is_integer($x))
				{
					$vetor[] = $x;
				}
				else if(is_string($x))
				{
					$vetor[]= "'$x'";
				}
			}
			
			// converte o array em string separada por v�rgula
			$resultado = '(' . implode(',', $vetor) . ')';
		}
		else if(is_string($valor))
		{
			$resultado = "'$valor'";
		}
		else if(is_null($valor))
		{
			$resultado = 'NULL';
		}
		else if(is_bool($valor))
		{
			$resultado = $valor ? true : false;
		}
		else
		{
			$resultado = $valor;
		}
	}
	
	
	/**
	 * Retorna o filtro em forma de express�o
	 * @see app.ado/TExpression::dump()
	 */
	function dump()
	{
		// concatena a express�o
		return "{$this->_variavel}{$this->_operador}{$this->_valor}";
	}
	
}

?>