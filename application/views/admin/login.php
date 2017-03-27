<?php

defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" class="pannel-toolbar">
<head>
	<meta charset="utf-8">
	<title>ATENCIÓN TÉCNICA CLARO</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/style.css">
	<link rel="stylesheet" href="<?=base_url()?>css/font-awesome.min.css">
	<script src="<?=base_url()?>encuesta/js/jquery-1.9.1.min.js"></script>

	<script type="text/javascript">
		
	$(document).on('ready', function(){    

  		$("[name='session_value']").focus();
  });

	</script>
</head>
<body>

	<div id="container">
		<header>
			<div class="header-inner">
				<h1 style="float: left;">Bienvenidos al Administrador</h1>
			</div>
		</header>
		<div class="right-list-admin">

		</div>
		<div class="right-content">	
			<div class="list-mod-panel">
				<form class="btnf" method="POST" action="<?=base_url()?>index.php/admin/set_session">
					<?=(@$inactivo)?'<b class="useri">Usuario Inactivo</b><br>':''?>
					<br>
					Nombre de Usuario
					<br>
					<br>
					<input type="text" maxlength="20" name="session_value"/>
					<br>
					Contraseña
					<br>
					<br>
					<input type="password" maxlength="20" name="session_pass"/>
					<br><br>
					<input class="btnsearch" type="submit" value="Entrar">
					<?=(@$error)?'<br><br><b class="useri">Datos Incorrectos</b>':''?>
					<hr>
					<b><a href="<?=base_url()?>index.php/admin/olvidoclave">¿Olvidó su Contraseña?</a></b>
				</form>
			</div>
		</div>
	</div>

</body>
</html>