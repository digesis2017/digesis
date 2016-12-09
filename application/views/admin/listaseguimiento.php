			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<h1> Soporte de Servicio </h1><br>
			<fieldset class="search">
				<legend></legend>
				<form id="perfiles" method="post" action="<?=base_url()?>index.php/solicitudes/seguimiento">
					<nav class="top_menu">
						<ul>
							<li><a href="<?=base_url()?>index.php/solicitudes/listatecnicos">Pendiente de Asignar&nbsp;&nbsp;|</a></li>
							<li class="active"><a href="<?=base_url()?>index.php/solicitudes/seguimiento">Seguimiento&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/solicitudes/listavalidados">Incidencias&nbsp;&nbsp;|</a></li>
						</ul>
					</nav>
					Técnico 1: <select name="tecnicoid">
						<option value="0">-Seleccione-</option>
						<?php foreach ( $tecnicos1 as $key => $tecnico1 ) { ?>
						<option <?=($tecnicoid==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$tecnico1?></option>
						<?php } ?>
					</select>
					N° SOT: <input type="text" size="10" name="solicitudid" value="<?=@$solicitudid?>"/>
					<input type="submit" class="btnsearch" value="Filtrar"/>
				</form>
			</fieldset>

			<?php foreach ( $data as $key => $row ) { ?>
			<?php if ( isset($tecnicos1[$row->t1id]) && isset($tecnicos2[$row->t2id]) && count($row->solicitudes) ) { ?>
				<div class="divseg">
				<table class="table tableseg table-bordered table-striped">
					<thead> 	
						<tr>
							<th scope="col"><span><?=$tecnicos1[$row->t1id]?></span></th>
							<th scope="col"><span><?=$tecnicos2[$row->t2id]?></span></th>
						</tr>
					</thead>
				</table>
				<table class="table tableseg table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>N° SOT</span></th>
						<th scope="col"><span>TIPO DE SERVICIO</span></th>
						<th scope="col"><span>NOMBRE DEL CLIENTE</span></th>
						<th scope="col"><span>ESTADO</span></th>
					</tr>
				</thead>
				<?php foreach ( $row->solicitudes as $key => $sid ) { ?>
				<tr>
					<td><strong><?=$sid->id?></strong></td>
					<td><strong><?=$sid->tsnombre?></strong></td>
					<td><strong><?=$sid->cliente?></strong></td>
					<td><strong><?=$sid->enombre?></strong></td>
				</tr>
				<?php } ?>
				</table>
				</div>
				<br>
			<?php } ?>
			<?php } ?>
		</div>
	</div>
</body>
</html>