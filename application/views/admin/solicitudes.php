			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Lista de Solicitudes &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/solicitudes/form/add">Añadir Solicitud</a></h2>
			</div>
			<br>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/solicitudes/lista/<?=@$estadoid?>">
					<nav class="top_menu">
						<ul>
							<li <?=(@$estadoid==0)?'class="active"':''?>><a href="<?=base_url()?>index.php/solicitudes/lista/0">Todos (<?=$cantidades[0]?>) &nbsp;&nbsp;|</a></li>
							<?php foreach ( $estados as $id => $estado ) { ?>
							<li <?=(@$estadoid==$id)?'class="active"':''?>><a href="<?=base_url()?>index.php/solicitudes/lista/<?=$id?>"><?=$estado?> (<?=isset($cantidades[$id]) ? $cantidades[$id] : 0?>) &nbsp;&nbsp;|</a></li>
							<?php } ?>
						</ul>
					</nav>

					<input type="hidden" id="url" value="<?=base_url()?>index.php/solicitudes"/>
					Departamento :
					<select id="dptoid">
						<option value="0">-Seleccione-</option>
						<?php foreach ($departamentos as $id => $departamento) { ?>
						<option <?=(@$departamentoid==$id ? 'selected' : '')?> value=<?=$id?>><?=$departamento?></option>
						<?php } ?>
					</select>
					Provincia
					<select id="provinciaid" name="provinciaid">
						<?php if ( @$distritoid ) { ?>
						<?php foreach ($provincias as $id => $provincia) { ?>
						<option <?=(@$provinciaid==$id ? 'selected' : '')?> value=<?=$id?>><?=$provincia?></option>
						<?php } ?>
						<?php } ?>
					</select>
					Distrito:
					<select name="distritoid" id="distritoid">
						<?php if ( @$distritoid ) { ?>
						<?php foreach ($distritos as $id => $distrito) { ?>
						<option <?=(@$distritoid==$id ? 'selected' : '')?> value=<?=$id?>><?=$distrito?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<input type="submit" class="btnsearch" value="Filtrar"/>
					<br>
					N° SOT: <input type="text" size="10" name="solicitudid" value="<?=@$solicitudid?>"/>
					<input type="submit" class="btnsearch" value="Buscar"/>
					
				</form>
			</fieldset>
			<br>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>						
						<th scope="col"><span>N° SOT</span></th>
						<th scope="col"><span>TIPO DE SERVICIO</span></th>
						<th scope="col"><span>NOMBRE DEL CLIENTE</span></th>
						<th scope="col"><span>DISTRITO - DPTO</span></th>
						<th scope="col"><span>PLANO</span></th>
						<th scope="col"><span>ESTADO</span></th>
						<th scope="col"><span>DETALLE</span></th>
					</tr>
				</thead>
				<?php if ( @$data ) { ?>
				<tbody>
				<?php foreach ( $data as $row ) { ?>
				<tr>					
					<td><strong><?=$row->id?></strong></td>
					<td><strong><?=$row->tsnombre?></strong></td>
					<td><strong><?=$row->cliente?></strong></td>
					<td><strong><?=$row->distrito . ' - ' . $row->dpto?></strong></td>
					<td><strong><?=$row->plano?></strong></td>
					<td><strong><?=$row->enombre?></strong></td>
					<td><a title="Ver Detalle" href="<?=base_url()?>index.php/solicitudes/form/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>