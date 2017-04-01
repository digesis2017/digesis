<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gracias - Encuesta</title>
		<link href="<?=base_url()?>encuesta/css/style.css" rel="stylesheet" type="text/css">
		<script src="<?=base_url()?>encuesta/js/jquery-1.9.1.min.js"></script>
		<script src="<?=base_url()?>encuesta/js/jquery-ui.js"></script> 
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	</head>

	<body>
		<div class="wrapper">
		<header>
			 <img src="<?=base_url()?>encuesta/img/logo.png"/>
		</header>
		<div class="body_w">

			<div class="cont-login thanks">
				<h2>GRACIAS POR PARTICIPAR EN LA ENCUESTA</h2>
				<?php $url = base_url() . 'index.php/encuestas' . '?dni=' . $_GET['dni']; ?>
				<input class="btn-active" type="button" value="CERRAR ENCUESTA" onclick="window.location='<?=$url?>';">
			</div>
			 
			</div>
		</div>
		<script src="<?=base_url()?>encuesta/js/ui-front.js" type="text/javascript"></script>
	</body>
</html>