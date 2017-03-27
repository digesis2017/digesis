			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> <?=(@$data)?'Editar Supervisor' : 'Crear Supervisor'?> &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/supervisores/lista">Regresar a Supervisores</a></h2>
			</div>
			<br>

			<?php $data = @$data[0]; ?>
			<?php if ( @$data )
				echo form_open_multipart('supervisores/edit/' . @$data->id);
			else
				echo form_open_multipart('supervisores/add');
			?>

			<table class="table table-bordered table-striped">
				<tr>
					<td>Nombres : </td><td><input pattern="[/\s/ÑñA-Za-z]{1,30}" title="Solo Letras" type="text" required maxlength="30" autofocus="autofocus" name="nombres" value="<?=@$data->nombres?>"></td>
				</tr>
				<tr>
					<td>Apellidos : </td><td><input pattern="[/\s/ÑñA-Za-z]{1,30}" title="Solo Letras" type="text" required maxlength="30" name="apellidos" value="<?=@$data->apellidos?>"></td>
				</tr>
				<tr>
					<td>DNI : </td><td><input class="solo-numero" type="text" required title="Sólo 8 Dígitos" pattern=".{8}" name="dni" value="<?=@$data->dni?>"></td>
				</tr>
				<tr>
					<td>Correo : </td><td><input type="email" required maxlength="40" size="40" name="email" value="<?=@$data->email?>"></td>
				</tr>
				<tr>
					<td>Jefe : </td>
					<td>
						<select required name="jefeid">
							<option value="">-Seleccione-</option>
							<?php foreach ( $jefes as $key => $jefe ) { ?>
								<option <?=(@$data->jefeid==$jefe->id ? 'selected' : '')?>  value="<?=$jefe->id?>"><?=$jefe->nombres . ' ' . $jefe->apellidos?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Base : </td>
					<td>
						<select name="baseid">
							<?php foreach ( $bases as $key => $base ) { ?>
								<option <?=(@$data->baseid==$base->id ? 'selected' : '')?>  value="<?=$base->id?>"><?=$base->nombre?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Usuario : </td><td><input maxlength="20" type="text" name="user" value="<?=@$data->user?>"></td>
				</tr>
				<tr>
					<td>Contraseña : </td><td><input maxlength="20" type="password" name="password" value="<?=@$data->password?>"></td>
				</tr>
				<?php if ( @$data->id ) { ?>
				<tr><td>Estado : </td>
					<td>
						<select id="publish" name="publish">
							<option <?=($data->publish)?'selected':''?> value="1">Activo</option>
							<option <?=(!$data->publish)?'selected':''?> value="0">Inactivo</option>
						</select>
					</td>
				</tr>
				<tr class="inactivo" style="display: none;">
					<td>Fecha de Cese : </td><td><input type="date" name="fecha_cese" value="<?=(@$data->fecha_cese) ? date('Y-m-d', $data->fecha_cese) : date('Y-m-d')?>"></td>
				</tr>
				<tr class="inactivo" style="display: none;">
					<td>Motivo del Cese : </td><td><textarea rows="4" style="width: 50%;" name="motivo_cese"><?=@$data->motivo_cese?></textarea></td>
				</tr>
				<?php } ?>
			</table>
			<div class="divbuttons">
				<input class="btnsearch" type="button" value="Regresar a Lista" onclick="window.location='<?=base_url()?>index.php/supervisores';">
				<input class="btnsearch" type="submit" value="<?=(@$data? 'Guardar' : 'Crear')?>">
			</div>
		</div>
	</div>
</body>
</html>