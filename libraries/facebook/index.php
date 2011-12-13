<?php

require 'facebook-php-sdk-04168d5/src/facebook.php';

//ESSAS INFO É OBTIDO QDO CADASTRA SEU APP NO FACEBOOK
$facebook = new Facebook(array(
  'appId'  => '08fa7f2e64b7d8a0779ab40ba1bed7ad',//095444a483a4ae29120ecd50c2c90c90
  'secret' => '5a68613c07fb73b39f4a11a82119b83c',
  'cookie' => true,
));
Facebook::$CURL_OPTS[CURLOPT_CAINFO] = $_SERVER['DOCUMENT_ROOT']. '/testes/facebook/novo/facebook-php-sdk-04168d5/src/fb_ca_chain_bundle.crt';
//PARA OBTER UMA SESSÃO OU SEJA APARTIR DO LOGIN DO USUARIO
$session = $facebook->getSession();


if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me'); //PEGANDO AS INFO BASICAS DO USER
    echo "<pre>";
	    print_r($me);
    echo "</pre>";

  } catch (FacebookApiException $e) {
	echo "<pre>";
	    print_r($e);
	echo "</pre>";
  }
}


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
            }, {perms:'publish_stream'});
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
