<?php

/**
 * 
 * Esta classe prov� os m�todos para carregar e persistir
 * objetos da base de dados (Active Record) 
 * @author Salve
 *
 */
abstract class TRecord
{
	protected $_dados; // array contendo os dados do objeto
	
	
	/**
	 * Instancia um Active Record. Se passado o ID, carrega o objeto. 
	 * @param unknown_type $id = ID do objeto na tabela do banco de dados
	 */
	public function __construct($id=null)
	{
		if($id)
		{
			// se o ID for informado, carrega o objeto correspondente
			$objeto = $this->load($id);
			if($objeto)
			{
				$this->fromArray($objeto->toArray());
			}
			else
			{
				$this->id = null;
			}
		}
	}
	
	
	
	/**
	 * Chamado automaticamente quando o objeto � clonado, limpa o ID
	 * do objeto para n�o sobrescrever (no banco) o objeto original ao persistir
	 */
	public function __clone()
	{
		$this->id = null;
	}
	
	
	/**
	 * Chamado automaticamente ao se tentar atribuir valor a uma propriedade, 
	 * verifica se existe um m�todo espec�fico para isso ou simplesmente atribui
	 * @param unknown_type $prop = nome da propriedade a ser alterada
	 * @param unknown_type $valor = valor desejado para a propriedade
	 */
	public function __set($prop, $valor)
	{
		// verifica se existe m�todo set_<propriedade>
		if(method_exists($this, 'set_' . $prop))
		{
			call_user_func(array($this, 'set_' . $prop), $valor);
		}
		elseif($valor===null)
		{
			unset($this->_dados[$prop]);
		}
		else
		{
			$this->_dados[$prop] = $valor;
		}
	}
	
	
	/**
	 * Chamado automaticamente ao se tentar obter o valor de uma propriedade,
	 * verifica se existe um m�todo espec�fico para isso ou simplesmente retorna
	 * @param unknown_type $prop = nome da propriedade a ser retornada
	 */
	public function __get($prop)
	{
		// verifica se existe m�todo get_<propriedade>
		if(method_exists($this, 'get_' . $prop))
		{
			// executa o m�todo espec�fico que retorna o valor da propriedade
			return call_user_func(array($this, 'get_' . $prop));
		}
		else
		{
			// retorna o valor da propriedade
			if(isset($this->_dados[$prop]))
			{
				return $this->_dados[$prop];
			}
		}
	}
	
	
	/**
	 * Retorna o nome da entidade (tabela), que � �nica para a classe
	 */
	private function getEntity()
	{
		// obt�m o nome da classe
		$classe = get_class($this);
		// retorna a constante de classe TABLENAME
		return constant("{$classe}::TABLENAME");
	}
	
	
	/**
	 * Preenche os dados do objeto com o Array passado
	 * @param unknown_type $dados = array com os dados
	 */
	public function fromArray($dados)
	{
		$this->_dados = $dados;
	}
	
	
	/**
	 * Retorna os dados do objeto em forma de Array 
	 */
	public function toArray()
	{
		return $this->_dados; 
	}

	
	/**
	 * Armazena o objeto no banco de dados e retorna o n�mero de linhas afetado pela instru��o
	 */
	public function store()
	{
		if(empty($this->_dados['id']) || (!$this->load($this->id)) )
		{
			// cria uma instru��o de INSERT
			$sql = new TSqlInsert();
			$sql->setEntity($this->getEntity());
			foreach ($this->_dados as $chave=>$valor)
			{
				//x e y sao passados no POST pela funcao fromArray 
				if($chave!=='id' && $chave!=='y' && $chave!=='x'  ) // o ID n�o precisa ir para o banco (usar AUTO-INCREMENT)
				{
					$sql->setRowData($chave, $this->$chave);
				}
			}
		}
		else
		{
			// se j� tem ID, atualiza o registro (UPDATE)
			$sql= new TSqlUpdate();
			$sql->setEntity($this->getEntity());
			$criterio = new TCriteria();
			$criterio->add(new TFilter('id', '=', $this->id));
			$sql->setCriteria($criterio);
			foreach ($this->_dados as $chave=>$valor)
			{
				//x e y sao passados no POST pela funcao fromArray 
				if($chave!=='id' && $chave!=='y' && $chave!=='x' ) // o ID n�o precisa ser atualizado
				{
					$sql->setRowData($chave, $this->$chave);
				}
			}
		}
		
		
		// ARMAZENA
		// TODO: transa��o (se julgar necess�rio)
		$conn = TConnection::open();
		//echo $sql->getSQL(); 
		$conn->exec($sql->getSQL());
		if(empty($this->_dados['id']))
		{
			// se for opera��o de INSERT, atribui o ID inserido no banco ao objeto 
			$this->_dados['id'] = $conn->lastInsertId();
		}
		$conn = null;
		
		return $this->_dados['id'];
		
	}
	
	
	/**
	 * Recupera e retorna um objeto do banco de dados de acordo com o ID passado
	 * @param unknown_type $id = ID do registro no banco de dados
	 */
	public function load($id)
	{
		$sql = new TSqlSelect();
		$sql->setEntity($this->getEntity());
		$sql->addColumn('*');
		$criterio = new TCriteria();
		$criterio->add(new TFilter('id', '=', $id));
		$sql->setCriteria($criterio);
		
		
		// CONSULTA E RETORNA
		// TODO: transa��o (se julgar necess�rio)
		$conn = TConnection::open(); 
		$result = $conn->query($sql->getSQL());
		$objeto = $result->fetchObject(get_class($this));
		$conn = null;
		
		return $objeto;
	}
	
	
	
