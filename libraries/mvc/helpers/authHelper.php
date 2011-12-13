<?php

/**
 * 
 *
 * @author User
 */

class AuthHelper {
    public $nome;
    public $idade;

    public function  __construct() {
        return $this;
    }

    public function set_nome($nome){
        $this->nome = $nome;
        return $this;
    }

    public function set_idade($nome){
        $this->idade = $nome;
        return $this;
    }

}

$teste = new AuthHelper();

echo

$teste->set_nome('jeff')
->set_idade('23')
->set_idade('23')
->set_idade('24')
->nome;


?>
