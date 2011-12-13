<?php

    function __autoload($classe){
        require 'classes/'.$classe.'.class.php';
    }


    try {

        $cache = new Cache(1);
        if($cache->isCache('feed')){
            $cache->write('feed', 'Data e Hora ' . date('H:i:s'));
        }
        echo $cache->read('feed');

    }catch (CacheException $e){
        echo $e->getMessage();
    }
