<?
define('FACEBOOK_APP_ID', '148880485179470');
define('FACEBOOK_SECRET', '225e0a7c659d9492d719de3506811f8c');

//é so copiar essa funcao, nao pergunta mto! ;)
function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $application_secret) != $args['sig']) {
    return null;
  }
  return $args;
}


$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
var_dump($cookie);

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <?php if ($cookie) { ?>

      <fb:profile-pic uid='loggedinuser' facebook-logo='true'></fb:profile-pic>
      Bem-vindo, <fb:name uid='loggedinuser' useyou='true'></fb:name>. Você esta  conectado  sua conta do facebook."
      <fb:like layout="button_count"></fb:like> <!-- botao de gostei-->
    <?php } else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>

    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true,cookie: true, xfbml: true});

      FB.Event.subscribe('auth.login', function(response) {
          FB.XFBML.Host.parseDomTree();
        window.location.reload();
      });
      
      //facebook_publish_feed_story();

      function facebook_publish_feed_story() {
		  alert('foi');
            var message = "Esta mensagem vai aparecer na caixa de dialogo";
            var attachment = {
                'name':'Atualizando',
                'description':'Estou descrevendo a minha mensagem que pod ser um pedaço de um post...',
                'href':'http://www.leandrogarcia.com/blog/'
                };

            var actionLinks = [
                { "text": "Acompanhe também:",
                    "href": "http://www.leandrogarcia.com/blog"
                }
            ];
            console.log(FB.Connect.streamPublish(message, attachment,actionLinks));
        }
    </script>
  </body>
</html>