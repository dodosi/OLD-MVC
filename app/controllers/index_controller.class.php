<?php
	class index_controller extends Controller{

		public function index_action() {
					
			$this->view->display('navMenu.tpl');
		}

		public function modelo_action() {
			var_dump(MVC::getParams());
			echo 'pagina de teste<br>';
			$this->view->display('htm.tpl');
		}

		public function loja_action(){
			$rep = new TRepository('Loja');
			$crit = new TCriteria();
			$crit->add(new TFilter('bool_exibir', '=', 1));
			$crit->add(new TFilter('bool_exibir', '=', 1));
			$crit->add(new TFilter('teste', '=', 2));
			$crit->add(new TFilter('oper', ' AND ', 'nnn'), TCriteria::OR_OPERATOR);
			$crit->remove(3);
			echo $crit->dump();
		}

		
	}
?>
