<?php
	
	class Cache extends AbstractFile{
		
		protected $folder;
		protected $timeout;
		protected $ext;
		
		public function __construct($timeout=60, $folder = 'cache', $ext= 'txt'){
                    $this->timeout = $timeout;
                    $this->folder = $folder;
                    $this->ext = $ext;
		}
                
                public function getPathFileName($key){
                    return sprintf('%s/%s.%s',  $this->folder,  md5($key),  $this->ext);
                }

                public function isCache($key) {
                    $filename = $this->getPathFileName($key);
                    if(!file_exists($filename)){
                        return false;
                    }
                    $filemtime = filemtime($filename);
                    if(time() > ($filemtime + (60 * $this->timeout))){
                        return true;
                    }
                    return false;
                }

                public function  write($key, $value) {
                    $filename = $this->getPathFileName($key);
                    if(!file_put_contents($filename, $value)){
                        throw new CacheException('Erro ao salvar o arquivo', $key);
                    }
                }

                public function  read($key) {
                    $filename = $this->getPathFileName($key);
                    if(file_exists($filename)){
                        if(!$result = file_get_contents($filename)){
                            throw new CacheException('Erro ao ler o arquivo', $key);
                        }
                        return $result;
                    }
                }
	}