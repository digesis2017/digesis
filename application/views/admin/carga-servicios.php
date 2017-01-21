			<script type="text/javascript">
				
		$(document).ready(function(){
    		$('#myTable').DataTable( {
		        "language": {
        		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        		}
    		});
		});

			</script>
			</div>
			<h2>Cargar Servicios</h2><br>						
			<form method="post" enctype="multipart/form-data">
			 <div class="form-group">
				<label for="exampleInputFile"></label>
				<input type="file" name="file" id="exampleInputFile">
				<p class="help-block">Seleccione un archivo csv.</p>
				</div>					
			<input class="btn" style="margin: 0px;" name="carga" type="submit" value="Cargar" />
			<br><br>
			<?php if ( @$error ) echo $error; ?>
			</form>					
			<hr style="border: 1px blue solid">			
			<br>
			<table class="table table-striped table-bordered" id="myTable">
				<thead>
				<tr>
					<th scope="col"><span>N°</span></th>			
					<th scope="col"><span>Servicio a ejecutar</span></th>
					<th scope="col"><span>Categoria</span></th>
					<th scope="col"><span>Motivos de solucion</span></th>
					<th scope="col"><span>Fotos</span></th>
				</tr>
				</thead>
				<?php if ( @$servicios ) { ?>
				<tbody>
				<?php foreach (@$servicios as $i => $row ) { ?>
				<tr>
					<td><strong><?=$row->id ?></strong></td>
					<td><strong><?=$row->descripcion ?></strong></td>
					<td><strong><?=$row->categoria ?></strong></td>
					<td><strong><?=$row->motivos ?></strong></td>
					<td><strong><?=$row->fotos ?></strong></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>