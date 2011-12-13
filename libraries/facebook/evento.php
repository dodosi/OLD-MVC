<?php

require 'facebook-php-sdk-04168d5/src/facebook.php';

//ESSAS INFO É OBTIDO QDO CADASTRA SEU APP NO FACEBOOK
$facebook = new Facebook(array(
  'appId'  => '148880485179470',//095444a483a4ae29120ecd50c2c90c90
  'secret' => '225e0a7c659d9492d719de3506811f8c',
  'cookie' => true,
));

//PARA OBTER UMA SESSÃO OU SEJA APARTIR DO LOGIN DO USUARIO
$session = $facebook->getSession();
var_dump($session);
exit();

//$facebook->setSession($session);
$facebook->setFileUploadSupport(true);
$me = null;

if($_POST){
    list($dia,$mes,$ano) = explode('/',$_POST['data']);
$hora = '5';
$min = '35';
    $event_info = array(
	    'name' => $_POST['nome'],
	    'description' => $_POST['desc'],
	    'start_time' => gmmktime($hora,$min,10,$mes,$dia,$ano),
	    'end_time' => gmmktime(8,$min,10,$mes,$dia,$ano),
	    'location' => $_POST['local'],
	    'privacy' => 'OPEN',
    );

    $convidados = $_POST['user'];
 
}

//ADICIONANDO IMAGEM AO EVENTO
$file_path = 't2_arquivo_20100915154513.png';
$event_info[basename($file_path)] = '@'.  realpath($file_path);

//CANCELANDO EVENTO
//$event_info = array(
//        'method' => 'events.cancel',
//        'eid' => '218970171452258',
//        'cancel_message' => ' desculpa galera fui assaltado to duro'
//);

//CONVIDANDO USUARIOS
$info_condidados = array(
            'method'  => 'events.invite',
            //'eid' => $evento['id'],
            'eid' => '167163000008597',
            'uids' => array('100001839830965', '100000832392960'),
            'personal_message' => 'Ola Participe',
            'access_token' => $session['access_token'],
    );

if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me'); //PEGANDO AS INFO BASICAS DO USER

    //EVENTOS
    if($_POST){
	$eventocriado   = $facebook->api('/me/events/','post',$event_info); //CRIANDO EVENTOS
	print_r($eventocriado);
	$condida= $facebook->api(array(
		'method'  => 'events.invite',
		'eid' => $eventocriado['id'],
		'uids' => $convidados,
		'personal_message' => 'Ola Participe',
		'access_token' => $session['access_token'],
	));//CONVIDANDO USUARIOS PARA O EVENTO
	$convidados = $facebook->api("/".$eventocriado['id']."/invited/"); //LISTANDO CONVIDADOS
    }
    //$evento  = $facebook->api('/167163000008597/', 'post', $event_info); //EDITANDO EVENTOS
    $eventos   = $facebook->api('/me/events/'); //LISTANDO EVENTOS
    $amigos	= $facebook->api('/me/friends/'); //LISTANDO
   // $evento   = $facebook->api($event_info); //CANCELANDO EVENTO    
    
    

  } catch (FacebookApiException $e) {
	echo "<pre>";
	    print_r($e);
	echo "</pre>";
  }
}

echo "<pre>";
    print_r($evento);
echo "</pre>";

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>Eventos</title>
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
		FB.login(function(response) {
              //...
            }, {perms:'publish_stream,status_update,user_events,create_event,rsvp_event,friends_events'});
		//redir();
      }
    </script>

    

    <?php if ($me){ ?>

    <div style="display: block; height: 199px;width: 400px;">
	Novo Evento<br>
	<form name="evento" method="POST" action="">
	    <ul style="list-style: none;">
		<li><span>Nome:</span> <input type="text" name="nome"></li>
		<li><span>Data:</span> <input type="text" name="data"></li>
		<li><span>Local: </span><input type="text" name="local"></li>
		<li><span>Descricao:</span> <input type="text" name="desc"></li>
		<li><input type="submit" name="desc" value="salvar"></li>
	    </ul>

    </div>

    <div style="    float: left; width: 300px;">

	Seus Eventos:<br><br>
	
	<?php
	    foreach ($eventos['data'] as $evento) {
		echo "<ul>";
		foreach ($evento as $key => $value) {?>

		    <li><?php echo $key . ' = ' . $value ?></li>
    <?php
    
		}
	    echo "</ul>";
	} ?>
	
    </div>

    <div style="    float: left; width: 300px;">

	Seus Convidados:<br><br>

	<?php
	    foreach ($convidados['data'] as $convidado) {
		echo "<ul>";
		foreach ($convidado as $key => $value) {?>

		    <li><?php echo $key . ' = ' . $value ?></li>
    <?php
		}
	    echo "</ul>";
	} ?>

    </div>

    <div style="    float: left; width: 300px;">

	Seus Amigos:<br><br>

	<?php
	    foreach ($amigos['data'] as $amigo) {
		echo "<ul>";
		echo "<li><input type='checkbox' name='user[]' value='".$amigo['id']."'></li>";
		echo "<li><img src='http://graph.facebook.com/".$amigo['id']."/picture?type=small' ></li>";
		foreach ($amigo as $key => $value) {?>

		    <li><?php echo $key . ' = ' . $value ?></li>
    <?php
		}
	    echo "</ul>";
	} ?>

    </div>

    <?php } ?>

</form>



    <?php if ($me): ?>
	<a onclick="fblogout();return false;"  href="<?php echo $logoutUrl; ?>">
	  <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
	</a>
    <?php else: ?>
	<div>
	  Faça o login:
	  <a onclick="fblogin();return false;" href="<?php echo $loginUrl; ?>">
	    <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
	  </a>
	</div>
    <?php endif ?>

  </body>
</html>
