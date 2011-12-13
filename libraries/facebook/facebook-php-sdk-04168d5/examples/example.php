<?php

require '../src/facebook.php';

//ESSAS INFO É OBTIDO QDO CADASTRA SEU APP NO FACEBOOK
$facebook = new Facebook(array(
  'appId'  => '100548786692097',
  'secret' => 'd9424e047612b320304c355210860346',
  'cookie' => true,
));


//FORMATO PARA POSTAR NO MURAL
$attachment = array('message' => 'this is my message',
                'name' => 'This is my demo Facebook application!',
                'caption' => "Caption of the Post",
                'link' => 'http://mylink.com',
                'description' => 'this is a description',
                'picture' => 'http://mysite.com/pic.gif',
                'actions' => array(array('name' => 'Get Search',
                                  'link' => 'http://www.google.com'))
                );


////FORMATO DE NOVO EVENTO
$event_info = array(
	'eid' => '124966694244784',
	'name' => 'teste 5',
	'description' => 'hoje é sexta dia de encher a cara',
	'start_time' => gmmktime(22,0,0,9,8,2011),
	'end_time' => gmmktime(22,0,0,9,12,2011),
	'location' => 'no bar da esquina',
	'privacy' => 'OPEN'
);

//REST API
$info = array("name"=>"lame","category"=>"Party","subcategory"=>"Night of Mayhem","location"=>"Toronto","start_time"=>$start,"end_time"=>$end);



$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me'); //PEGANDO AS INFO BASICAS DO USER
	//$result = $facebook->api('/me/feed/','post',$attachment); //POSTANDO NO MURAL
	//$result = $facebook->api('/me/feed/'); //LISTANDO MEUS POSTS DO MURAL

	//$result = $facebook->api('/me/events/','post',$event_info); //CRIANDO EVENTOS
	//$result = $facebook->api('/me/events/'); //CRIANDO EVENTOS
	//$result = $facebook->api('/177167822332188/invited/'); //LISTANDO CONVIDADOS


	//$friends = $facebook->api('/me/friends/'); //LISTANDO AMIGOS


  } catch (FacebookApiException $e) {
    error_log($e);
  }
}


//OBTENDO A URL PRA LOGAR E PRA FAZZER LOGOUT,
//NÃO TO USANDO PREFERÍ FAZER VIA JAVASCRIPT
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// PEGANDO AS INFO BASICAS DE UM USUARIO QUALQUER
$naitik = $facebook->api('/naitik');

    


?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <!--
      We use the JS SDK to provide a richer user experience. For more info,
      look here: http://github.com/facebook/connect-js
    -->
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
		alert('sair')
          FB.logout(function () {
			window.location.reload(); });
		redir();
	}
	function fblogin() {
		alert('chamou')
		FB.login(function(response) {
              //...
            }, {perms:'email,read_stream,user_photos,user_videos,user_birthday,offline_access,publish_stream,status_update,user_events,create_event,rsvp_event,friends_events'});
		//redir();
      }

    </script>


    <h1><a href="example.php">php-sdk</a></h1>

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

    <h3>Session</h3>
    <?php if ($me): ?>
    <pre><?php print_r($session); ?></pre>

    <h3>You</h3>
    <img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
    <?php echo $me['name']; ?>

    <h3>Your User Object</h3>

    <pre><?php print_r($result); ?></pre>

    <?php else: ?>
    <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php echo $naitik['name']; ?>
  </body>
</html>