	/**
	 * Exclui um objeto no banco de dados de acordo com o ID passado 
	 * @param unknown_type $id = ID do registro no banco de dados
	 */
	public function delete($id=null)
	{
		// se n�o for passado ID do banco, usa a propriedade 'id' do objeto, 
		// pois este j� foi instanciado
		$id = $id ? $id : $this->id;
		
		$sql = new TSqlDelete();
		$sql->setEntity($this->getEntity());
		$criterio = new TCriteria();
		$criterio->add(new TFilter('id', '=', $id));
		$sql->setCriteria($criterio);
		//echo $sql->getSQL();
		
		
		// EXCLUI
		// TODO: transa��o (se julgar necess�rio)
		$conn = TConnection::open(); 
		$result = $conn->exec($sql->getSQL());
		$conn = null;
		
		return $result;
	}
	
	
	/**
	 * Conta o n�mero de registros dessa classe no banco
	 * @param TCriteria $criterio
	 */
	public static function count(TCriteria $criterio=null)
	{
		$repositorio = new TRepository(get_called_class());
		return $repositorio->count($criterio);
	}
	
	
	
	/**
	 * Retorna um vetor com todas as tags desta classe
	 * @param int $limite limite de tags retornadas
	 */
	public static function get_all_tags($filtrar_visiveis=true, $limite=null)
	{
		$sql = new TSqlSelect();
		$sql->addColumn('tags');
		$sql->setEntity(constant(get_called_class() .'::TABLENAME'));
		$criterio = new TCriteria();
		if($filtrar_visiveis)
		{
			$criterio->add(new TFilter('bool_exibir', '=', 1));
			$sql->setCriteria($criterio);
		}
		$sql->getSQL();
		$conn = TConnection::open();
		$resultado = $conn->query($sql->getSQL());
		
		
		if($resultado)
		{
			while($row = $resultado->fetch(PDO::FETCH_ASSOC))
			{
				$vetor_tags = explode(' ', $row['tags']);
				foreach ($vetor_tags as $chave=>$tag)
				{
					$vetor[] = $tag;
				}
			}
			
			if($vetor)
			{
				// ordenando o vetor para retirar as tags repetidas
				sort($vetor);
				$i_max = $limite ? $limite+1 : sizeof($vetor); 
				for($i=0; $i<$i_max; $i++)
				{
					if($vetor[$i]!=$vetor[$i-1] && $vetor[$i]!='')
					{
						$retorno[] = $vetor[$i];
					}
				}
			}
		}
		
		return $retorno;		
	}
		

	/**
	 * 
	 * Retorna o n�mero de itens com a tag desejada
	 * @param string $tag tag desejada
	 */
	public static function conta_itens_tag($tag, $filtrar_visiveis=true)
	{
		$where_visiveis = $filtrar_visiveis ? 'AND bool_exibir=1' : '';
		$sql = 'SELECT COUNT(*) as quantidade FROM ' . constant(get_called_class() .'::TABLENAME') . ' WHERE tags LIKE "%' . $tag . '%" ' . $where_visiveis;
			
		$conn = TConnection::open();
		$result = $conn->query($sql);
		$conn = null;
		
		if($result)
		{
			$row = $result->fetch();
		}
		
		return $row[0];
	}
	

	
	/**
	 * retorna um array com as tags do item
	 * @param int $id ID da not�cia no banco
	 */
	public function lista_tags($id=null)
	{
		$classe = get_called_class();
		$item = $id ? new $classe($id) : $this;
		if($item->tags!='')
		{
			return explode(' ', $item->tags);
		}
	}
	
}


?>