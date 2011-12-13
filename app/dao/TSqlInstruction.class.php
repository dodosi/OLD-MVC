<?php

/**
 * classe TSqlInstruction
 * Esta classe prov� os m�todos comuns a todas as instru��es SQL do CRUD
 * @author Salve
 *
 */
abstract class TSqlInstruction
{
	protected $_sql; 		// string da instru��o SQL
	protected $_criterio; 	// objeto crit�rio (TCriteria)
	protected $_entidade; 		// nome da entidade (tabela)
	protected $_valoresColunas; // vetor com os pares coluna/valor 
	
	/**
	 * Define a entidade
	 * @param unknown_type $entidade
	 */
	final public function setEntity($entidade)
	{
		$this->_entidade = $entidade;
	}
	
	/**
	 * Retorna a entidade
	 */
	final public function getEntity()
	{
		return $this->_entidade;
	}
	
	/**
	 * Define o crit�rio
	 * @param TCriteria $criterio
	 */
	public function setCriteria(TCriteria $criterio=null)
	{
		$this->_criterio = $criterio;
	}
	
	/**
	 * Retorna a string com a instru��o SQL completa
	 */
	abstract function getSQL();
	
	
	
	
	/**
	 * Armazena no vetor $_valoresColunas cada par coluna/valor
	 * Usado apenas em INSERT e UPDATE
	 * @param unknown_type $coluna 
	 * @param unknown_type $valor
	 */
	public function setRowData($coluna, $valor)
	{
		// s� executa se for um dado escalar (string, inteiro, ...)
		if(is_scalar($valor))
		{
			if(is_string($valor) && (!empty($valor)))
			{
				$valor = addslashes($valor);
				$this->_valoresColunas[$coluna] = "'$valor'";
			}
			else if(is_bool($valor))
			{
				$this->_valoresColunas[$coluna] = $valor ? 'TRUE' : 'FALSE';
			}
			else if($valor!=='')
			{
				$this->_valoresColunas[$coluna] = $valor;
			}
			else
			{
				$this->_valoresColunas[$coluna] = 'NULL';
			}
		}
	}
	
	
	
}


?>