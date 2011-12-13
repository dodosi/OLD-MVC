<?php

/**
 * Classe de visualização
 * @author Salve
 */

class View extends Smarty{

	function __construct()
	{
		parent::__construct();

		//habilitando o cache
		$this->caching = true;
		$this->cache_lifetime =30; //tepo em segundos

		
		$this->template_dir = VIEWS.'templates';
		$this->compile_dir = VIEWS.'templates_c';
		$this->cache_dir = VIEWS.'cache';
		$this->config_dir = VIEWS.'config';
	}

	
}
?>
