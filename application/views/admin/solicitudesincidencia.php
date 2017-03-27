			</div>

<script>
	function agregarIncidencia() {
		var contador = $("#contador").val();
		if ( $("#fecha_incidencia").val() ) {
			$("#incidencias").append('<tr><td>' + contador + '</td><td>' + $("#fecha_incidencia").val() + '</td></tr><input type="hidden" name="incidencias[]" value="' +  $("#fecha_incidencia").val() + '"/>');
			$("#contador").val(parseInt(contador) + 1);
		}
		else
			alert('Elija una fecha Correcta');
	}
</script>

			<div class="list-mod-panel">
				<h1 style="float: left;">Agregar Incidencias&nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/solicitudes/listavalidados">Regresar a Soporte de Servicio</a></h2>
			</div>
			<br>

			<?php
				echo form_open_multipart('solicitudes/addIncidencia/' . @$data->id);
			?>

			<table class="table table-bordered table-striped">
				<tr>
					<td>N° Solicitud : </td><td><input disabled type="text" name="solicitudid" value="<?=@$data->id?>"></td>
				</tr>
				<tr>
					<td>Fecha de Programación : </td><td><input disabled type="date" name="fecha_instalacion" value="<?=(@$data->fecha_instalacion) ? date('Y-m-d', $data->fecha_instalacion) : null?>"></td>
				</tr>
				<tr>
					<td>Técnico 1: : </td>
					<td>
						<select disabled id="tecnico1id" name="tecnico1id">
							<option value="0">-Sin Asignar-</option>
							<?php foreach ( @$tecnicos1 as $key => $tecnico1 ) { ?>
							<option <?=(@$data->t1id==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tecnico1?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Técnico 2: : </td>
					<td>
						<select disabled id="tecnico2id" name="tecnico2id">
							<option value="0">-Sin Asignar-</option>
							<?php foreach ( @$tecnicos2 as $key => $tecnico2 ) { ?>
							<option <?=(@$data->t2id==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tecnico2?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
			</table>
			<fieldset class="fieldform">
				<legend><b>Incidencias</b></legend>
				<table class="table table-bordered table-striped">
					<tr>
						<td>Fecha de Programación : </td>
						<td><input type="date" id="fecha_incidencia" name="fecha_incidencia"/><input onclick="agregarIncidencia();" type="button" class="btnsearch" value="Agregar"/></td>
					</tr>
				</table>
				<table id="incidencias" style="margin-left: 50%;" class="table table-striped">
					<tr>
						<td>N° Incidencia</td>
						<td>Fecha</td>
					</tr>
					<?php foreach ( $incidencias as $key => $value ) { ?>
						<tr>
							<td><?=$key?></td>
							<td><?=date('d-m-Y', $value)?></td>
						</tr>
					<?php } ?>
				</table>
			</fieldset>
			<br><br>
			<input type="hidden" id="contador" value="<?=count(@$incidencias) + 1?>"/>
			<div class="divbuttons">
				<input class="btnsearch" type="button" value="Regresar a Lista" onclick="window.location='<?=base_url()?>index.php/solicitudes/listavalidados';">
				<input class="btnsearch" type="submit" value="<?=(@$data? 'Guardar' : 'Crear')?>">
			</div>
		</div>
	</div>
</body>
</html>