<?php

class Mvc{
	private $url;
	private $explode;
	public $controller;
	public $action;
	public static  $params;

	public function  __construct()
	{
		 $this->setUrl();
		 $this->setExplode();
		 $this->setController();
		 $this->setAction();
		 $this->setParams();
	}

	private function setUrl()
	{
		$_GET['url']	= isset($_GET['url']) ? $_GET['url'] : 'index/index';
		$this->url		= $_GET['url'];
	}

	private function setExplode()
	{
		$this->explode = explode('/',$this->url);
	}

	private function setController()
	{
		//$this->controller = $this->explode[0].'Controller';
                $this->controller = str_replace('-', '_', $this->explode[0]) . '_controller';
	}

	private function setAction()
	{
		$act = (!isset($this->explode[1]) || $this->explode[1] == null || $this->explode[1] == 'index') ? 'index_action' : $this->explode[1].'_action';
		$this->action = $act;
	}

	private function setParams()
	{
		unset($this->explode[0],$this->explode[1]);

		if(end($this->explode) == null){
			array_pop($this->explode);
		}
		$i=0;
		self::$params = $this->explode;
	}

	/**
	 * Essa função espera que na url seja passada as variaveis como 'chave/valor'
	 * por enquanto isso ta descartado, preferimos a sequencia de valores 'valor/valor/valor..'
	 */
	private function setParams_1()
	{
		unset($this->explode[0],$this->explode[1]);

		if(end($this->explode) == null){
			array_pop($this->explode);
		}
		$i=0;
		if(!empty ($this->explode)){
			 foreach ($this->explode as $val){
				 if($i % 2 == 0){
					 $ind[] = $val;
				 }  else {
					 $value[]=$val;
				 }
				 $i++;
			 }
		}else{
			$ind = array();
			$value = array();
		}

		if(count($ind) == count($value) && !empty ($value) && !empty ($value)){
			self::$params = array_combine($ind, $value);
		}else{
			self::$params = array();
		}
	}


	public static function getParams()
	{
		return self::$params;
		//return self::$params[$name];
	}

	public function run()
	{
		$controller_path =  CONTROLLERS . $this->controller.'.class.php';
		
		if(!file_exists($controller_path))
		{
			die('Houve um erro. O controler não existe');
		}
		else
		{
			$app = new $this->controller();
			$action = $this->action;
			if(!method_exists($app, $action)){
				$app->noAction();
			}  else {
                                $app->init();
				$app->$action();
			}
		}
	}


}