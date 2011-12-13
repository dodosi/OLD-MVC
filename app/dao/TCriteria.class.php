<?php

/**
 * classe TCriteria
 * Esta classe prov� uma interface utilizada para defini��o de crit�rios
 * @author Salve
 *
 */
class TCriteria extends TExpression
{
	private $_expressoes;  	// armazena a lista de express�es
	private $_operadores;  	// armazena a lista de operadores
	private $_propriedades; // propriedades do crit�rio
	public $_bool_tem_filtro = false; // define se tem ou n�o filtro WHERE
	
	
	/**
	 * CONSTRUTOR
	 */
	function __construct()
	{
		$this->_expressoes = array();
		$this->_operadores = array();
	}
	
	
	/**
	 * m�todo add
	 * Adiciona uma express�o ao crit�rio
	 * @param TFilter $expressao = express�o (objeto TFilter)
	 * @param unknown_type $operador = operador l�gico de compara��o
	 */
	public function add(TFilter $expressao, $operador = self::AND_OPERATOR)
	{
		// na primeira vez, n�o precisa de operador l�gico para concatenar
		if(empty($this->_expressoes))
		{
			$operador = NULL;
			$this->_bool_tem_filtro = true;
		}

		// agrega o resultado da express�o � lista de express�es
		$this->_expressoes[] = $expressao;
		$this->_operadores[] = $operador;
	}

	/**
	 * m�todo remove
	 * Remove uma express�o do criterio, apartir do seu indice
	 * @param Int $indice
	 */
	public function remove($indice){
		unset($this->_expressoes[$indice]);
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see app.ado/TExpression::dump()
	 */
	public function dump()
	{
		// concatena a lista de express�es
		if(is_array($this->_expressoes))
		{
			if(count($this->_expressoes)>0)
			{
				$resultado = '';
				foreach ($this->_expressoes as $i=>$expressao)
				{
					$operador = $this->_operadores[$i];
					// concatena o operador com a respectiva express�o
					$resultado .= $operador . $expressao->dump() . ' ';
				}
				$resultado = trim($resultado);
				return "({$resultado})";
			}
		}
	}
	
	
	/**
	 * armazena o valor de uma propriedade no vetor $_propriedades
	 * @param unknown_type $propriedade = nome da propriedade
	 * @param unknown_type $valor		= valor da propriedade
	 */
	public function setProperty($propriedade, $valor)
	{
		$this->_propriedades[$propriedade] = isset($valor) ? $valor : NULL;
	}
	
	
	/**
	 * Retorna o valor de uma propriedade
	 * @param unknown_type $propriedade = nome da propriedade requisitada
	 */
	public function getProperty($propriedade)
	{
		if(isset($this->_propriedades[$propriedade]))
		{
			return $this->_propriedades[$propriedade];
		}
	}
	
}



?>