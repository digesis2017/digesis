<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Lista de Solicitudes</title>
		<link href="<?=base_url()?>encuesta/css/style.css?v=11" rel="stylesheet" type="text/css">
		<link href="<?=base_url()?>encuesta/css/jquery-ui.css" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<script src="<?=base_url()?>encuesta/js/jquery-1.9.1.min.js"></script>
		<script src="<?=base_url()?>encuesta/js/jquery-ui.js"></script>
		<script src="<?=base_url()?>encuesta/js/ui-front.js" type="text/javascript"></script>
	</head>

	<body>

	<?php 
		date_default_timezone_set('America/Lima');
	//echo $resumen_billetera?>
		<div class="ui-popup-options">
			<input type="hidden" id="evento" value="" />
			<a href="#" class="ui-popup-close"></a>
			<div class="ui-popup-options-wrapper schedule">
				<input type="hidden" id="schedule-sid" name="schedule-sid" value="empty-sid">
				<div class="calendar">
					<div class="calendar-box"><div id="datepicker1"></div></div>
				</div>
				<div class="ui-popup-options-contenido">
					<div class="datetime ui-popup-options-contenido" id="reprogramar">
						<div class="ui-popup-options-titulo"><span class="icon-titulo" href="#">SELECCIONAR</span></div>
						<ul class="ui-popup-options-list" binding="time-schedule">
							<li>
								<a class="icon-cerrar" value="1" href="#">Mañana</a>
							</li>
							<li>
								<a class="icon-cerrar" value="2" href="#">Tarde</a>
							</li>
						</ul>
					</div>

					<div class="reason">
						<div class="ui-popup-options-titulo"><span class="icon-titulo" href="#">MOTIVO REPROGRAMACION</span></div>
						<ul class="ui-popup-options-list" binding="reason-schedule">
						<?php foreach ( $mreprogramados as $key => $value) { ?>
							<li><a class="icon-cerrar" value="<?=$key?>" href="#"><?=$value?></a></li>
						<?php } ?>
						</ul>
					</div>
					<div class="cont-btn final-p">
						<input class="submit" type="button" value="GUARDAR">
						<input class="cancel" type="button" value="CANCELAR">
					</div>
				</div>
			</div>
			<div class="ui-popup-options-wrapper client">
				<div class="ui-popup-options-contenido" id="pendientes">
					<input type="hidden" id="client-sid" name="client-sid" value="empty-sid">
					<div class="ui-popup-options-titulo"><span class="icon-titulo" href="#">SELECCIONAR</span></div>
					<ul class="ui-popup-options-list">
					<?php foreach ( $mpendientes as $key => $value) { ?>
						<li><a class="icon-cerrar" value="<?=$key?>" href="#"><?=$value?></a></li>
					<?php } ?>
					</ul>
					<div class="cont-btn final-p">
						<input class="submit" type="button" value="GUARDAR">
						<input class="cancel" type="button" value="CANCELAR">
					</div>
				</div>
			</div>
		<div class="ui-popup-options-wrapper test">
			<input type="hidden" id="test-sid" name="test-sid" value="empty-sid">
			<div class="ui-popup-options-contenido" id="encuestar">
				<div class="ui-popup-options-titulo"><span class="icon-titulo" href="#">SELECCIONAR</span></div>
				<ul class="ui-popup-options-list">
					<li>
						<a class="icon-encuestar" value="iniciar" href="#">Iniciar Encuesta</a>
					</li>
					<li>
						<a class="icon-cerrar" value="denegar" href="#">Denegar Encuesta</a>
					</li>
				</ul>
				<div class="cont-btn final-p">
					<input class="submit" type="button" value="GUARDAR">
					<input class="cancel" type="button" value="CANCELAR">
				</div>
			</div>
		</div>

		<div class="ui-popup-options-wrapper reject">
			<input type="hidden" id="reject-sid" name="reject-sid" value="empty-sid">
			<div class="ui-popup-options-contenido" id="rechazar">
				<div class="ui-popup-options-titulo"><span class="icon-titulo" href="#">MOTIVO RECHAZO</span></div>
				<ul class="ui-popup-options-list">
				<?php foreach ( $mrechazados as $key => $value) { ?>
					<li><a class="icon-cerrar" value="<?=$key?>" href="#"><?=$value?></a></li>
				<?php } ?>
				</ul>
			</div>
			<div class="cont-btn final-p">
				<input class="submit" type="button" value="GUARDAR">
				<input class="cancel" type="button" value="CANCELAR">
			</div>
		</div>

		<div class="ui-popup-options-wrapper billetera">
			<input type="hidden" id="test-sid" name="test-sid" value="empty-sid">
			<div class="ui-popup-options-contenido" id="encuestar">
			<div class="ui-popup-options-titulo"><span class="icon-titulo" href="#">MONEDERO DIGITAL</span></div>
				<ul class="ui-popup-options-list">
					<li>
						<span>Comision del Dia <b>S/.<?php echo round($resumen['comision_dia'],2)?></b></span>
					</li>
					<li>
						<span>Comision del Mes <b>S/.<?php echo round($resumen['comision_mes']['monto'],2)?></b></span>
					</li>
				</ul>
				<div class="cont-btn final-p">
					<input class="submit" type="button" value="Ver Detalle">
					<input class="cancel" type="button" value="CANCELAR">
				</div>
			</div>
		</div>

	</div>
	<div class="wrapper">
		<a href="<?=base_url()?>index.php/encuestas?dni=<?=$_GET['dni']?>">
			<header>
			<div class="cont_logo">
				<img src="<?=base_url()?>encuesta/img/logo.png"/>
			</div>
			
			<!--
			<div class="cont_billetera">
				<a  href="#" class="billetera" style="margin-right: 15px;">
					<img style="width: 40px;height: 40px;" src="/encuesta/img/monedero.png">
				</a>
			</div>	
			-->
			<div style="clear: both;"></div>
			</header>
		</a>
		<div class="body_w">
			<div class="list-solicitud">
				<div class="cont_time-s">
					<h4>Fecha: <?=date('d/m/Y')?></h4>
					<h4><em>Bienvenido <?=@$tecnico?></em><br><a href="<?=base_url()?>">Cerrar Sesión</a></h4>
				</div>
				<div class="estados">
					<div class="total_e">
						Total Programado: <?=count($nuevos) + count($reprogramados) + count($atendidos) + count($pendientes) + count($rechazados) ?>
					</div>
					<div class="cont_e">
						<div class="cont-1">
							<h4>
								Validado
							</h4>
							<h3>
								<?=count($atendidos)?>
							</h3>
						</div>
						<div class="cont-1 cont2">
							<h4>
								Pendiente de Validar
							</h4>
							<h3>
								<?=count($pendientes)?>
							</h3>
						</div>
					</div>
					<div class="cont_e">
						<div class="cont-1 cont3">
							<h4>
								Reprogramado
							</h4>
							<h3>
								<?=count($reprogramados)?>
							</h3>
						</div>
						<div class="cont-1 cont4">
							<h4>
							   Rechazado
							</h4>
							<h3>
								<?=count($rechazados)?>
							</h3>
						</div>
					</div>
				</div>
				<div class="container-list" id="tab-ui">
					<ul class="ui-tabs-links tab-links">
						<li class="active">
							<a href="#" class="check">
								<span>(<?=count($nuevos)?>)</span>	
							</a>
						</li>
						<li>
							<a href="#"  class="alert">
								<span>(<?=count($pendientes)?>)</span> 
							</a>
						</li>
						<li>
							<a href="#"  class="photo">
								<span>(<?=count($sinfotos)?>)</span>
							</a>
						</li>                        
					</ul>
					<div class="wrap-ui-container-tab">
						<div class="tab-content-group ui-container-tab">
							<div class="ui-tab-item active tab-content">
								<div class="tab-title">BANDEJA DE ENTRADA</div>
								<?php if ( count($reprogramados) ) { ?>
								<?php foreach ( $reprogramados as $key => $reprogramado ) { ?>
								<div class="cont-solicitud active tservicio" data-codigo="<?=$reprogramado->id?>">
									<div class="data1 t1">TIPO DE SERVICIO</div>
									<div class="data2"><?=$reprogramado->tsnombre?></div>
									<div class="data1">CÓDIGO SOT</div>
									<div class="data2"><?=$reprogramado->id?></div>
									<div class="data1">HORA</div>
									<div class="data2"><?=$reprogramado->hora?></div>
									<div class="data1">CLIENTE</div>
									<div class="data2"><?=$reprogramado->cliente?></div>
									<div class="data1">ESTADO</div>
									<div class="data2 combo step1 combo-ui">
										<select name="">
										<?php foreach ( $estados as $estadoid => $estado ) { ?>
											<option <?=($estadoid==4)?'selected':''?> value="<?=$estadoid?>"><?=$estado?></option>
										<?php } ?>
										</select>
									</div>
									<div class="data1 label display-none combo-ui-lnk">
										MOTIVO RECHAZO
									</div>
								</div>
								<?php } ?>
								<?php } ?>

								<?php if ( count($nuevos) ) { ?>
								<?php foreach ( $nuevos as $key => $nuevo ) { ?>
								<div class="cont-solicitud" data-codigo="<?=$nuevo->id?>">
									<div class="data1">TIPO DE SERVICIO</div>
									<div class="data2"><?=$nuevo->tsnombre?></div>
									<div class="data1">CÓDIGO SOT</div>
									<div class="data2"><?=$nuevo->id?></div>
									<div class="data1">HORA</div>
									<div class="data2"><?=$nuevo->hora?></div>
									<div class="data1">CLIENTE</div>
									<div class="data2"><?=$nuevo->cliente?></div>
									<div class="data1">ESTADO</div>
									<div class="data2 combo step1 combo-ui">
										<select name="">
										<?php foreach ( $estados as $estadoid => $estado ) { ?>
											<option <?=($estadoid==1)?'selected':''?> value="<?=$estadoid?>"><?=$estado?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<?php } ?>
								<?php } ?>
							</div>
							<div class="ui-tab-item tab-content">
								<div class="tab-title">PENDIENTE VALIDAR</div>
								<?php if ( count($pendientes) ) { ?>
								<?php unset($estados[1], $estados[4], $estados[5]); ?>
								<?php foreach ( $pendientes as $key => $pendiente ) { ?>
								<div class="cont-solicitud" data-codigo="<?=$pendiente->id?>">
									<div class="data1">CÓDIGO SOT</div>
									<div class="data2"><?=$pendiente->id?></div>
									<div class="data1">MOTIVO</div>
									<div class="data2"><?=isset($pendiente->motivo)?$pendiente->motivo:'-'?></div>

									<div class="data1">FECHA INSTALACION</div>
									<div class="data2">
			<?=date('Y-m-d 00:00:00',$pendiente->fecha_instalacion)?></div>

									<div class="data1">HORA</div>
									<div class="data2"><?=$pendiente->hora?></div>
									<div class="data1">CLIENTE</div>
									<div class="data2"><?=$pendiente->cliente?></div>
									<div class="data1">DIRECCIÓN</div>
									<div class="data2"><?=$pendiente->direccion?></div>
									<div class="data1">ESTADO</div>
									<div class="data2 combo step1 combo-ui">
										<select name="">
										<?php foreach ( $estados as $estadoid => $estado ) { ?>
											<option <?=($estadoid==3)?'selected':''?> value="<?=$estadoid?>"><?=$estado?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<?php } ?>
								<?php } ?>                          
							</div>
							<div class="ui-tab-item tab-content">
								<div class="tab-title">RF PENDIENTES</div>
								<?php if ( count($sinfotos) ) { ?>
								<?php foreach ( $sinfotos as $key => $sinfoto ) { ?>
								<div class="cont-solicitud">
									<div class="data1">Nro. SOT</div>
									<div class="data2"><?=$sinfoto->id?></div>
									<div class="data1">ESTADO DE FOTO</div>
									<div class="data2"><?=$sinfoto->rfnombre?></div>
									<div class="data1">MOTIVO</div>
									<div class="data2"><?=isset($sinfoto->motivorf)?$sinfoto->motivorf:'-'?></div>
									<div class="data1">TITULAR</div>
									<div class="data2"><?=$sinfoto->cliente?></div>
									<div class="data1"> DIRECCION</div>
									<div class="data2"><?=$sinfoto->direccion?></div>
									<div class="data1">PLANO</div>
									<div class="data2"><?=$sinfoto->plano?></div>


									<div class="data1">FECHA INSTALACION</div>
<div class="data2"><?=date('Y-m-d 00:00:00',$sinfoto->fecha_instalacion)?>
									</div>
									


									<div class="data1">ESTADO</div>
									<div class="data2 combo step1 combo-ui">                                             
										<select disabled>
											<option value="Atendido">Atendido</option>
										</select>
									</div>
								</div>
								<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
