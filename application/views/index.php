<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login..holaaaaa...!! a todos peru </title>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>encuesta/css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

		<script src="<?=base_url()?>encuesta/js/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>encuesta/js/jquery-ui.js" type="text/javascript"></script>
		<script src="<?=base_url()?>encuesta/js/ui-front.js" type="text/javascript"></script>

	</head>

	<body>
		<div class="wrapper">
			<header><a href="<?=base_url()?>"><img src="<?=base_url()?>encuesta/img/logo.png"/></a></header>
			<div class="body_w">
				<div class="cont-login">
					<form action="<?=base_url()?>index.php/welcome" method="get">
						<input class="input_f" name="dni" type="text" title="Sólo 8 Dígitos" required pattern=".{8}" value="DNI">
						<input class="btn-active" type="submit" value="INGRESAR">
						<?=(@$error)?'DNI INCORRECTO':''?>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>