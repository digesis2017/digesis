			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<?php $data = @$data[0]; ?>
			<div class="list-mod-panel">
				<h1>
					<?php if ( @$disabled )
						echo 'Tu Usuario';
						else if ( @$data->id )
							echo 'Editar Usuario';
						else
							echo 'Crear Usuario';
					?>
				</h1>
			</div>

			<?php if ( @$data ) {
				if ( @$disabled )
					echo form_open_multipart('usuarios/edit/' . $data->id . '/true', array('id' => 'tusuarioform'));
				else
					echo form_open_multipart('usuarios/edit/' . $data->id, array('id' => 'tusuarioform'));
			}
			else
				echo form_open_multipart('usuarios/add');
			?>

			<table class="table table-bordered table-striped">
				<tr>
					<td>Rol : </td>
					<td>
						<select <?=(@$disabled?'disabled':'')?> name="rolid">
							<?php foreach ( $roles as $key => $rol ) { ?>
								<option <?=(@$data->rolid==$rol->id ? 'selected' : '')?>  value="<?=$rol->id?>"><?=$rol->nombre?></option>
							<?php } ?>
						</select>
						<?php if ( @$disabled ) { ?>
							<input type="hidden" name="rolid" value="<?=$data->rolid?>"/>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td>Nombre de Usuario : </td><td><input <?=(@$data->id)?'disabled':''?> title="Entre 4 a 20 Letras" pattern=".{4,20}" autofocus="autofocus" required type="text" name="user" value="<?=@$data->user?>"></td>
					<?php if ( @$disabled ) { ?>
						<input type="hidden" name="user" value="<?=$data->user?>"/>
					<?php } ?>
				</tr>
				<tr>
					<td>Contraseña : </td><td><input type="password" title="Entre 4 a 20 Letras" pattern=".{4,20}" name="password" required value="<?=@$data->password?>"></td>
				</tr>
				<tr>
					<td>Nombres : </td><td><input pattern="[/\s/ÑñA-Za-z]{1,30}" title="Solo Letras" required type="text" maxlength="30" name="nombres" value="<?=@$data->nombres?>"></td>
				</tr>
				<tr>
					<td>Apellidos : </td><td><input pattern="[/\s/ÑñA-Za-z]{1,30}" title="Solo Letras" required type="text" maxlength="30" name="apellidos" value="<?=@$data->apellidos?>"></td>
				</tr>
				<tr>
					<td>DNI : </td><td><input required type="text" class="solo-numero" title="Sólo 8 Dígitos" pattern=".{8}" name="dni" value="<?=@$data->dni?>"></td>
				</tr>
				<tr>
					<td>Correo : </td><td><input required size="40" maxlength="40" type="email" name="email" value="<?=@$data->email?>"></td>
				</tr>
				<?php if ( @$data->id ) { ?>
				<tr>
					<td>Estado : </td>
					<td>
						<select id="publish" <?=(@$disabled?'disabled':'')?> name="publish">
							<option <?=($data->publish)?'selected':''?> value="1">Activo</option>
							<option <?=(!$data->publish)?'selected':''?> value="0">Inactivo</option>
						</select>
						<?php if ( @$disabled ) { ?>
							<input type="hidden" name="publish" value="<?=$data->publish?>"/>
						<?php } ?>
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
				<input class="btnsearch" type="submit" value="<?=(@$data? 'Guardar' : 'Crear')?>">
			</div>
		</div>
	</div>
</body>
</html>