<?php
require_once 'app/config/config.php';

$controller		= $_REQUEST['controller'] . '_controller';
$action			= $_REQUEST['action'] . '_action';
$controller_path	=  CONTROLLERS . $controller . '.class.php';

if(!file_exists($controller_path))
{
    die('Houve um erro. O controler não existe');
}
else
{
    $app = new $controller();
    if(!method_exists($app, $action))
    {
	    $app->noAction();
    }else
    {
	    $app->$action();
    }
}


