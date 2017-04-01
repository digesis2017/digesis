			</div>

<script>
	$(document).ready(function() {
		$('input[type=radio][name=estadosrfid]').change(function() {
			if (this.value == '2')
				$("#divmotivo").show('slow');
			else
				$("#divmotivo").hide('slow');
		});
	});
</script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Editar Registro Fotográfico&nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/solicitudes/listarf">Regresar a Registros Fotograficos</a></h2>
			</div>
			<br>

			<?php if ( @$data ) echo form_open_multipart('solicitudes/editrf/' . @$data->id); ?>
				<fieldset class="rffieldset">
					<legend><b>Estado</b></legend>
					<?php foreach ($estadosrf as $id => $estadorf) { ?>
						<input type="radio" name="estadosrfid" value="<?=$id?>" <?=($data->rf==$id ? 'checked' : '')?> > <?=$estadorf?>&nbsp;&nbsp;&nbsp;
					<?php } ?>
					<?php if ( $data->rf == 2 ) { ?>
					<div id="divmotivo"><br><b>Motivo:</b><br><textarea rows="4" style="width: 50%;" id="motivo" name="motivo"><?=$data->motivorf?></textarea></div>
					<?php } else { ?>
					<div id="divmotivo" style="display: none;"><br><b>Motivo:</b><br><textarea rows="4" style="width: 50%;" id="motivo" name="motivo"><?=$data->motivorf?></textarea></div>
					<?php } ?>
				</fieldset>
				<br>

			<table class="table table-bordered table-striped">
				<tr>
					<td>N° Solicitud : </td><td><input type="text" disabled name="solicitudid" value="<?=@$data->id?>"></td>
				</tr>
				<tr>
					<td>Fecha de Programación : </td><td><input type="date" disabled name="fecha_instalacion" value="<?=(@$data->fecha_instalacion) ? date('Y-m-d', $data->fecha_instalacion) : null?>"></td>
				</tr>
				<tr>
					<td>Tipo de Trabajo : </td>
					<td>
						<select disabled name="tipotrabajoid">
							<?php foreach ( $tipotrabajos as $key => $tipotrabajo ) { ?>
								<option <?=(@$data->tipotrabajoid==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tipotrabajo?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Tipo de Servicio : </td>
					<td>
						<select disabled name="tiposervicioid">
							<?php foreach ( $tiposervicios as $key => $tiposervicio ) { ?>
								<option <?=(@$data->tiposervicioid==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tiposervicio?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Plano : </td><td><input disabled type="text" name="plano" value="<?=@$data->plano?>"></td>
				</tr>
				</table>
				<div class="divbuttons">
					<input class="btnsearch" type="button" value="Regresar a Lista" onclick="window.location='<?=base_url()?>index.php/solicitudes/listarf';">
					<input class="btnsearch" type="submit" value="<?=(@$data? 'Guardar' : 'Crear')?>">
				</div>
		</div>
	</div>
</body>
</html>