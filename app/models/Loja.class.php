<?php

class Loja extends Model
{
	const TABLENAME = 'loja';
	
	const TAMANHO_FOTO = 500; // --> tamanho m�ximo do arquivo, em KBytes
	const LARGURA_FOTO = 100; // --> dimens�o em pixels (redimensionamento)
	const ALTURA_FOTO = 60; // --> dimens�o em pixels (redimensionamento)
	
	const TAMANHO_LOGOTIPO = 500; // --> tamanho m�ximo do arquivo, em KBytes
	const LARGURA_LOGOTIPO = 100; // --> dimens�o em pixels (redimensionamento)
	const ALTURA_LOGOTIPO = 60; // --> dimens�o em pixels (redimensionamento)
	
	const DESTINO_FOTO = '/img/lojas/fotos/';
	const DESTINO_LOGOTIPO = '/img/lojas/logotipos/';
	

	// vari�veis que definem a busca_____________
	public static $_busca_vetor_campos = array('nome', 'url', 'endereco', 'complemento', 'bairro'); // vetor com os nomes dos campos em que ser� feita a pesquisa
	public function get_busca_vetor_campos() {return self::$_busca_vetor_campos;}
	const ROTULO = 'Loja'; // nome amig�vel da classe 
	const ROTULO_PLURAL = 'Lojas'; // nome amig�vel da classe no plural 
	const BUSCA_CAMPO_FOTO = 'arquivo_foto'; // nome do campo que retornar� a imagem (definir NULL para item sem imagem)
	const BUSCA_PREFIXO_FOTO = '/img/lojas/fotos/'; // prefixo para o thumb da imagem (definir NULL para item sem imagem)
	const BUSCA_TITULO = 'nome'; // nome do campo que retornar� o t�tulo (chamada)
	const BUSCA_QUANDO = null; // nome do campo que cont�m a data (definir NULL para item sem data)
	const BUSCA_TEXTO = 'endereco'; // nome do campo que retornar� o texto (chamada)
	const BUSCA_DESTINO = '/onde_encontrar/'; // caminho para o item, a partir da ra�z do site
	const BUSCA_DESTINO_CMS = '/lojas/detalhes_loja.php?id_loja=';   // caminho para o item, a partir da ra�z do CMS
	const BUSCA_PROPRIEDADE_ID = ''; // nome da propriedade que identifica o destino (concatenar ao $_destino)
	const BUSCA_PROPRIEDADE_ID_CMS = 'id'; // nome da propriedade que identifica o destino no CMS
	const BUSCA_MAX_ITENS = null; // quantidade m�xima de itens deste tipo que devem ser retornados (definir NULL para ilimitados)
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