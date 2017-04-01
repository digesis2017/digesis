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
	<script>
	$(document).ready(function() {
		$(".btnf").submit(function(event) {
			if ( $("#pass").val() && $("#re_pass").val() ) {
				if ( $("#pass").val() == $("#re_pass").val() ) {
					alert('Contraseña Modificada, inicie sesión');
					return;
				}
				else {
					event.preventDefault();
					alert('Las Contraseñas No coinciden');
				}
			}
			else {
				event.preventDefault();
				alert('No deje espacios en blanco');
			}
		});
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
				<form class="btnf" method="POST" action="<?=base_url()?>index.php/admin/updateContrasena">
					<br>
					Nueva Contraseña
					<br>
					<br>
					<input type="password" maxlength="20" name="pass" id="pass"/>
					<input type="hidden" name="userid" value="<?=$userid?>"/>
					<br>
					Confirmar Nueva Contraseña
					<br>
					<br>
					<input type="password" maxlength="20" id="re_pass"/>
					<br><br>
					<p> Tu contraseña debe tener al menos siete caracteres. Para que tu contraseña sea segura, usa mayúsculas, minúsculas, números y símbolos </p>
					<br>
					<input class="btnsearch" type="submit" value="Restaurar Contraseña">
					<hr>
					<b><a href="<?=base_url()?>index.php/admin">INGRESAR</a></b>
				</form>
			</div>
		</div>
	</div>

</body>
</html>