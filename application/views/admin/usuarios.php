			</div>

			<script>
				/*function cambiarRol() {
					$( "#roles" ).submit();
				}*/
			</script>
			<div class="list-mod-panel">
				<h1 style="float: left;"> Lista de Usuarios &nbsp;&nbsp;</h1>
				<h2><a href="<?=base_url()?>index.php/usuarios/form">Crear Usuario</a></h2>
			</div>
			<br>
			<fieldset class="search">
				<legend></legend>
				<nav class="top_menu">
					<ul>
						<li <?=(@$rolid==0)?'class="active"':''?>><a href="<?=base_url()?>index.php/usuarios/lista/0">Todos (<?=$cantidades[0]?>)&nbsp;&nbsp;|</a></li>
						<?php foreach ( $roles as $key => $rol ) { ?>
						<li <?=(@$rolid==$rol->id)?'class="active"':''?>><a href="<?=base_url()?>index.php/usuarios/lista/<?=$rol->id?>"><?=$rol->nombre?> (<?=isset($cantidades[$rol->id]) ? $cantidades[$rol->id] : 0?>)&nbsp;&nbsp;|</a></li>
						<?php } ?>
					</ul>
				</nav>
				<form id="roles" method="post" action="<?=base_url()?>index.php/usuarios/lista/<?=@$rolid?>">
					Nombres: <input type="text" name="bnombres" value="<?=@$bnombres?>"/>
					<input class="btnsearch" value="Filtrar" type="submit"/>
				</form>
			</fieldset>
			<br>
			<table class="table tablep table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>NOMBRES</span></th>
						<th scope="col"><span>USUARIO</span></th>
						<th scope="col"><span>DNI</span></th>
						<th scope="col"><span>CORREO</span></th>
						<th scope="col"><span>ROL</span></th>
						<th scope="col"><span>ESTADO</span></th>
						<th scope="col"><span>EDITAR</span></th>
					</tr>
				</thead>
				<?php if ( @$data ) { ?>
				<tbody>
				<?php foreach ( $data as $row ) { ?>
				<tr>
					<td><strong><?=$row->nombres . ' ' . $row->apellidos?></strong></td>
					<td><strong><?=$row->user?></strong></td>
					<td><strong><?=$row->dni?></strong></td>
					<td><strong><?=$row->email?></strong></td>
					<td><strong><?=$row->nombre?></strong></td>
					<td><b><?=($row->publish)?'Activo':'Inactivo'?></b></td>
					<td><a title="Editar Usuario"  href="<?=base_url()?>index.php/usuarios/form/<?=$row->id?>"><img src="<?=base_url()?>img/editar.png"></a><!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Usuario Inactiva" onclick="return confirm('¿Usuario Inactivo?');" href="<?=base_url()?>index.php/usuarios/delete/<?=$row->id?>"><img src="<?=base_url()?>img/deactivate.png"></a>--></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>