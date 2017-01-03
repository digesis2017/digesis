			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Reportes / Eficiencia &nbsp;&nbsp;</h1>
			</div>
			<br><br><br><hr>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/reportes/encuestas">
					<h3>Seleccionar rango de fechas:</h3><br>
					De : <input type="date" name="desde">
					Hasta : <input type="date" name="hasta">
					<br>
					<input type="hidden" id="url" value="<?=base_url()?>index.php/solicitudes"/>
					Jefe :
					<select id="rjefeid">
						<option value="0">-Seleccione-</option>
						<?php foreach ($jefes as $id => $jefe) { ?>
						<option <?=(@$jefeid==$id ? 'selected' : '')?> value=<?=$id?>><?=$jefe?></option>
						<?php } ?>
					</select>
					Supervisor :
					<select id="rsupervisorid" name="supervisorid">
						<?php if ( @$supervisorid ) { ?>
						<?php foreach ($supervisores as $id => $supervisor) { ?>
						<option <?=(@$supervisorid==$id ? 'selected' : '')?> value=<?=$id?>><?=$supervisor?></option>
						<?php } ?>
						<?php } ?>
					</select>
					Técnico :
					<select name="tecnicoid" id="rtecnicoid">
						<?php if ( @$tecnicoid ) { ?>
						<?php foreach ($tecnicos as $id => $tecnico) { ?>
						<option <?=(@$tecnicoid==$id ? 'selected' : '')?> value=<?=$id?>><?=$tecnico?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<input type="submit" class="btnsearch" value="Filtrar"/>
				</form>
			</fieldset>
			<br>
			<table class="table table-bordered table-striped">
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
				<tr>
					<td><strong><?=$jefes[$jefeid]?></strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong><?=isset($data_j['promedio'])?$data_j['promedio']:'-'?></strong></td>
					<td><a title="Ver Detalle" href="<?=base_url()?>index.php/reportes/jefe_encuestas/<?=$jefeid?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
					<?php if ( isset($data_j['supervisores']) && count($data_j['supervisores']) ) { ?>
					<?php foreach ( $data_j['supervisores'] as $supid => $data_s ) { ?>
					<tr>
						<td><strong>-</strong></td>
						<td><strong><?=$supervisores[$supid]?></strong></td>
						<td><strong>-</strong></td>
						<td><strong><?=isset($data_s['promedio'])?$data_s['promedio']:'-'?></strong></td>
						<td><a title="Ver Detalle" href="<?=base_url()?>index.php/reportes/supervisor_encuestas/<?=$supid?>"><img src="<?=base_url()?>img/editar.png"></a></td>
					</tr>
					<?php } ?>
						<?php if ( isset($data_s['tecnicos']) && count($data_s['tecnicos']) ) { ?>
						<?php foreach ( $data_s['tecnicos'] as $tid => $data_t ) { ?>
						<tr>
							<td><strong>-</strong></td>
							<td><strong>-</strong></td>
							<td><strong><?=$tecnicos[$tid]?></strong></td>
							<td><strong><?=isset($data_t['promedio'])?$data_t['promedio']:'-'?></strong></td>
							<td><a title="Ver Detalle" href="<?=base_url()?>index.php/reportes/tecnico_encuestas/<?=$tid?>"><img src="<?=base_url()?>img/editar.png"></a></td>
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