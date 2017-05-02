			</div>
			<script src="<?=base_url()?>js/reportes.js"></script>
			<script src="<?=base_url()?>js/exportar.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Reportes / Solicitudes &nbsp;&nbsp;</h1>
				<a href="#" id="exportar"><img style="width: 25px;height: 25px;" src="/img/excel.png"></a>	
			</div>
			<br><br><br><hr>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/reportes/solicitudes">
					<h3>Seleccionar rango de fechas:</h3><br>
					Desde : <input type="date" name="desde" id="desde" value="<?=$desde?>">
					Hasta : <input type="date" name="hasta" id="hasta" value="<?=$hasta?>">
					<br>
					<input type="hidden" id="url" value="<?=base_url()?>index.php/solicitudes"/>
					Jefe :
					<select id="rjefeid" name="jefeid">
						<option value="0">-Seleccione-</option>
						<?php foreach ($jefes as $id => $jefe) { ?>
						<option <?=(@$jefeid==$id ? 'selected' : '')?> value=<?=$id?>><?=$jefe?></option>
						<?php } ?>
					</select>
					<input type="submit" class="btnsearch" value="Filtrar"/>
				</form>
			</fieldset>
			<br>
			<table id="tbl_exportar" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>FECHA</span></th>
						<th scope="col"><span>SOT</span></th>
						<th scope="col"><span>Tipo_Servicio</span></th>
						<th scope="col"><span>Tipo_Trabajo</span></th>
						<th scope="col"><span>Cliente</span></th>
						<th scope="col"><span>Direccion</span></th>
						<th scope="col"><span>Plano</span></th>
						<th scope="col"><span>Estado_SOT</span></th>
						<th scope="col"><span>Analista SOP</span></th>
						<th scope="col"><span>Estado_Foto</span></th>
						<th scope="col"><span>Técnico 1</span></th>
						<th scope="col"><span>Técnico 2</span></th>
						<th scope="col"><span>Supervisor</span></th>
						<th scope="col"><span>Jefatura</span></th>
					</tr>
				</thead>
				<?php if ( isset($data) && count($data) ) { ?>
				<tbody>
				<?php foreach ( $data as $jefes ) { ?>
				<?php foreach ( $jefes as $row ) { ?>
				<tr id="jefetr">
					<td><strong><?=$row->fecha_instalacion?></strong></td>
					<td><strong><?=$sid?></strong></td>
				</tr>
				<?php } ?>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>