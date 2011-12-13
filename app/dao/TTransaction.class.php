<?php

/**
 * Transa��o de queries no banco de dados
 * @author Salve
 *
 */
final class TTransaction
{
	private static $_conn;
	
	/**
	 * N�o permite instanciar a classe
	 */
	private function __construct()
	{
		// intencionalmente deixado private e vazio (para n�o permitir instanciar a classe)
	}
	
	
	/**
	 * Abre a conex�o com com o banco e inicia a transa��o
	 * @param unknown_type $arquivo_db
	 */
	public static function open($arquivo_db='')
	{
		if(empty(self::$_conn))
		{
			self::$_conn = TConnection::open($arquivo_db);
			self::$_conn->beginTransaction();
		}
	}
	
	
	/**
	 * Retorna a conex�o ativa da transa��o
	 */
	public static function get()
	{
		return self::$_conn;
	}
	
	
	/**
	 * Desfaz todas as opera��es da transa��o
	 */
	public static function rollback()
	{
		if(self::$_conn)
		{
			self::$_conn->rollBack();
			self::$_conn = null;
		}
	}
	
	
	/**
	 * Aplica todas as opera��es e fecha a transa��o
	 */
	public static function close()
	{
		if(self::$_conn)
		{
			self::$_conn->commit();
			self::$_conn = null;
		}
	}
}
?>