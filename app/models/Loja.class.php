<?php

class Loja extends Model
{
	const TABLENAME = 'loja';
	
	const TAMANHO_FOTO = 500; // --> tamanho máximo do arquivo, em KBytes
	const LARGURA_FOTO = 100; // --> dimensão em pixels (redimensionamento)
	const ALTURA_FOTO = 60; // --> dimensão em pixels (redimensionamento)
	
	const TAMANHO_LOGOTIPO = 500; // --> tamanho máximo do arquivo, em KBytes
	const LARGURA_LOGOTIPO = 100; // --> dimensão em pixels (redimensionamento)
	const ALTURA_LOGOTIPO = 60; // --> dimensão em pixels (redimensionamento)
	
	const DESTINO_FOTO = '/img/lojas/fotos/';
	const DESTINO_LOGOTIPO = '/img/lojas/logotipos/';
	

	// variáveis que definem a busca_____________
	public static $_busca_vetor_campos = array('nome', 'url', 'endereco', 'complemento', 'bairro'); // vetor com os nomes dos campos em que será feita a pesquisa
	public function get_busca_vetor_campos() {return self::$_busca_vetor_campos;}
	const ROTULO = 'Loja'; // nome amigável da classe 
	const ROTULO_PLURAL = 'Lojas'; // nome amigável da classe no plural 
	const BUSCA_CAMPO_FOTO = 'arquivo_foto'; // nome do campo que retornará a imagem (definir NULL para item sem imagem)
	const BUSCA_PREFIXO_FOTO = '/img/lojas/fotos/'; // prefixo para o thumb da imagem (definir NULL para item sem imagem)
	const BUSCA_TITULO = 'nome'; // nome do campo que retornará o título (chamada)
	const BUSCA_QUANDO = null; // nome do campo que contém a data (definir NULL para item sem data)
	const BUSCA_TEXTO = 'endereco'; // nome do campo que retornará o texto (chamada)
	const BUSCA_DESTINO = '/onde_encontrar/'; // caminho para o item, a partir da raíz do site
	const BUSCA_DESTINO_CMS = '/lojas/detalhes_loja.php?id_loja=';   // caminho para o item, a partir da raíz do CMS
	const BUSCA_PROPRIEDADE_ID = ''; // nome da propriedade que identifica o destino (concatenar ao $_destino)
	const BUSCA_PROPRIEDADE_ID_CMS = 'id'; // nome da propriedade que identifica o destino no CMS
	const BUSCA_MAX_ITENS = null; // quantidade máxima de itens deste tipo que devem ser retornados (definir NULL para ilimitados)
	const BUSCA_ORDEM = 'nome'; // ordem SQL em que os resultados devem ser exibidos
	//___________________________________________
	
	public function meuMetodo(){
		return 'minha model';
	}


	public function delete($id=null)
	{
		$loja = $id ? new Loja($id) : $this;
		
		return parent::delete($loja->id);
	}
	
	
	public function get_nome_tipo($id=null)
	{
		$loja = $id ? new Loja($id) : $this;
		$tipo = new LojaTipo($loja->id_tipo);
		return $tipo->nome;
	}
	
	public function get_cidade()
	{
		$objCidade = new BrasilCidade($this->id_cidade);
		return $objCidade->nome; 
	}
	
	public function get_estado()
	{
		$objCidade = new BrasilCidade($this->id_cidade);
		return $objCidade->id_estado; 
	}
	
	
		
}

?>