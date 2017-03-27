			</div>
			<script src="<?=base_url()?>js/departamentos.js"></script>

			<div class="list-mod-panel">
				<h1 style="float: left;">Editar Servicio</h1>
				<h2><a href="<?=base_url()?>index.php/supervisores/lista">Regresar a servicios</a></h2>
			</div>
			<br>
			
<?php 
echo form_open_multipart('servicios/update/'.$servicios[0]->id);		
?>

			<table class="table table-bordered table-striped">
				<tr>
					<td>Servicio : </td>
					<td>
					<input type="hidden" name="id" value="<?=@$servicios[0]->id ?>"></input>
					<input title="Solo Letras" type="text" required maxlength="30" autofocus="autofocus" name="descripcion" value="<?=@$servicios[0]->descripcion?>"></td>
				</tr>
				<tr>
				<td>Categoria</td>
				<td>
					<select id="sel_categoria" name="categoria" placeholder="categoria">
					<option>Categoria</option>
					<?php $sel=null;?>
					<?php foreach($categorias as $key=>$row){
					if ($cat==$row->id)
						$sel="selected";
					else
						$sel="";
										 ?>
					<option <?php echo $sel; ?> value="<?php echo trim($row->id) ?>">
					<?php echo trim($row->nombre) ?>
					</option>
										<?php } ?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Motivo : </td><td><input title="Solo Letras" type="text" maxlength="30" name="motivos" value="<?=@$servicios[0]->motivos?>"></td>
				</tr>
				<tr>
					<td>Foto : </td><td><input class="solo-numero" title="Sólo 2 Dígitos" pattern=".{2}" type="number" required name="fotos" value="<?=@$servicios[0]->fotos?>"></td>
				</tr>
				
			</table>
			<div class="divbuttons">
				<input class="btnsearch" type="button" value="Regresar a Lista" onclick="window.location='<?=base_url()?>index.php/servicios';">
				<input class="btnsearch" type="submit" value="Actualizar">
			</div>
		</div>
	</div>
</body>
</html>