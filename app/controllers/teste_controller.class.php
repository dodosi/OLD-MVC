<?php

/**
 * @author Salve
 */
class testeController extends Controller {

    public function indexAction(){
		echo 'pagina do controle teste<br>';
		$this->view->display('htm.tpl');

	}

}
?>
