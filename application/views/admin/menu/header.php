<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" class="pannel-toolbar">
<head>
	<meta charset="utf-8">	
	<title>ATENCIÓN TÉCNICA CLARO</title>
	<link rel="stylesheet" href="<?=base_url()?>css/bootstrap.css">

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/style.css">
	<link rel="stylesheet" href="<?=base_url()?>css/font-awesome.min.css">
	<script src="<?=base_url()?>encuesta/js/jquery-1.9.1.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="<?=base_url()?>js/asistencia.js"></script>

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

		
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">

	<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>


	<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

	

	
	

</head>
<body>
<?php $session = get_session(); ?>
	<div id="container">
		<header>
			<div class="header-inner">
				<h1 style="float: left;">Bienvenidos al Administrador</h1>
				<p style="float: right;">Bienvenido <em><?=$session->user?></em>, <a href="<?=base_url()?>index.php/admin/unset_session">Cerrar Sesión</a></p>
			</div>
		</header>
		<div class="right-list-admin">
			<dl class="list-menu">
				<?php if ( $session->rolid == 1 ) { ?>
				<dt><a <?=($active=='solicitudes')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes"><i class="fa fa-star"></i> Solicitudes</a></dt>
					<dd><a <?=($active=='solicitudes')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes"><i class="fa fa-ticket"></i> Todas Las Solicitudes </a></dd>
					<dd><a <?=($active=='solicitudesadd')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/form/add"><i class="fa fa-ticket"></i> Agregar Solicitud </a></dd>
				<dt><a <?=($active=='solicitudesload')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/carga"><i class="fa fa-star"></i> Cargar Solicitudes</a></dt>

<dt><a <?=($active=='serviciosload')?'class="active"':''?>href="<?=base_url()?>index.php/servicios"><i class="fa fa-star"></i> Cargar Servicios</a></dt>

				<dt><a <?=($active=='asignartecnicos')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/listatecnicos"><i class="fa fa-star"></i> Soporte de Servicio</a></dt>
				<dt><a <?=($active=='listarf')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/listarf"><i class="fa fa-star"></i> Registro Fotográfico</a></dt>

				<dt><a <?=($active=='asistencia')?'class="active"':''?>href="<?=base_url()?>index.php/asistencia"><i class="fa fa-star"></i> Asistencia de Técnicos</a></dt>

				<dt><a <?=($active=='monedero')?'class="active"':''?>href="<?=base_url()?>index.php/monedero"><i class="fa fa-star"></i> Monedero</a></dt>

				<dt><a <?=($active=='usuarios')?'class="active"':''?>href="<?=base_url()?>index.php/usuarios"><i class="fa fa-star"></i> Roles</a></dt>

					<dd><a <?=($active=='usuarios')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios"><i class="fa fa-ticket"></i> Todas Los Usuarios </a></dd>
					<dd><a <?=($active=='usuariosadd')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios/form"><i class="fa fa-ticket"></i> Crear Usuario </a></dd>
					<dd><a <?=($active=='usuarioactivo')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-ticket"></i> Tu Usuario </a></dd>

				<dt><a <?=($active=='perfiles')?'class="active"':''?>href="<?=base_url()?>index.php/perfiles"><i class="fa fa-star"></i> Perfiles</a></dt>
					<dd><a <?=($active=='perfiles')?'class="active"':''?>href="<?=base_url()?>index.php/perfiles"><i class="fa fa-ticket"></i> Todas Los Perfiles </a></dd>
					<dd><a <?=($active=='jefes')?'class="active"':''?>href="<?=base_url()?>index.php/jefes/form"><i class="fa fa-ticket"></i> Crear Jefe </a></dd>
					<dd><a <?=($active=='supervisores')?'class="active"':''?>href="<?=base_url()?>index.php/supervisores/form"><i class="fa fa-ticket"></i> Crear Supervisor </a></dd>
					<dd><a <?=($active=='tecnicos')?'class="active"':''?>href="<?=base_url()?>index.php/tecnicos/form"><i class="fa fa-ticket"></i> Crear Tecnico </a></dd>
				<dt><a href="#"><i class="fa fa-star"></i> Reportes </a></dt>
					<dd><a <?=($active=='solicitudes')?'class="active"':''?>href="<?=base_url()?>index.php/reportes/solicitudes"><i class="fa fa-ticket"></i> Solicitudes </a></dd>
					<dd><a <?=($active=='encuestas')?'class="active"':''?>href="<?=base_url()?>index.php/reportes/encuestas"><i class="fa fa-ticket"></i> Encuestas </a></dd>
					<dd><a <?=($active=='eficiencia')?'class="active"':''?>href="<?=base_url()?>index.php/reportes/eficiencia"><i class="fa fa-ticket"></i> Eficiencia </a></dd>
					<dd><a <?=($active=='rfotografico')?'class="active"':''?>href="<?=base_url()?>index.php/reportes/rfotografico"><i class="fa fa-ticket"></i> Registro F. </a></dd>
					<dd><a <?=($active=='produccion')?'class="active"':''?>href="<?=base_url()?>index.php/reportes/produccion"><i class="fa fa-ticket"></i> Produccion </a></dd>
				<?php } else if ( $session->rolid == 2 ) { ?>

				<dt><a <?=($active=='asistencia')?'class="active"':''?>href="<?=base_url()?>index.php/asistencia"><i class="fa fa-star"></i> Asistencia de Técnicos</a></dt>

				<dt><a <?=($active=='usuarios')?'class="active"':''?>href="<?=base_url()?>index.php/usuarios"><i class="fa fa-star"></i> Roles</a></dt>
					<dd><a <?=($active=='usuarios')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios"><i class="fa fa-ticket"></i> Todas Los Usuarios </a></dd>
					<dd><a <?=($active=='usuariosadd')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios/form"><i class="fa fa-ticket"></i> Crear Usuario </a></dd>
					<dd><a <?=($active=='usuarioactivo')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-ticket"></i> Tu Usuario </a></dd>
				<dt><a <?=($active=='perfiles')?'class="active"':''?>href="<?=base_url()?>index.php/perfiles"><i class="fa fa-star"></i> Perfiles</a></dt>
					<dd><a <?=($active=='perfiles')?'class="active"':''?>href="<?=base_url()?>index.php/perfiles"><i class="fa fa-ticket"></i> Todas Los Perfiles </a></dd>
					<dd><a <?=($active=='jefes')?'class="active"':''?>href="<?=base_url()?>index.php/jefes/form"><i class="fa fa-ticket"></i> Crear Jefe </a></dd>
					<dd><a <?=($active=='supervisores')?'class="active"':''?>href="<?=base_url()?>index.php/supervisores/form"><i class="fa fa-ticket"></i> Crear Supervisor </a></dd>
					<dd><a <?=($active=='tecnicos')?'class="active"':''?>href="<?=base_url()?>index.php/tecnicos/form"><i class="fa fa-ticket"></i> Crear Tecnico </a></dd>				
				<?php } else if ( $session->rolid == 3 ) { ?>
				<dt><a <?=($active=='solicitudesload')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/carga"><i class="fa fa-star"></i> Cargar Solicitudes</a></dt>
				<dt><a <?=($active=='usuarios')?'class="active"':''?>href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-star"></i> Roles</a></dt>
					<dd><a <?=($active=='usuarioactivo')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-ticket"></i> Tu Usuario </a></dd>
				<?php } else if ( $session->rolid == 4 ) { ?>
				<dt><a <?=($active=='solicitudes')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/form/add"><i class="fa fa-star"></i> Solicitudes</a></dt>
					<dd><a <?=($active=='solicitudesadd')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/form/add"><i class="fa fa-ticket"></i> Agregar Solicitud </a></dd>
				<dt><a <?=($active=='asignartecnicos')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/listatecnicos"><i class="fa fa-star"></i> Soporte de Servicio</a></dt>
				<dt><a <?=($active=='usuarios')?'class="active"':''?>href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-star"></i> Roles</a></dt>
					<dd><a <?=($active=='usuarioactivo')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-ticket"></i> Tu Usuario </a></dd>
				<?php } else if ( $session->rolid == 6 ) { ?>
				<dt><a <?=($active=='listarf')?'class="active"':''?>href="<?=base_url()?>index.php/solicitudes/listarf"><i class="fa fa-star"></i> Registro Fotográfico</a></dt>
				<dt><a <?=($active=='usuarios')?'class="active"':''?>href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-star"></i> Roles</a></dt>
					<dd><a <?=($active=='usuarioactivo')?'class="active"':''?> href="<?=base_url()?>index.php/usuarios/tuusuario/<?=$session->id?>"><i class="fa fa-ticket"></i> Tu Usuario </a></dd>
				<?php } ?>
			</dl>

		</div>
		<div class="right-content">	
			<div class="list-mod-panel">
				<!--<h2><a target="_blank" href="<?=base_url()?>">Visitar Sitio</a></h2>-->