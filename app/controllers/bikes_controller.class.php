<?php
	class bikes_controller extends Controller{

		public function index_action() {
			echo 'pagina index<br>';
			echo MVC::getParams('nome');
			$this->view->assign('cache','sobrecarregando servidor');
			
			$this->view->display('htm.tpl');
		}

		public function modelo_action() {
		    
			var_dump(MVC::getParams());

			//$this->view->clearCache('htm.tpl',2);
			// clear the entire cache
			$this->view->clearAllCache();
			if(!$this->view->isCached('htm.tpl',2)){
				echo 'criou o cache<br>';
				$this->view->assign('cache','sobrecarregando servidor');
			}else{
				echo 'usou o cache<br>';
			}


			//$this->view->display('htm.tpl',2);
			$output = $this->view->fetch('htm.tpl',2);
			echo $output;

		}

		public function loja_action(){
			$rep =  new TRepository('Loja');
			$crit = new TCriteria();
			$crit->setProperty('limit', 3);
			$loja = $rep->load($crit);
			var_dump($loja);
		}

		public function noAction(){
			var_dump(MVC::getParams());
			echo 'no action faça suas condições aqui';
		}

		
	}
?>
