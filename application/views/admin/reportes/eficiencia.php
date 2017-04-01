			</div>
			<script src="<?=base_url()?>js/reportes.js"></script>
			<script src="<?=base_url()?>js/exportar.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Reportes / Eficiencia &nbsp;&nbsp;</h1>
				<a href="#" id="exportar"><img style="width: 25px;height: 25px;" src="/img/excel.png"></a>	
			</div>
			<br><br><br><hr>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/reportes/eficiencia<?=isset($_GET['test'])?'?test=true':''?>">
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
						<th scope="col"><span>Prog.</span></th>
						<th scope="col"><span>Adic.</span></th>
						<th scope="col"><span>Total P.</span></th>
						<th scope="col"><span>Rech.</span></th>
						<th scope="col"><span>Reprog.</span></th>
						<th scope="col"><span>Pend.</span></th>
						<th scope="col"><span>Valid.</span></th>
						<th scope="col"><span>Sin E.</span></th>
						<th scope="col"><span>%</span></th>
					</tr>
				</thead>
				<?php if ( isset($data) && count($data) ) { ?>
				<tbody>
				<?php foreach ( $data as $jefeid => $data_j ) { ?>
				<tr id="jefetr">
					<td><strong><?=$jefes[$jefeid]?></strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong><?=$data_j['totalprogramadas']?></strong></td>
					<td><strong><?=$data_j['totaladicionales']?></strong></td>
					<td><strong><?=$data_j['totalsolicitudes']?></strong></td>
					<td><strong><?=$data_j['totalrechazados']?></strong></td>
					<td><strong><?=$data_j['totalreprogramados']?></strong></td>
					<td><strong><?=$data_j['totalpendientes']?></strong></td>
					<td><strong><?=$data_j['totalvalidados']?></strong></td>
					<td><strong><?=$data_j['totalsinestado']?></strong></td>
					<td><strong><?=$data_j['porcentaje'].'%'?></strong></td>
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
							<td><strong><?=$data_s['programadas']?></strong></td>
							<td><strong><?=$data_s['adicionales']?></strong></td>
							<td><strong><?=$data_s['totalsolicitudes']?></strong></td>
							<td><strong><?=$data_s['rechazados']?></strong></td>
							<td><strong><?=$data_s['reprogramados']?></strong></td>
							<td><strong><?=$data_s['pendientes']?></strong></td>
							<td><strong><?=$data_s['validados']?></strong></td>
							<td><strong><?=$data_s['sinestado']?></strong></td>
							<td><strong><?=$data_s['porcentaje'].'%'?></strong></td>
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