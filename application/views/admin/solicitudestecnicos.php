			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>
			<script src="<?=base_url()?>js/portamento-min.js"></script>
			<script type="text/javascript">
			$(function() {	
				$('#btn_asignacion').portamento({gap: 250});
			});
			</script>
			<style type="text/css">
				#portamento_container {
					float:right;
					position:relative;
				}
				#portamento_container #btn_asignacion {
					float:none;
					position:absolute;
				}
				#portamento_container #btn_asignacion.fixed {
					position:fixed;
				}
			</style>

			<h1> Soporte de Servicio</h1><br>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/solicitudes/listatecnicos">
					<nav class="top_menu">
						<ul>
							<li class="active"><a href="<?=base_url()?>index.php/solicitudes/listatecnicos">Pendiente de Asignar (<?=count($data['programadas']) + count($data['pendientes'])?>)&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/solicitudes/seguimiento">Seguimiento&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/solicitudes/listavalidados">Incidencias&nbsp;&nbsp;|</a></li>
						</ul>
					</nav>

					<table>
						<tr>
							<td>Departamento </td>
							<td>Provincia </td>
							<td>Distrito</td>
							<td></td>
						</tr>
						<tr>
							<td>
								<select id="dptoid" style="width: 200px">
						<option value="0">-Seleccione-</option>
						<?php foreach ($departamentos as $id => $departamento) { ?>
						<option <?=(@$departamentoid==$id ? 'selected' : '')?> value=<?=$id?>><?=$departamento?></option>
						<?php } ?>
					</select>
							</td>
							<td>
								<select id="provinciaid" name="provinciaid" style="width: 200px">
						<?php if ( @$distritoid ) { ?>
						<?php foreach ($provincias as $id => $provincia) { ?>
						<option <?=(@$provinciaid==$id ? 'selected' : '')?> value=<?=$id?>><?=$provincia?></option>
						<?php } ?>
						<?php } ?>
					</select>
							</td>
							<td>
						<select name="distritoid" id="distritoid" style="width: 200px">
						<?php if ( @$distritoid ) { ?>
						<?php foreach ($distritos as $id => $distrito) { ?>
						<option <?=(@$distritoid==$id ? 'selected' : '')?> value=<?=$id?>><?=$distrito?></option>
						<?php } ?>
						<?php } ?>
					</select>
							</td>
						<td><input type="submit" class="btnsearch" value="Filtrar"/></td>	
						</tr>
						<tr>
							<td>N° SOT</td>
						</tr>
						<tr>
							<td><input type="text" size="10" name="solicitudid" value="<?=@$solicitudid?>"/>
								<input type="submit" class="btnsearch" value="Buscar"/>
							</td>
							<td></td>
						</tr>
					</table>	

					<input type="hidden" id="url" value="<?=base_url()?>index.php/solicitudes"/>												
			</form>
			</fieldset>								
		<div id="central">
			<div id="btn_asignacion">
		<input type="button" id="mult-asignacion" class="circle" value="Asignar a:"/>	
		</div>							
			<table class="table table-bordered table-striped" style="width:90%;max-width:90%">
				<thead>
					<tr>
				<th scope="col" width="5%"><span>Sel</span>
					<input type="checkbox" class="checkall" id="select_all"/>
				</th>
						<th scope="col" width="8%"><span>N° SOT</span></th>
						<th scope="col" width="10%"><span>TIPO DE SERVICIO</span></th>
						<th scope="col" width="30%"><span>NOMBRE DEL CLIENTE</span></th>
						<th scope="col" width="30%"><span>DISTRITO - DPTO</span></th>
						<th scope="col" width="20%"><span>FECHA PROGRAMACIÓN</span></th>
						<th scope="col" width="10%"><span>ASIGNAR</span></th>
					</tr>
				</thead>
				<?php if ( count($data['pendientes']) || count($data['programadas']) ) { ?>
				<tbody>
				<?php if ( count($data['programadas']) ) { ?>
				<?php foreach ( $data['programadas'] as $row ) { ?>
				<tr style="color: green;">
					<td><strong><input type="checkbox" name="sot[]" value="<?=$row->id?>"></strong></td>
					<td><strong><?=$row->id?></strong></td>
					<td><strong><?=$row->tsnombre?></strong></td>
					<td><strong><?=$row->cliente?></strong></td>
					<td><strong><?=$row->distrito . ' - ' . $row->dpto?></strong></td>
					<td><strong><?=date('d-m-Y', $row->fecha_instalacion)?></strong></td>
					<td><a title="Asignar Técnico" href="<?=base_url()?>index.php/solicitudes/formtecnicos/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
				<?php } ?>
				<?php } ?>

				<?php if ( count($data['pendientes']) ) { ?>
				<?php foreach ( $data['pendientes'] as $row ) { ?>
				<tr>
					<td><strong><input type="checkbox" name="sot[]" value="<?=$row->id?>"></strong></td>
					<td><strong><?=$row->id?></strong></td>
					<td><strong><?=$row->tsnombre?></strong></td>
					<td><strong><?=$row->cliente?></strong></td>
					<td><strong><?=$row->distrito . ' - ' . $row->dpto?></strong></td>
					<td><strong><?=date('d-m-Y', $row->fecha_instalacion)?></strong></td>
					<td><a title="Asignar Técnico" href="<?=base_url()?>index.php/solicitudes/formtecnicos/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
				<?php } ?>
				<?php } ?>
				</tbody>
				<?php } else { ?>
				</table>
				
				<h2 style="color: blue"> SOLICITUD NO ENCONTRADA </h2>
				<?php } ?>
			</table>
			<div style="clear: both;"></div>
		</div>
		</div>
		</div>
	</div>
</body>
</html>