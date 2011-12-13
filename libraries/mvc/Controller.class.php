<?php

/*
 * Classe de controle
 */
abstract class Controller{

		protected $view;

		public function  __construct() {
			$this->view = new View();
			$this->view->assign('DIR_HTM_ROOT', DIR_HTM_ROOT);
			$this->view->assign('DIR_ROOT', DIR_ROOT);
		}

		public function noAction(){
			echo 'Erro. N�o existe essa Action';
		}

		public function init(){
			//opcional
		}

	}
?>
