			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<h1> Registro Fotográfico </h1><br>
			<fieldset class="search">
				<legend></legend>
				<form id="form" method="post" action="<?=base_url()?>index.php/solicitudes/listarf/<?=@$estadorf?>">
					<nav class="top_menu">
						<ul>
							<li <?=(@$estadorf==0)?'class="active"':''?>><a href="<?=base_url()?>index.php/solicitudes/listarf/0">Todos (<?=$cantidades[0]?>)&nbsp;&nbsp;|</a></li>
							<?php foreach ( $estados as $id => $estado ) { ?>
							<li <?=(@$estadorf==$id)?'class="active"':''?>><a href="<?=base_url()?>index.php/solicitudes/listarf/<?=$id?>"><?=$estado?> (<?=isset($cantidades[$id]) ? $cantidades[$id] : 0?>)&nbsp;&nbsp;|</a></li>
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
					Supervisor:
					<select name="supervisorid">
						<option value="0">-Seleccione-</option>
						<?php foreach ($supervisores as $id => $supervisor) { ?>
						<option <?=(@$supervisorid==$id ? 'selected' : '')?> value=<?=$id?>><?=$supervisor?></option>
						<?php } ?>
					</select>
					<input type="submit" class="btnsearch" value="Buscar"/>
				</form>
			</fieldset>
			<table class="table tablep table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>N° SOT</span></th>
						<th scope="col"><span>TIPO DE SERVICIO</span></th>
						<th scope="col"><span>NOMBRE DEL CLIENTE</span></th>
						<th scope="col"><span>DISTRITO - DPTO</span></th>
						<th scope="col"><span>ESTADO DE LA FOTO</span></th>
						<th scope="col"><span>TÉCNICO 1</span></th>
						<th scope="col"><span>N° FOTOS</span></th>
						<th scope="col"><span>EDITAR</span></th>
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
					<td><strong><?=$row->rfnombre?></strong></td>
					<td><strong><?=$row->tnombres?></strong></td>
					<td><strong>1</strong></td>
					<td><a title="Editar Solicitud"  href="<?=base_url()?>index.php/solicitudes/formrf/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>