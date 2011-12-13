<?php
$dir_string_root= $_SERVER["HTTP_HOST"] == "localhost" || substr($_SERVER["HTTP_HOST"],0,10) == "192.168.1." ? "/MeusProjetos/MVC/" : ""; // este e o diretorio raiz a ser considerado para o site
$dir_root		= $_SERVER["DOCUMENT_ROOT"] . $dir_string_root;
$dir_htm_root	= "http://" . $_SERVER["HTTP_HOST"] . $dir_string_root;

//VERSÃO APP ANTES DA PASTA RAIZ
//$dir_app =  explode('/',$dir_root);
//array_pop($dir_app);
//array_pop($dir_app);
//$dir_app		= implode('/', $dir_app);
//$dir_app		.='/app/';
//FIM APP

$dir_app		='app/';

session_start();
import_request_variables("gp");
////limpa_posts();


define('DIR_ROOT', $dir_root);
define('DIR_SITE_ROOT', $dir_root);
define('DIR_HTM_ROOT', $dir_htm_root);
define('DIR_APP', $dir_app);
define('SMARTY_SPL_AUTOLOAD',1);
define('MVC',DIR_SITE_ROOT . '/libraries/mvc/');
define('DAO',DIR_APP . 'dao/');
define('CONFIG',DIR_APP . 'config/');
define('CONTROLLERS',DIR_APP . 'controllers/');
define('VIEWS',DIR_APP . 'views/');
define('MODELS',DIR_APP . 'models/');

include_once DIR_SITE_ROOT . '/libraries/smarty/Smarty.class.php';

spl_autoload_register('meuAutoLoad');

function meuAutoLoad($classe)
{
	$vetor_pastas[] = MVC;
	$vetor_pastas[] = DAO;
	$vetor_pastas[] = CONFIG;
	$vetor_pastas[] = CONTROLLERS;
	$vetor_pastas[] = VIEWS;
	$vetor_pastas[] = MODELS;

	foreach($vetor_pastas as $pasta)
	{
		if(file_exists( $pasta . $classe . '.class.php'))
		{
			include_once( $pasta . $classe . '.class.php');
		}
	}
}
