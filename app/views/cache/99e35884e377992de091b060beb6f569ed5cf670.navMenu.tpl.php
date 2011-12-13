<?php /*%%SmartyHeaderCode:34504ddd588e49c229-38701547%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99e35884e377992de091b060beb6f569ed5cf670' => 
    array (
      0 => 'app/views/templates\\navMenu.tpl',
      1 => 1306351756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34504ddd588e49c229-38701547',
  'has_nocache_code' => false,
  'cache_lifetime' => 30,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><html>
    <head>
	<title>Teste menu</title>
	<link rel="stylesheet" href="http://localhost/MeusProjetos/MVC//layout/css/menu.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="http://localhost/MeusProjetos/MVC//layout/css/base.css" type="text/css" media="screen" />
    </head>
    <body>
	<ul class="navMenu">
	    <li><a href="">Seja um cooperado</a></li>
	    <li><a href="">Economize</a></li>
	    <li><a href="">Conheça</a>
		<ul class="navSubMenu">
		    <li><a href="">Marcas Próprias</a></li>
		    <li><a href="">Ofertas</a></li>
		    <li><a href="">Promoções</a></li>
		    <li><a href="">Drogarias coop</a></li>
		    <li>Cartão coop  fácil</li>
		    <li>Serviços da coop</li>
		    <li>Formas de pagamento</li>
		    <li>Conveniados</li>
		</ul>
	    </li>
	    <li><a href="">Participe</a></li>
	    <li> <a href="">Crie</a></li>
	    <li>Mexa-se</li>
	</ul>
    </body>
</html><?php } ?>