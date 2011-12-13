<?php
/*
 * classe TLogger
 * Esta classe prov� uma interface abstrata para defini��o de algoritmos de LOG
 */
abstract class TLogger
{
    protected $_filename;  // local do arquivo de LOG
    
    /*
     * instancia um logger
     * @param $filename = local do arquivo de LOG
     */
    public function __construct($nome_arquivo)
    {
        $this->_filename = $nome_arquivo;
        // reseta o conte�do do arquivo
        file_put_contents($nome_arquivo, '');
    }
    
    // define o m�todo write como obrigat�rio
    abstract function write($message);
}
?>