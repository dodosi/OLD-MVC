<?php /* Smarty version Smarty-3.0.6, created on 2011-12-13 16:19:19
         compiled from "app/views/templates/navMenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11810500464ee79727379f79-13632917%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '671d2db02ae6e775ba11b57ebc9ccfb0fd0cfb66' => 
    array (
      0 => 'app/views/templates/navMenu.tpl',
      1 => 1323787816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11810500464ee79727379f79-13632917',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
    <head>
	<title>Teste menu</title>
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('DIR_HTM_ROOT')->value;?>
/layout/css/menu.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('DIR_HTM_ROOT')->value;?>
/layout/css/base.css" type="text/css" media="screen" />
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
</html>