<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Lista de Solicitudes Jefes</title>
		
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">


		<link href="<?=base_url()?>encuesta/css/style.css?v=13" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    
    <!-- Load jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    
<script type="text/javascript">

$(function() {

function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
 $( "#fecha" ).datepicker({
    //changeMonth: true,//this option for allowing user 
    //changeYear: true ,
    dateFormat:'yy-mm-dd',
	onSelect: function () {
		var dni = getParameterByName('dni');				  
var url ='/index.php/encuestas/jefe?dni='+dni+'&fecha='+$.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));


window.location.href=url;
            //selectedDate = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));
        }
    });


 $("#tbmonedero  a.supervisor_detalle" ).on( "click", function() {
    var id=$(this).attr('data-id');
  
  if($(".detalle_jefe-"+id).hasClass('hidden')){
      
      $(".detalle_jefe-"+id).fadeIn();
      $(".detalle_jefe-"+id).removeClass('hidden');

  }else{

      $(".detalle_jefe-"+id).fadeOut();
      $(".detalle_jefe-"+id).addClass('hidden');      
    }

});

    });
	
</script>
<style type="text/css">
	.hidden {
	  display: none;
	}		
</style>
	</head>


	<body>	
	
	<div class="wrapper">		
			<header>
			<a href="<?=base_url()?>index.php/encuestas/jefe?dni=<?=$_GET['dni']?>">
			<div class="cont_logo">
				<img src="<?=base_url()?>encuesta/img/logo.png"/>
			</div>
			</a>			
			<div style="clear: both;"></div>
			</header>
		
		<div class="body_w">
			<div class="list-solicitud">
				<div class="cont_time-s">	
					<h4>Fecha: <input style="color: #333" type="text" id="fecha" value="<?=@$fecha?>" /></h4>
					<h4><em>Bienvenido Jefe: <?=@$jefe['nom_jefe']?></em><br>
					<a href="<?=base_url()?>">Cerrar Sesión</a></h4>
				</div>
				<div class="estados">
					<div class="total_e">
						Total Programado: <?php echo @$acumulador['nuevos'] + @$acumulador['reprogramados'] + @$acumulador['atendidos'] + @$acumulador['pendientes'] + @$acumulador['rechazados']		
						?>
					</div>
					<div class="total_e" style="color:#e10b34">
						Pendiente de asignar: <?php echo intval(@$acumulador['nuevos'])			
						?>
					</div>
					<div class="cont_e">
						<div class="cont-1">
							<h4>
								Validado
							</h4>
							<h3>
								<?=@$acumulador['atendidos']?>
							</h3>
						</div>
						<div class="cont-1 cont2">
							<h4>
								Pendiente de Validar
							</h4>
							<h3>
								<?=@$acumulador['pendientes']?>
							</h3>
						</div>
					</div>
					<div class="cont_e">
						<div class="cont-1 cont3">
							<h4>
								Reprogramado
							</h4>
							<h3>
								<?=@$acumulador['reprogramados']?>
							</h3>
						</div>
						<div class="cont-1 cont4">
							<h4>
							   Rechazado
							</h4>
							<h3>
								<?=@$acumulador['rechazados']?>
							</h3>
						</div>
					</div>
				</div>
				<div class="container-list" id="tab-ui">				
					<div class="wrap-ui-container-tab">
						<div class="tab-content-group ui-container-tab">
							<div class="ui-tab-item active tab-content">
								<div class="tab-title">RESUMEN POR SUPERVISOR</div>
		           

		<table id="tbmonedero" class="detalle-billetera">
					<thead>
						<tr>		
							<th>Supervisor</th>
							<th>SOT Atendidos</th>
							<th>SOT pendientes</th>		
							<th>SOT reprogramados</th>	  
							<th>SOT rechazados</th>
							<th>Pend. de asignar</th>
							<th>Pend. de RF</th>
						</tr>
					</thead>
					<tbody>
	<?php 	
	if (!empty($jefe['supervisor'])):
	foreach($jefe['supervisor'] as $key_sup=>$value):
	?>
	<tr>	
	<td data-label="Supervisor">
	<a href="#" id="idsupervidor" data-id="<?php echo $key_sup;?>" class="supervisor_detalle">
	<?php echo $value['nom_supervisor']; ?></td>
	</a>
	<td data-label="SOT Atendidos">
	<?php echo $sum_sup[$key_sup]['atendidos'] ?></td>
	<td data-label="SOT pendientes">
	<?php echo $sum_sup[$key_sup]['pendientes'] ?></td>
	<td data-label="SOT reprogramados">
	<?php echo $sum_sup[$key_sup]['reprogramados'] ?></td>
	<td data-label="SOT rechazados">
	<?php echo $sum_sup[$key_sup]['rechazados'] ?></td>	

	<td data-label="Pend. de asignar">
	<?php echo $sum_sup[$key_sup]['nuevos'] ?></td>	

	<td data-label="Pend. de RF">
	<?php echo $sum_sup[$key_sup]['sinfotos'] ?></td>	

	</td>
	</tr>

	<?php 
	if(!empty($value['tec'])):
		foreach($value['tec'] as $key=>$row):		
	?>

<tr style="background: #c4e5fa" class="hidden detalle_jefe-<?php echo $key_sup?>">	  
		<td style="text-align: right;" data-label="Tecnico">
		<?php echo @$row['tecnico']; ?></td>
		<td data-label="SOT Atendidos">
		<?php echo @intval(count($row['atendidos'])) ?></td>
		<td data-label="SOT pendientes">
		<?php echo @intval(count($row['pendientes'])) ?></td>
		<td data-label="SOT reprogramados">
		<?php echo @intval(count($row['reprogramados'])) ?></td>
		<td data-label="SOT rechazados">
		<?php echo @intval(count($row['rechazados'])) ?></td>	
		<td data-label="Pend. asignar">
		<?php echo @intval(count($row['nuevos'])) ?></td>	
		
</tr>
	<?php 
		endforeach;
		endif;?>
</div>
		<?php
	endforeach;
	endif;
	?>	
					</tbody>					  
				</table>


																
							</div>
													
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</body>
</html>
