			</div>

			<script>
				/*function cambiarPerfil() {
					var url = $("#url").val() + $("#perfilid").val() + '/lista';
					window.location.href = url;
				}*/
			</script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Lista de Perfiles &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/jefes/form">Crear Jefe</a></h2>
				<h2><a href="<?=base_url()?>index.php/supervisores/form">Crear Supervisor</a></h2>
				<h2><a href="<?=base_url()?>index.php/tecnicos/form">Crear Técnico</a></h2>
			</div>
			<br>
			<fieldset class="search">
				<legend></legend>
				<form id="perfiles" method="post" action="<?=base_url()?>index.php/perfiles/lista">
					<nav class="top_menu">
						<ul>
							<li class="active"><a href="<?=base_url()?>index.php/perfiles">Todos (<?=$cantidades['total']?>)&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/jefes/lista">Jefes (<?=$cantidades['jefes']?>)&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/supervisores/lista">Supervisores (<?=$cantidades['supervisores']?>)&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/tecnicos/lista">Técnicos (<?=$cantidades['tecnicos']?>)</a></li>
						</ul>
					</nav>
					Nombres: <input type="text" name="bnombres" value="<?=@$bnombres?>"/>
					<input type="submit" class="btnsearch" value="Filtrar"/>
				</form>
			</fieldset>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>NOMBRES</span></th>
						<th scope="col"><span>USUARIO</span></th>
						<th scope="col"><span>CORREO</span></th>
						<th scope="col"><span>DNI</span></th>
						<th scope="col"><span>PERFIL</span></th>
						<th scope="col"><span>ESTADO</span></th>
						<th scope="col"><span>EDITAR</span></th>
					</tr>
				</thead>
				<?php if ( count(@$data['tecnicos']) || count(@$data['supervisores']) || count(@$data['jefes']) ) { ?>
				<tbody>
				<?php if ( count(@$data['tecnicos']) ) { ?>
				<?php foreach ( $data['tecnicos'] as $key => $row ) { ?>
				<tr>
					<td><strong><?=$row->nombres . ' ' . $row->apellidos?></strong></td>
					<td><strong><?=$row->dni?></strong></td>
					<td><strong><?=$row->email?></strong></td>
					<td><strong><?=$row->dni?></strong></td>
					<td><strong>Técnico</strong></td>
					<td><strong><?=($row->publish)?'Activo':'Inactivo'?></strong></td>
					<td><a title="Editar Técnico" href="<?=base_url()?>index.php/tecnicos/form/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
				<?php } ?>
				<?php } ?>
				<?php if ( count(@$data['supervisores']) ) { ?>
				<?php foreach ( $data['supervisores'] as $key => $row ) { ?>
				<tr style="color: blue">
					<td><strong><?=$row->nombres . ' ' . $row->apellidos?></strong></td>
					<td><strong><?=$row->user?></strong></td>
					<td><strong><?=$row->email?></strong></td>
					<td><strong><?=$row->dni?></strong></td>
					<td><strong>Supervisor</strong></td>
					<td><strong><?=($row->publish)?'Activo':'Inactivo'?></strong></td>
					<td><a title="Editar Supervisor" href="<?=base_url()?>index.php/supervisores/form/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a></td>
				</tr>
				<?php } ?>
				<?php } ?>
				<?php if ( count(@$data['jefes']) ) { ?>
				<?php foreach ( $data['jefes'] as $key => $row ) { ?>
				<tr style="color: green">
					<td><strong><?=$row->nombres . ' ' . $row->apellidos?></strong></td>
					<td><strong><?=$row->user?></strong></td>
					<td><strong><?=$row->email?></strong></td>
					<td><strong><?=$row->dni?></strong></td>
					<td><strong>Jefe</strong></td>
					<td><strong><?=($row->publish)?'Activo':'Inactivo'?></strong></td>
					<td><a title="Editar Jefe" href="<?=base_url()?>index.php/jefes/form/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a></td>
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