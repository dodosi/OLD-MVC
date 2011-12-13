<?php

/**
 * Esta classe prov� os m�todos necess�rios para manipular cole��es de objetos.
 * @author Salve
 */
final class TRepository
{
	private $_classe; // nome da classe manipulada pelo reposit�rio
	
	/**
	 * Instancia um reposit�rio de objetos
	 * @param $classe = nome da classe de objetos que precisa ser retornada.
	 */
	public function __construct($classe)
	{
		$this->_classe = $classe;
	}
	
	
	/**
	 * Recupera um conjunto de objetos (collection) do banco de dados
	 * usando um crit�rio de sele��o e instancia os objetos em mem�ria
	 * @param TCriteria $criterio = objeto TCriteria
	 * @param TSqlSelect $sql = objeto TSqlSelect 
	 */
	public function load(TCriteria $criterio=null,TSqlSelect $sql=null)
	{
		if(!$sql)
		{
			$sql = new TSqlSelect();
			$sql->addColumn('*');
		}
		
		$sql->setEntity(constant($this->_classe . '::TABLENAME'));
		$criterio = $criterio==null ? new TCriteria() : $criterio;
		$sql->setCriteria($criterio);
		
		// SELECIONA
		// TODO: Implementar transa��o (se julgar necss�rio)
		$conn = TConnection::open();
		//echo $sql->getSQL();
		$result = $conn->query($sql->getSQL());
		$resultados = array();
		
		if($result)
		{
			while ($row = $result->fetchObject($this->_classe))
			{
				// percorre o resultado, retornando um objeto 
				// e armazenando no vetor $resultados
				$resultados[] = $row;
			}
		}
		$conn = null;
		
		return $resultados;
	}
	
	
	/**
	 * Exclui um conjunto de objetos (collection) do banco de dados 
	 * @param TCriteria $criterio = objeto TCriteria
	 */
	public function delete(TCriteria $criterio=null)
	{
		$sql = new TSqlDelete();
		$sql->setEntity(constant($this->_classe . '::TABLENAME'));
		if($criterio)
		{
			$sql->setCriteria($criterio);
		}
		
		// EXCLUI
		// TODO: Implementar transa��o (se julgar necss�rio)
		$conn = TConnection::open();
		$result = $conn->exec($sql->getSQL());
		$conn = null;
		
		return $result;
	}
	
	
	/**
	 * Retorna a quantidade de objetos no banco de dados
	 * que obedecem ao crit�rio passado
	 * @param TCriteria $criterio = objeto TCriteria
	 */
	public function count(TCriteria $criterio=null)
	{
		$sql = new TSqlSelect();
		$sql->setEntity(constant($this->_classe . '::TABLENAME'));
		$sql->addColumn('COUNT(*)');
		$sql->setCriteria($criterio);
		
		// CONTA
		// TODO: Implementar transa��o (se julgar necss�rio)
		$conn = TConnection::open();
		$result = $conn->query($sql->getSQL());
		$conn = null;
		
		if($result)
		{
			$row = $result->fetch();
		}
		
		return $row[0];
	}
	
}

?>