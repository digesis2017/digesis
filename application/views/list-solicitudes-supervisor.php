<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Lista de Solicitudes Supervisor</title>
		
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">


		<link href="<?=base_url()?>encuesta/css/style.css?v=11" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    
    <!-- Load jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
									

    
<script type="text/javascript">
	$(document).ready(function() {    
		$("#dialog_mi_popup").dialog({
			autoOpen: false,
			height: 550,
			width: 650,
			modal: true    
		});
	});

	function alertpopup(estado, id) {
		$.post('popupSup', { 'estado' : estado, 'tecnicoid' : id, 'fecha' : $("#fecha").val() },
			function(data){
				$("#dialog_mi_popup").html(data);
				$("#dialog_mi_popup").dialog( "open" );
			}
		);
	}

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
var url ='supervisor?dni='+dni+'&fecha='+$.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));


window.location.href=url;
            //selectedDate = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker('getDate'));
        }
    });
    });         
	
</script>
	</head>


	<body>	
	
	<div class="wrapper">		
			<header>
			<a href="<?=base_url()?>index.php/encuestas/supervisor?dni=<?=$_GET['dni']?>">
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
					<h4><em>Bienvenido <?=@$nom_supervisor?></em><br>
					<a href="<?=base_url()?>">Cerrar Sesión</a></h4>
				</div>
				<div class="estados">
					<div class="total_e">
						Total Programados: <?php echo @$acumulador['nuevos'] + @$acumulador['reprogramados'] + @$acumulador['atendidos'] + @$acumulador['pendientes'] + @$acumulador['rechazados']						
						?>
					</div>
					<div class="total_e" style="color: #e10b34">
						Pendiente de asignar: <?php echo @$acumulador['nuevos']			
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
				<!--
					<ul class="ui-tabs-links tab-links">
						<li class="active">
							<a href="#" class="check">
								<span></span>	
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
					-->
					<div class="wrap-ui-container-tab">
						<div class="tab-content-group ui-container-tab">
							<div class="ui-tab-item active tab-content">
								<div class="tab-title">RESUMEN POR TECNICO</div>
		           

				<table id="tbmonedero" class="detalle-billetera">
					<thead>
						<tr>		
							<th>Tecnico</th>
							<th>SOT Atendidos</th>
							<th>SOT pendientes</th>		
							<th>SOT reprogramados</th>	  
							<th>SOT rechazados</th>	
							<th>Pend. asignar</th>
							<th>Pend. RF</th>
						</tr>
					</thead>
					<tbody>
			<?php 	
			if (!empty($supervisor)):				
				foreach($supervisor as $key=>$value): ?>
					<tr>	
						<td data-label="Tecnico">
						<?php echo $value['tecnico']; ?></td>
						<td data-label="SOT Atendidos">
						<?php echo count($value['atendidos']) ?></td>

						<?php if ( count($value['pendientes']) ) { ?>
						<td data-label="SOT pendientes"><a href="#" onclick="alertpopup('pendientes', <?=$value['id']?>);"><?=count($value['pendientes'])?></a></td>
						<?php } else { ?>
						<td data-label="SOT pendientes">0</td>
						<?php } ?>

						<td data-label="SOT reprogramados"><?php echo count($value['reprogramados']) ?></td>
						<td data-label="SOT rechazados"><?php echo count($value['rechazados']) ?></td>

						<?php if ( count($value['nuevos']) ) { ?>
						<td data-label="Pend. asignar"><a href="#" onclick="alertpopup('nuevos', <?=$value['id']?>);"><?=count($value['nuevos'])?></a></td>
						<?php } else { ?>
						<td data-label="Pend. asignar">0</td>
						<?php } ?>

						<?php if ( count($value['sinfotos']) ) { ?>
						<td data-label="Pend. RF"><a href="#" onclick="alertpopup('sinfotos', <?=$value['id']?>);"><?=count($value['sinfotos'])?></a></td>
						<?php } else { ?>
						<td data-label="Pend. RF">0</td>
						<?php } ?>
					</tr>
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
			<div id="dialog_mi_popup" style="display: none" title="Nueva Ventana"></div>
		</div>
		</div>
	</body>
</html>
