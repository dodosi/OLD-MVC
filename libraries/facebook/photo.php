<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');
//ini_set('display_startup_errors', 'On');

require 'facebook-php-sdk-04168d5/src/facebook.php';

//ESSAS INFO É OBTIDO QDO CADASTRA SEU APP NO FACEBOOK
$facebook = new Facebook(array(
  'appId'  => '148880485179470',//095444a483a4ae29120ecd50c2c90c90
  'secret' => '225e0a7c659d9492d719de3506811f8c',
  'cookie' => true,
));

//QUANDO SERVIDOR WINDOWS ADICIONE ESSA LINHA, POIS DA PROBLEMA NA HORA DE LER O CERTIFICADO
//Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
Facebook::$CURL_OPTS[CURLOPT_CAINFO] = $_SERVER['DOCUMENT_ROOT']. '/testes/facebook/novo/facebook-php-sdk-04168d5/src/fb_ca_chain_bundle.crt';

//PARA OBTER UMA SESSÃO OU SEJA APARTIR DO LOGIN DO USUARIO
$session = $facebook->getSession();


//$facebook->setSession($session);
$facebook->setFileUploadSupport(true);
$me = null;





//CRIANDO ALBUMS
$info_album = array(
            'name' => 'album teste',
            'message' => 'testando  api ',
            'location' => 'testando  api ',
);



//INFO DE UPLOAD FOTOS
$info_foto= array(
            'name' => 'minhas fotos via app',
            'link' => 'http://apssouza.com.br',
	    'tags' => array(array("x" => "30","y" => "30","tag_uid" =>761583709)),
	    'access_token' => $session['access_token'],
);

$file_path = 't2_arquivo_20100915154513.png';
$info_foto['source']= '@'.  realpath($file_path);


// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me'); //PEGANDO AS INFO BASICAS DO USER

    //ALBUM
    $album = $facebook->api('/me/albums/','post',$info_album); //CRIANDO ALBUM
    $albums = $facebook->api('/me/albums/'); //LISTANDO
    echo "<pre>";
    print_r($albums);
    echo "</pre>";


    //FOTOS
    $fotos = $facebook->api('/'.$album['id'].'/photos','post',$info_foto); //POSTANDO FOTO NO ALBUM
    echo "<pre>";
    print_r($fotos);
    echo "</pre>";
    //$fotos = $facebook->api('/'.$album['data'][0]['id'].'/photos'); //LISTANDO FOTOS
    $fotos = $facebook->api('/182496651798773/photos'); //LISTANDO FOTOS
    echo "<pre>";
    print_r($fotos);
    echo "</pre>";
    ///$deletado = $facebook->api('/182496665132105/','DELETE'); //EXCLUINDO

   

    $post = $facebook->api('/me/feed/','post',$attachment); //POSTANDO NO MURAL
    //$feed = $facebook->api('/me/feed/'); //LISTANDO MEUS POSTS DO MURAL
    //$fotos = $facebook->api('/100001153185823_182721285109643','DELETE'); //DELETANDO FEED
    //$friends = $facebook->api('/me/friends/'); //LISTANDO AMIGOS
    //
    //EVENTOS
    //$evento   = $facebook->api('/me/events/','post',$event_info); //CRIANDO EVENTOS
    //$evento  = $facebook->api('/167163000008597/', 'post', $event_info); //EDITANDO EVENTOS
    $evento   = $facebook->api('/me/events/'); //LISTANDO EVENTOS
   // $evento   = $facebook->api($event_info); //CANCELANDO EVENTO    
    //$condida= $facebook->api($info_condidados);//CONVIDANDO USUARIOS PARA O EVENTO

   // $convidados = $facebook->api("/167163000008597/invited/"); //LISTANDO CONVIDADOS

  } catch (FacebookApiException $e) {
      echo "<pre>";
    print_r($e);
    echo "</pre>";
  }
}

echo "<pre>";
echo "sessao";
    print_r($me);
    //print_r($album);
echo "</pre>";

//OBTENDO A URL PRA LOGAR E PRA FAZZER LOGOUT,
//NÃO TO USANDO PREFERÍ FAZER VIA JAVASCRIPT
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array(
	'req_perms'=>'user_photos,publish_stream,offline_access',
	'canvas' => 1,
  ));
}

// PEGANDO AS INFO BASICAS DE UM USUARIO QUALQUER
$naitik = $facebook->api('/527093683/picture');

     print_r($naitik );


?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
  </head>
  <body>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());


	function fblogout() {
          FB.logout(function () {
			window.location.reload(); });
		redir();
	}
	function fblogin() {
	    alert('chamou');
		FB.login(function(response) {
              //...
            }, {perms:'email,read_stream,user_photos,user_videos,user_birthday,offline_access,publish_stream,status_update,user_events,create_event,rsvp_event,friends_events'});
		//redir();
      }
//fblogin();
    </script>

    <?php if ($me): ?>
    <a onclick="fblogout();return false;"  href="<?php echo $logoutUrl; ?>">
      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
    </a>
    <?php else: ?>
    <div>
      Using JavaScript &amp; XFBML: <fb:login-button></fb:login-button>
    </div>
    <div>
      Without using JavaScript &amp; XFBML:
      <a onclick="fblogin();return false;" href="<?php echo $loginUrl; ?>">
        <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
      </a>
    </div>
    <?php endif ?>
  </body>
</html>
