			</div>
			<script src="<?=base_url()?>js/reportes.js"></script>
			<script src="<?=base_url()?>js/exportar.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Reportes / Producción &nbsp;&nbsp;</h1>
				<a href="#" id="exportar"><img style="width: 25px;height: 25px;" src="/img/excel.png"></a>	
			</div>
			<br><br><br><hr>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/reportes/produccion">
					<h3>Seleccionar rango de fechas:</h3><br>
					De : <input type="date" name="desde" value="<?=$desde?>">
					Hasta : <input type="date" name="hasta" value="<?=$hasta?>">
					<br>
					<input type="hidden" id="url" value="<?=base_url()?>index.php/solicitudes"/>
					Jefe :
					<select id="rjefeid" name="jefeid">
						<option value="0">-Seleccione-</option>
						<?php foreach ($jefes as $id => $jefe) { ?>
						<option <?=(@$jefeid==$id ? 'selected' : '')?> value=<?=$id?>><?=$jefe?></option>
						<?php } ?>
					</select>
					Base :
					<select name="baseid">
						<option value="0">-Seleccione-</option>
						<?php foreach ($bases as $id => $base) { ?>
						<option <?=(@$baseid==$id ? 'selected' : '')?> value=<?=$id?>><?=$base?></option>
						<?php } ?>
					</select>
					Supervisor :
					<select id="rsupervisorid" name="supervisorid">
						<?php if ( $jefeid ) { ?>
						<option value="0">-Seleccione-</option>
						<?php foreach ($supervisores as $id => $supervisor) { ?>
						<option <?=(@$supervisorid==$id ? 'selected' : '')?> value=<?=$id?>><?=$supervisor?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<input type="submit" class="btnsearch" value="Filtrar"/>
				</form>
			</fieldset>
			<br>
			<table id="tbl_exportar" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>JEFE</span></th>
						<th scope="col"><span>BASE</span></th>
						<th scope="col"><span>SUPERVISOR</span></th>
						<th scope="col"><span># de Cuadrillas</span></th>
						<th scope="col"><span># de SOT Val.</span></th>
						<th scope="col"><span>Producción Promedio</span></th>
						<th scope="col"><span>Observaciones</span></th>
					</tr>
				</thead>
				<?php if ( isset($data) && count($data) ) { ?>
				<tbody>
				<?php foreach ( $data as $jefeid => $data_j ) { ?>
				<tr id="jefetr">
					<td><strong><?=$jefes[$jefeid]?></strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong><?=$data_j['totalcuadrillas']?></strong></td>
					<td><strong><?=$data_j['totalvalidados']?></strong></td>
					<td><strong><?=$data_j['totalvalidados']/$data_j['totalcuadrillas']?></strong></td>
					<td><strong>-</strong></td>
				</tr>
					<?php if ( isset($data_j['bases']) && count($data_j['bases']) ) { ?>
					<?php foreach ( $data_j['bases'] as $baseid => $data_b ) { ?>
					<tr>
						<td><strong>-</strong></td>
						<td><strong><?=$bases[$baseid]?></strong></td>
						<td><strong>-</strong></td>
						<td><strong>-</strong></td>
						<td><strong>-</strong></td>
						<td><strong>-</strong></td>
						<td><strong>-</strong></td>
					</tr>
						<?php if ( isset($data_b) && count($data_b) ) { ?>
						<?php foreach ( $data_b as $supid => $data_s ) { ?>
						<tr>
							<td><strong>-</strong></td>
							<td><strong>-</strong></td>
							<td><strong><?=$supervisores[$supid]?></strong></td>
							<td><strong><?=$data_s['totalcuadrillas']?></strong></td>
							<?php $validados = isset($data_s['totalvalidados']) ? $data_s['totalvalidados'] : 0; ?>
							<td><strong><?=$validados?></strong></td>
							<td><strong><?=$validados/$data_s['totalcuadrillas']?></strong></td>
							<td><strong>-</strong></td>
						</tr>
						<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php } ?>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>