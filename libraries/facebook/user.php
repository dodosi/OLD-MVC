<?php

require 'facebook-php-sdk-04168d5/src/facebook.php';

//ESSAS INFO É OBTIDO QDO CADASTRA SEU APP NO FACEBOOK
$facebook = new Facebook(array(
  'appId'  => '148880485179470',//095444a483a4ae29120ecd50c2c90c90
  'secret' => '225e0a7c659d9492d719de3506811f8c',
  'cookie' => true,
));
//$session = $facebook->getSession();
$uid = $facebook->getUser();
var_dump($uid);
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
	    alert('chamou');
		FB.login(function(response) {
              //...
            }, {perms:''});
		//redir();
      }
      
    </script>
    <fb:name uid='loggedinuser' useyou='false'></fb:name>
    

    
  </body>
</html>
