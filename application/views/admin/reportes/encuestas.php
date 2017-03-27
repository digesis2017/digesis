			</div>
			<script src="<?=base_url()?>js/reportes.js"></script>
			<script src="<?=base_url()?>js/exportar.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Reportes / Encuestas &nbsp;&nbsp;</h1>
				<a href="#" id="exportar"><img style="width: 25px;height: 25px;" src="/img/excel.png"></a>	
			</div>
			<br><br><br><hr>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/reportes/encuestas">
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
					Supervisor :
					<select id="rsupervisorid" name="supervisorid">
						<?php if ( $jefeid ) { ?>
						<option value="0">-Seleccione-</option>
						<?php foreach ($supervisores as $id => $supervisor) { ?>
						<option <?=(@$supervisorid==$id ? 'selected' : '')?> value=<?=$id?>><?=$supervisor?></option>
						<?php } ?>
						<?php } ?>
					</select>
					Técnico :
					<select name="tecnicoid" id="rtecnicoid">
						<?php if ( $supervisorid ) { ?>
						<option value="0">-Seleccione-</option>
						<?php foreach ($tecnicos as $id => $tecnico) { ?>
						<option <?=(@$tecnicoid==$id ? 'selected' : '')?> value=<?=$id?>><?=$tecnico?></option>
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
						<th scope="col"><span>SUPERVISORES</span></th>
						<th scope="col"><span>TÉCNICOS</span></th>
						<th scope="col"><span>PROMEDIO</span></th>
						<th scope="col"><span>DETALLE</span></th>
					</tr>
				</thead>
				<?php if ( isset($data) && count($data) ) { ?>
				<tbody>
				<?php foreach ( $data as $jefeid => $data_j ) { ?>
				<tr id="jefetr">
					<td><strong><?=$jefes[$jefeid]?></strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong><?=isset($data_j['promedio'])?$data_j['promedio']:'-'?></strong></td>
					<td><a title="Ver Detalle" href="<?=base_url()?>index.php/reportes/jefe_encuestas/<?=$jefeid?>/<?=$desde?>/<?=$hasta?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
					<?php if ( isset($data_j['supervisores']) && count($data_j['supervisores']) ) { ?>
					<?php foreach ( $data_j['supervisores'] as $supid => $data_s ) { ?>
					<tr>
						<td><strong>-</strong></td>
						<td><strong><?=$data_s['nombres']?></strong></td>
						<td><strong>-</strong></td>
						<td><strong><?=isset($data_s['promedio'])?$data_s['promedio']:'-'?></strong></td>
						<td><a title="Ver Detalle" href="<?=base_url()?>index.php/reportes/supervisor_encuestas/<?=$supid?>/<?=$desde?>/<?=$hasta?>"><img src="<?=base_url()?>img/editar.png"></a></td>
					</tr>
					<?php } ?>
						<?php if ( isset($data_s['tecnicos']) && count($data_s['tecnicos']) ) { ?>
						<?php foreach ( $data_s['tecnicos'] as $tid => $data_t ) { ?>
						<tr>
							<td><strong>-</strong></td>
							<td><strong>-</strong></td>
							<td><strong><?=$data_t['nombres']?></strong></td>
							<td><strong><?=isset($data_t['promedio'])?$data_t['promedio']:'-'?></strong></td>
							<td><a title="Ver Detalle" href="<?=base_url()?>index.php/reportes/tecnico_encuestas/<?=$tid?>/<?=$desde?>/<?=$hasta?>"><img src="<?=base_url()?>img/editar.png"></a></td>
						</tr>
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