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
		{$cache}
		<h2>
        teste<br>
		usando template do smarty é agora vai çaça<br>

		<a href="ajax.php">ajax</a>
		
		</h2>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script src="{$DIR_HTM_ROOT}/layout/js/utils.js"></script>

		<script>
			{literal}
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
		{/literal}
		</script>
    </body>
</html>
