			</div>
			<div class="list-mod-panel">
				<h1 style="float: left;"> Lista de Técnicos &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/tecnicos/form">Crear Técnico</a></h2>
			</div>
			<br>
			<fieldset class="search">
				<legend></legend>
				<form id="perfiles" method="post" action="<?=base_url()?>index.php/tecnicos/lista">
					<nav class="top_menu">
						<ul>
							<li><a href="<?=base_url()?>index.php/perfiles">Todos (<?=$cantidades['total']?>)&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/jefes/lista">Jefes (<?=$cantidades['jefes']?>)&nbsp;&nbsp;|</a></li>
							<li><a href="<?=base_url()?>index.php/supervisores/lista">Supervisores (<?=$cantidades['supervisores']?>)&nbsp;&nbsp;|</a></li>
							<li class="active"><a href="<?=base_url()?>index.php/tecnicos/lista">Técnicos (<?=$cantidades['tecnicos']?>)</a></li>
						</ul>
					</nav>
					Nombres: <input type="text" name="bnombres" value="<?=@$bnombres?>"/>
					Estado: <select name="bpublish"><option <?=($bpublish==1?'selected':'')?> value="1">Activos</option><option <?=($bpublish==0?'selected':'')?> value="0">Inactivos</option></select>
					<input type="submit" class="btnsearch" value="Filtrar"/>
				</form>
			</fieldset>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>NOMBRES</span></th>
						<th scope="col"><span>RPC</span></th>
						<th scope="col"><span>CORREO</span></th>
						<th scope="col"><span>DNI</span></th>
						<th scope="col"><span>PERFIL</span></th>
						<th scope="col"><span>SUPERVISOR</span></th>
						<th scope="col"><span>BASE</span></th>
						<th scope="col"><span>ESTADO</span></th>
						<th scope="col"><span>EDITAR</span></th>
					</tr>
				</thead>
				<?php if ( @$data ) { ?>
				<tbody>
				<?php foreach ( $data as $row ) { ?>
				<tr>
					<td><strong><?=$row->nombres . ' ' . $row->apellidos?></strong></td>
					<td><strong><?=$row->rpc?></strong></td>
					<td><strong><?=$row->email?></strong></td>
					<td><strong><?=$row->dni?></strong></td>
					<td><strong><?='Técnico ' . $row->cargo?></strong></td>
					<td><strong><?=$row->snombre?></strong></td>
					<td><strong><?=$row->bnombre?></strong></td>
					<td><b><?=($row->publish)?'Activo':'Inactivo'?></b></td>
					<td><a title="Editar Técnico"  href="<?=base_url()?>index.php/tecnicos/form/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a><!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Técnico Inactiva" onclick="return confirm('¿Técnico Inactivo?');" href="<?=base_url()?>index.php/tecnicos/delete/<?=$row->id?>"><img src="<?=base_url()?>img/deactivate.png"></a>--></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>