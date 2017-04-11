			</div>
			<script>
				$(document).ready(function() {
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
			<script src="<?=base_url()?>js/departamentos.js"></script>
			<script src="<?=base_url()?>js/tecnicos.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;">Asignar Técnico&nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/solicitudes/listatecnicos">Regresar a Asignar Técnicos</a></h2>
			</div>
			<br>

			<?php
				if ( isset($_GET) && (@$_GET['flag']=='seguimiento') )
					echo form_open_multipart('solicitudes/edittecnicos/' . @$data->id . '?flag=seguimiento');
				else
					echo form_open_multipart('solicitudes/edittecnicos/' . @$data->id);
			?>
			<input type="hidden" id="url" value="<?=base_url()?>index.php/solicitudes"/>
			<input type="hidden" id="urlt" value="<?=base_url()?>index.php/tecnicos"/>
			<table class="table table-bordered table-striped">
				<tr>
					<td>N° Solicitud : </td><td><input disabled type="text" name="solicitudid" value="<?=@$data->id?>"></td>
				</tr>
				<tr>
					<td>Fecha de Programación : </td><td><input required type="date" name="fecha_instalacion" value="<?=(@$data->fecha_instalacion) ? date('Y-m-d', $data->fecha_instalacion) : null?>"></td>
				</tr>
				<tr>
					<td>Hora : </td><td><input type="text" name="hora" class="timepicker" maxlength="5" value="<?=@$data->hora?>"></td>
				</tr>
				<tr>
					<td>Tipo de Serviciooos : </td>
					<td>
						<select disabled="true" required name="tiposervicioid" id="tiposervicioid" style="display:true">
							<option value="">-Seleccione-</option>
							<?php foreach ( $tiposervicios as $key => $tiposervicio ) { ?>
								<option <?=(@$data->tiposervicioid==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tiposervicio?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Tipo de Trabajo : </td>
					<td>
						<!--<select required name="tipotrabajoid" id="tipotrabajoid">
							<option value="">-Seleccione-</option>							
							<?php foreach ( $tipotrabajos as $key => $tipotrabajo ) { ?>
								<option <?=(@$data->tipotrabajoid==$tipotrabajo->id ? 'selected' : '')?>  value="<?=$tipotrabajo->id?>"><?=$tipotrabajo->descripcion?></option>
							<?php } ?>
						</select>-->
						<input type="text" name="tipotrabajoid" size="40" value=<?=@$data->tipotrabajo?>>
					</td>
				</tr>
			</table>
			<fieldset class="fieldform">
				<legend><b>Personal</b></legend>
				<table class="table table-bordered table-striped">
					<tr>
						<td>Buscar por Supervisor : </td>
						<td>
							<select required name="supid" id="supervisorid">
								<option value="">-Seleccione-</option>
								<?php foreach ( $supervisores as $key => $supervisor ) { ?>
								<option <?=(@$data->supid==$key ? 'selected' : '')?> value="<?=$key?>"><?=$supervisor?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Técnico 1: : </td>
						<td>
							<select id="tecnico1id" name="tecnico1id">
								<option value="">-Seleccione-</option>
								<?php foreach ( @$tecnicos1 as $key => $tecnico1 ) { ?>
								<option <?=(@$data->t1id==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tecnico1?></option>
								<?php } ?>
							</select>
							<b><span id="tec1cell"></span></b>
						</td>
					</tr>
					<tr>
						<td>Técnico 2: : </td>
						<td>
							<select id="tecnico2id" name="tecnico2id">
								<option value="0">-Seleccione-</option>
								<?php foreach ( @$tecnicos2 as $key => $tecnico2 ) { ?>
								<option <?=(@$data->t2id==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tecnico2?></option>
								<?php } ?>
							</select>
							<b><span id="tec2cell"></span></b>
						</td>
					</tr>
				</table>
			</fieldset>
			<br><br>
			<div class="divbuttons">
				<input class="btnsearch" type="button" value="Regresar a Lista" onclick="window.location='<?=base_url()?>index.php/solicitudes/listatecnicos';">
				<input class="btnsearch" type="submit" value="<?=(@$data? 'Guardar' : 'Crear')?>">
			</div>
		</div>
	</div>
</body>
</html>