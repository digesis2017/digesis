<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Indicaciones</title>
		<link href="<?=base_url()?>encuesta/css/style.css" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<script src="<?=base_url()?>encuesta/js/jquery-1.9.1.min.js"></script>
		<script src="<?=base_url()?>encuesta/js/jquery-ui.js"></script>
		<script src="<?=base_url()?>encuesta/js/ui-front.js" type="text/javascript"></script>
	</head>

<body>
	<div class="wrapper">
		<header>
			 <img src="<?=base_url()?>encuesta/img/logo.png"/>
		</header>
		<div class="body_w">
			<div class="indications">
				<h2>INDICACIONES</h2>
				<p>Para la calificar el servicio de NPS se ha considerado las siguientes 6 preguntas
las cuales se calificaran en el rango del 0 a 9 donde 0 indica completa insatisfacción con la instalación  y 9 completa satisfacción</p>
				<p>Ejemplo:</p>
				<p><span class="number">0</span>¿Con cuanto calificarias el servicio prestado?</p>
				<div class="ui-question">
				    <ul class="question-level">
				        <li>
				            <a href="#" class="minimal">0-4</a>
				        </li>
				        <li>
				            <a href="#" class="medium">5</a>
				        </li>
				        <li>
				            <a href="#" class="maximal">6-10</a>
				        </li>
				    </ul>
				    <p class="extreme">
				        <span class="negative-level">Insatisfecho</span>
				        <span class="positive-level">Satisfecho</span>    
				    </p>
				    
				    <input type="hidden" class="answer1 answer" value=""  />
				</div>
				<div class="cont-btn">
					<?php $urli = base_url() . 'index.php/encuestas/preguntas/' . $sid . '?dni=' . $_GET['dni']; ?>
					<?php $urld = base_url() . 'index.php/encuestas?dni=' . $_GET['dni']; ?>
					<input type="button" value="INICIAR ENCUESTA" onclick="window.location='<?=$urli?>';">
					<input class="denegar" type="button" value="DENEGAR ENCUESTA" onclick="window.location='<?=$urld?>';">
				</div>
			</div>
		</div>
	</div>

</body>
</html>
