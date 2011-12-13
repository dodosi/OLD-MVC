<?php /* Smarty version Smarty-3.0.6, created on 2011-05-31 13:42:55
         compiled from "app/views/templates\htm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:73714de4f05f5a2015-74906329%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65ad47e4aedf087daa835fd2593872475560c5c5' => 
    array (
      0 => 'app/views/templates\\htm.tpl',
      1 => 1306849365,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '73714de4f05f5a2015-74906329',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>template teste</title>

    </head>
    <body>
		<?php echo $_smarty_tpl->getVariable('cache')->value;?>

		<h2>
        teste<br>
		usando template do smarty é agora vai çaça<br>

		<a href="ajax.php">ajax</a>
		
		</h2>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script src="<?php echo $_smarty_tpl->getVariable('DIR_HTM_ROOT')->value;?>
/layout/js/utils.js"></script>

		<script>
			
			$('a').click(function(e){
			e.preventDefault();
			var bodyContent = $.ajax({
					  url: "/MeusProjetos/MVC/ajax.php",
					  global: false,
					  type: "POST",
					  data: ({controller : 'index',action : 'index'}),
					  dataType: "html",
					  async:false,
					timeout: 10,
					  success: function(msg){
						 
					  },
					error : function(xhr, txt, error){

				   }
				}).responseText;
					$(bodyContent).appendTo('body');
			});
		
		</script>
    </body>
</html>
