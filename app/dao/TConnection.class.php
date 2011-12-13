<?php

/**
 * TConnection
 * Classe de conex�o com banco de dados
 * @author Salve
 *
 */
final class TConnection
{
	private function __construct()
	{
		// intencionalmente private e vazio (n�o permite instanciar objetos)
	}
	
	/**
	 * Fun��o est�tica open
	 * Abre uma conex�o ao banco de dados
	 * Se n�o passar nenhum nome de arquivo no par�metro $arquivo_db, conecta ao banco padr�o da aplica��o
	 * @param $arquivo_db
	 */
	public static function open($arquivo_db='')
	{
		// verifica se existe o arquivo "config.ini" para buscar as configura��es do banco
		// TODO: classe config que centraliza a busca dessas informa��es
		$dir_config = CONFIG;
		
		
		if($arquivo_db=='')
		{
			// Se n�o passou nenhum nome de arquivo, conecta ao banco padr�o da aplica��o
			$arquivo_config = 'config.ini';
			
			if(!file_exists($dir_config . $arquivo_config))
			{
				throw new Exception("Arquivo {$dir_config}{$arquivo_config} n�o encontrado.");
			}
			else
			{ 
				$config = parse_ini_file($dir_config . $arquivo_config);
				//var_dump($config);
				$arquivo_db = $config['db'];
			} 
		}
		//echo 'arquivo_db: ' . $arquivo_db . '<br /><br />';
		//echo ($dir_config . $arquivo_db);
		
		if(!file_exists($dir_config . $arquivo_db)) 
		{
			throw new Exception("Arquivo {$arquivo_db} n�o encontrado.");
		}
		else
		{
			$config_db = parse_ini_file($dir_config . $arquivo_db); 
			//var_dump($config_db);
		}
		
		// recupera as vari�veis
		$db_tipo 	= $config_db['tipo']; 
		$db_host 	= $config_db['host'];
		$db_nome 	= $config_db['nome'];
		$db_usuario = $config_db['usuario'];
		$db_senha 	= $config_db['senha'];
		$db_porta 	= $config_db['porta'];

//		$db_tipo 	= 'mysql'; 
//		$db_host 	= 'localhost';
//		$db_nome 	= 'caloi';
//		$db_usuario = 'root';
//		$db_senha 	= '';
//		$db_porta 	= '';
		
		
		
		switch ($db_tipo)
		{
			case 'pgsql':
				$db_porta = $db_porta ? $db_porta : '5432';
				$conn = new PDO("pgsql:dbname={$db_nome}; user={$db_usuario}; password={$db_senha}; host={$db_host}; port={$db_porta}");
				break;
			
			case 'mysql': 
				$db_porta = $db_porta ? $db_porta : '3306';
				$conn = new PDO("mysql:host={$db_host}; dbname={$db_nome}; port={$db_porta}", $db_usuario, $db_senha);
				break;
			
			case 'sqlite': 
				$conn = new PDO("sqlite:{$db_nome}");
				break;
			
			case 'ibase': 
				$conn = new PDO("firebird:dbname={$db_nome}", $db_usuario, $db_senha);
				break;
			
			case 'oci8': 
				$conn = new PDO("oci:dbname={$db_nome}", $db_usuario, $db_senha);
				break;
			
			case 'mssql': 
				$conn = new PDO("mssql:host={$db_host}, 1433; dbname={$db_nome}", $db_usuario, $db_senha);
				break;
		}
		
		// define o atributo error mode para lan�ar exce��es em caso de erro
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $conn;
	} 
	
	
	
	
}


?>