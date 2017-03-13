			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>
<script>

function delete_user(row)
    {
        row.closest('tr').remove();

    }

$(document).ready(function() {

	$("#sid").blur(function() {
  		$.post( "../validateSid", { sid: $(this).val(), evento : $("#status").val(), asid : $("#asid").val() ? $("#asid").val() : 0 })
  		.done(function( data ) {
  			if ( data == 'OK' ) {
  				$(".check").show('fast');
  				$(".nocheck").hide('fast');
  			}
  			else {
  				$(".nocheck").show('fast');
  				$(".check").hide('fast');
  			}
  		});
	});

	

	$("#solicitudform").submit(function( event ){
	  
	  var data = [];  
      var item = {};

      $("input[name='timepicker[]']").each(function ()
      {
      	item = {};

		var id =$(this).attr('data-id');
		var fecha=$('input#fecha_instalacion_'+id).val();	
		var tipotrabajoid=$('select#tipotrabajoid_'+id).val();	  	
      	item['id']=$(this).attr('data-id');
      	item['fecha']=fecha;
      	item['hora']=$(this).val();
      	item['tipotrabajoid']=tipotrabajoid;
        data.push(item);           
      });
                 
      var form=new FormData();
      var str=JSON.stringify(data);      
      form.append('data',str);
      form.append('supervisorid',$('#supervisorid').val());
      form.append('tecnico1id',$('#tecnico1id').val());
      form.append('tecnico2id',$('#tecnico2id').val());	        
		$.ajax({
			data: form,
			type: 'POST',
			url : '/index.php/solicitudes/asignar',
			processData: false, 
			contentType: false,
			success: function(r){
				console.log(r);
				//obj = JSON.parse(r);
				//alert(obj.msg);
				$("#msg_asignacion").fadeOut();
				$("#msg_asignacion").removeClass('hidden');				
				setTimeout(function() {
				$("#msg_asignacion").fadeIn();
    			$("#msg_asignacion").addClass('hidden');
    			document.location.href="<?=base_url()?>index.php/solicitudes/listatecnicos";
				}, 3000);




			}
		});

    return false;
  });

					
	$('.timepicker').timepicker({
    timeFormat: 'H:mm',
    interval: 30,
    minTime: '10',
    maxTime: '19:00',    
    startTime: '08:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

});

</script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> <?=(@$data)?'Editar Solicitud' : 'Asignar Solicitud'?> &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/solicitudes/listatecnicos">Regresar a Lista de Solicitudes</a></h2>
			</div>
			<br>

			<?php						
				$check = 'display: none;';
				$nocheck = '';
				echo '<input type="hidden" id="status" value="add"/>';
				echo form_open_multipart('solicitudes/asignar', array('id' => 'solicitudform'));			
			?>

<table class="table table-bordered table-striped">
<input type="hidden" id="url" value="<?=base_url()?>index.php/solicitudes"/>
<div id="msg_asignacion" class="msgimportante hidden">Se asignaron correctamente las solicitudes</div>
<thead>
	<tr>
		<th>N.Sot</th>
		<th>Tecnico1</th>
		<th>Tecnico2</th>
		<th>Tipo de Trabajo</th>
		<th>Fecha Prog.</th>
		<th>Hora Prog.</th>
		<th>Accion</th>

	</tr>
</thead>
<tbody>
<?php foreach ($r_sol_tec as $key => $value) { ?>
	<tr>
		<td><?php echo $value['id']?></td>
		<td align="center"><?php echo $value['tecnico1'] ?></td>
		<td><?php echo $value['tecnico2'] ?></td>
		<td>	
			<select required name="tipotrabajoid" id="tipotrabajoid_<?=$key?>" style="width:150px">
				<option value="">-Seleccione-</option>							
				<?php foreach ($value['tipotrabajos'] as $key2 => $tipotrabajo ) { ?>
				<option <?=(@$data->tipotrabajoid==$tipotrabajo->id ? 'selected' : '')?>  value="<?=$tipotrabajo->id?>"><?=$tipotrabajo->descripcion?></option>
				<?php } ?>
			</select>
		</td>
		<td align="center">
		<input required type="date" style="width:130px" id="fecha_instalacion_<?php echo $key ?>" name="fecha_instalacion_<?php echo $key ?>" value="<?=(@$value['fecha']) ? $value['fecha'] : null?>"></td>

		<td><input type="text" name="timepicker[]" style="width:100px" data-id="<?php echo $value['id']?>" class="timepicker" id="timepicker" value="<?php echo $value['hora'] ?>"> </input></td>
		<td>
		<?php 		  
		if ($value['tecnico2']=="sin asignar"): ?>
			<a href="#" style="color:#11992a" onclick ="delete_user($(this))">retirar</a>
		<?php else:?>
			<a href="" style="color:#d3dbe2" onclick ="">retirar</a>
		<?php endif;?>

		</td>

	</tr>
	<?php
		}
	?>

</tbody>
</table>

					
				<br>
				<fieldset class="fieldform">
					<legend><b>Personal</b></legend>
					<table class="table table-bordered table-striped">
					<!--
						<tr>
							<td>Analista de Servicio: </td>
							<td>
								<select name="analistaid" id="analistaid">
									<option value="0">-Seleccione-</option>
									<?php foreach ( $analistas as $key => $analista ) { ?>
									<option <?=(@$data->aid==$analista->id ? 'selected' : '')?>  value="<?=$analista->id?>"><?=$analista->nombres . ' ' . $analista->apellidos?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						-->
						<tr>
							<td>Supervisor : </td>
							<td>
								<select name="supid" id="supervisorid">
									<option value="0">-Seleccione-</option>
									<?php foreach ( $supervisores as $key => $supervisor ) { ?>
									<option <?=(@$data->supid==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$supervisor?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Técnico 1 : </td>
							<td>
								<select id="tecnico1id" name="tecnico1id">
									<option value="0">-Seleccione-</option>
									<?php foreach ( @$tecnicos1 as $key => $tecnico1 ) { ?>
									<option <?=(@$data->t1id==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tecnico1?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Técnico 2 : </td>
							<td>
								<select id="tecnico2id" name="tecnico2id">
									<option value="0">-Seleccione-</option>
									<?php foreach ( @$tecnicos2 as $key => $tecnico2 ) { ?>
									<option <?=(@$data->t2id==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tecnico2?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
					</table>
				</fieldset>
				<br><br>
				<div class="divbuttons">
					<input class="btnsearch" type="button" value="Regresar a Lista" onclick="window.location='<?=base_url()?>index.php/solicitudes/listatecnicos';">
					<input class="btnsearch" type="submit" value="<?=(@$data? 'Guardar' : 'Crear asignacion')?>">
				</div>
				</from>
		</div>
	</div>
</body>
</html>