<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/twitter/twitteroauth/twitteroauth.php');

$consumer_key = 'QZjctzxhmeaNcp0QcnKtmQ';
$consumer_secret = 'Zib1sGqCdTUC6rSXDCmKKESNkLLvIHHq8a7zvOZdIpA';
$oauth_token = '249136538-1K6QhpGfPWFSmEGvAyhTGRsXagB62zZdZTQi4tzs';
$oauth_token_secret = 'GqvmDTXlofPeAgIaJjPQ61ETXBUC54cfeEFsfP8M';

$connection = new TwitterOAuth(
    $consumer_key,
    $consumer_secret,
    $oauth_token,
    $oauth_token_secret
);


function encurtar_url($url){
    $url = trim($url);
    $url = urlencode($url);
    $cURL = curl_init('http://migre.me/api.txt?url='.$url);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
    $resultado = curl_exec($cURL);
    curl_close($cURL);
    return $resultado;
}

function cortaTexto($texto){
    if(strlen($texto) >= 106){
        $texto  = substr(utf8_encode($texto),0,106).'...';
        return $texto;
    }else{
        return utf8_encode($texto);
    }
}


//OBTENDO INFO DO USUARIO
//$result = $connection->get( 'account/verify_credentials',  array());

//OBTENDO TWITTERS
//$result = $connection->get(  'statuses/home_timeline',array() );

//POSTANDO UM NOVO TWITTER
// $result = $connection->post(  'statuses/update',  array('status' => 'teste app2',));

//LISTA DE OPCOES http://dev.twitter.com/doc


//var_dump($result);
?>
