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
			if ( $("#search").val() ) {
				event.preventDefault();
				$.ajax({
					url:'validateEmail',
					type:'post',
					//dataType:'json',
					data:$(".btnf").serializeArray()
				}).done(function(respuesta){
					alert(respuesta);
					$("#search").val('');
				});
			}
			else
				alert('¡Coloca Tu Correo!');
		});
	});
	</script>
</head>
<body111111111111>
	<div id="container">
		<header>
			<div class="header-inner">
				<h1 style="float: left;">Bienvenidos al Administrador</h1>
			</div>
		</header>
		<div class="right-list-admin"></div>
		<div class="right-content">	
			<div class="list-mod-panel">
				<form class="btnf" method="POST">
					<p> Por favor, escribe tu correo electrónico. Recibirás un enlace para crear la contraseña nueva por correo electrónico </p>
					<br>
					Correo Electrónico
					<br>
					<br>
					<input type="text" size="40" maxlength="40" id="search" name="search"/>
					<br><br>
					<input class="btnsearch" type="submit" value="Contraseña Nueva">
					<hr>
					<b><a href="<?=base_url()?>index.php/admin">INGRESAR</a></b>
				</form>
			</div>
		</div>
	</div>
</body>
</html>