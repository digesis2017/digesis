			</div>

			<script>
				/*function cambiarPerfil() {
					var url = $("#url").val() + $("#perfilid").val() + '/lista';
					window.location.href = url;
				}*/
			</script>

			<div class="list-mod-panel">
				<h1 style="float: left;"> Lista de Jefes &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/jefes/form">Crear Jefe</a></h2>
			</div>
			<br>
			<fieldset class="search">
				<legend></legend>
				<form id="perfiles" method="post" action="<?=base_url()?>index.php/jefes/lista">
					<nav class="top_menu">
						<ul>
							<li><a href="<?=base_url()?>index.php/perfiles">Todos (<?=$cantidades['total']?>)&nbsp;&nbsp;|</a></li>
							<li class="active"><a href="<?=base_url()?>index.php/jefes/lista">Jefes (<?=$cantidades['jefes']?>)&nbsp;&nbsp;|</a></li>
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
						<th scope="col"><span>USUARIO</span></th>
						<th scope="col"><span>NOMBRES</span></th>
						<th scope="col"><span>CORREO</span></th>
						<th scope="col"><span>DNI</span></th>
						<th scope="col"><span>REGION</span></th>
						<th scope="col"><span>ESTADO</span></th>
						<th scope="col"><span>EDITAR</span></th>
					</tr>
				</thead>
				<?php if ( @$data ) { ?>
				<tbody>
				<?php foreach ( $data as $row ) { ?>
				<tr>
					<td><strong><?=$row->user?></strong></td>
					<td><strong><?=$row->nombres . ' ' . $row->apellidos?></strong></td>
					<td><strong><?=$row->email?></strong></td>
					<td><strong><?=$row->dni?></strong></td>
					<td><strong><?=$row->znombre?></strong></td>
					<td><b><?=($row->publish)?'Activo':'Inactivo'?></b></td>
					<td><a title="Editar Jefe"  href="<?=base_url()?>index.php/jefes/form/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a><!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Jefe Inactivo" onclick="return confirm('Jefe Inactivo?');" href="<?=current_url()?>/delete/<?=$row->id?>"><img src="<?=base_url()?>img/deactivate.png"></a>--></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>