<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Preguntas - Encuesta</title>
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
				<div class="indications questions">
					 
					<p><span>6</span>¿El personal técnico le saludo al llegar, fueron amables durante la atención  y se despidieron adecuadamente?</p>

					<ul>
						<li class="l0"><a href="">0</a></li>
						<li class="l1"><a href="">1</a></li>
						<li class="l2"><a href="">2</a></li>
						<li class="l3"><a href="">3</a></li>
						<li class="l4"><a href="">4</a></li>
						<li class="l5"><a href="">5</a></li>
						<li class="l6"><a href="">6</a></li>
						<li class="l7"><a href="">7</a></li>
						<li class="l8"><a href="">8</a></li>
						<li class="l9"><a href="">9</a></li>
					</ul>
					<div class="cont-btn final-p">
						<input type="button" value="FINALIZAR" onclick="window.location='<?=base_url()?>index.php/encuestas/gracias';">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
