			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> <?=(@$data)?'Editar Técnico' : 'Crear Técnico'?> &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/tecnicos/lista">Regresar a Técnicos</a></h2>
			</div>
			<br>

			<?php $data = @$data[0]; ?>
			<?php if ( @$data )
				echo form_open_multipart('tecnicos/edit/' . @$data->id);
			else
				echo form_open_multipart('tecnicos/add');
			?>

			<table class="table table-bordered table-striped">
				<tr>
					<td>Nombres : </td><td><input pattern="[/\s/ÑñA-Za-z]{1,30}" title="Solo Letras" type="text" required maxlength="30" autofocus="autofocus" name="nombres" value="<?=@$data->nombres?>"></td>
				</tr>
				<tr>
					<td>Apellidos : </td><td><input pattern="[/\s/ÑñA-Za-z]{1,30}" title="Solo Letras" type="text" required maxlength="30" name="apellidos" value="<?=@$data->apellidos?>"></td>
				</tr>
				<tr>
					<td>DNI : </td><td><input class="solo-numero" title="Sólo 8 Dígitos" pattern=".{8}" type="text" required name="dni" value="<?=@$data->dni?>"></td>
				</tr>
				<tr>
					<td>Correo : </td><td><input type="email" required maxlength="40" size="40" name="email" value="<?=@$data->email?>"></td>
				</tr>
				<tr>
					<td>Cargo : </td><td><select name="cargo"><option value="1" <?=(@$data->cargo==1?'selected':'')?>>Técnico 1</option><option value="2" <?=(@$data->cargo==2?'selected':'')?>>Técnico 2</option></select></td>
				</tr>
				<tr>
					<td>RPC (9*) : </td><td><input class="solo-numero" type="text" name="rpc" value="<?=@$data->rpc?>"></td>
				</tr>
				<tr>
					<td>Fecha Ingreso : </td><td><input type="date" required name="fechaingreso" value="<?=(@$data->fechaingreso) ? date('Y-m-d', $data->fechaingreso) : date('Y-m-d')?>"></td>
				</tr>
				<tr>
					<td>Renta : </td>
					<td>
						<select name="renta">
							<option value="0">-Seleccione-</option>
							<option value="4" <?=(@$data->renta==4?'selected':'')?> >4ta Categoría</option>
							<option value="5" <?=(@$data->renta==5?'selected':'')?>>5ta Categoría</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Supervisor : </td>
					<td>
						<select required name="supervisorid">
							<option value="">-Seleccione-</option>
							<?php foreach ( $supervisores as $key => $supervisor ) { ?>
								<option <?=(@$data->supervisorid==$supervisor->id ? 'selected' : '')?>  value="<?=$supervisor->id?>"><?=$supervisor->nombres . ' ' . $supervisor->apellidos?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Base : </td>
					<td>
						<select name="baseid">
							<option value="0">-Seleccione-</option>
							<?php foreach ( $bases as $key => $base ) { ?>
								<option <?=(@$data->baseid==$base->id ? 'selected' : '')?>  value="<?=$base->id?>"><?=$base->nombre?></option>
							<?php } ?>
						</select>
					</td>
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
				<input class="btnsearch" type="button" value="Regresar a Lista" onclick="window.location='<?=base_url()?>index.php/tecnicos';">
				<input class="btnsearch" type="submit" value="<?=(@$data? 'Guardar' : 'Crear')?>">
			</div>
		</div>
	</div>
</body>
</html>