			</div>
			<h1>Cargar Solicitudes</h1><br>
			<fieldset class="search">
				<legend></legend>
				<form method="post" enctype="multipart/form-data">
					<div class="upload">
						<input id="fileSelect" name="file" type="file" accept=".csv" />
					</div>
					&nbsp;&nbsp;&nbsp;<input class="btn" style="margin: 0px;" name="carga" type="submit" value="Cargar" />
					<br><br>
					<?php if ( @$error ) echo $error; ?>
				</form>
			</fieldset>
			<br>
			<fieldset class="search">
				<legend><b>Buscar Por:</b></legend>
				<form method="post">
					N° SOT:
					<input type="text" name="bnombres" value="<?=@$bnombres?>" />
					<input type="submit" name="busqueda" class="btnsearch" value="Filtrar"/>
				</form>
			</fieldset>
			<hr>
			<?php
				if ( !@$error && @$_POST['carga'] )
					echo '<em>' . $info->filas . ' Registros Procesados <br>' . $info->add . ' Registros Agregados <br>' . $info->update . ' Registros Actualizados</em><hr>';
			?>

			<h1>Solicitudes Cargadas Desde <?=date('d-m-Y')?></h1>
			<?php
				$this->db->query("DELETE FROM `solicitudes` WHERE id = 2147483647");
				$query = $this->db->query("SELECT sid FROM solicitudestecnicos");
				print_r($query->result());
				//$this->db->query("ALTER TABLE `solicitudestecnicos` CHANGE `sid` `sid` INT(11) NOT NULL;");
				//$this->db->query("DELETE FROM `solicitudestecnicos` WHERE sid = 't75r65'");
			/*$this->db->query("CREATE TABLE IF NOT EXISTS `tblreseteopass` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`userid` int(11) unsigned NOT NULL,
`username` varchar(20) NOT NULL,
`token` varchar(64) NOT NULL,
`fecha` int(11) NOT NULL,
`active` tinyint(1) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

*/
			/*$fields = $this->db->list_fields('solicitudestecnicos');
foreach ($fields as $field)
{
   echo $field . '<br>';
}
				//$this->db->query("DELETE FROM logsolicitudesrf WHERE sid = ''");
				/*$query = $this->db->query("SELECT preguntaid, respuesta FROM encuestas WHERE sid = '24233621'");
				print_r($query->result());*/
			?>
			<br>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>N°</span></th>
						<th scope="col"><span>N° SOT</span></th>
						<th scope="col"><span>TIPO SERVICIO</span></th>
						<th scope="col"><span>NOMBRE CLIENTE</span></th>
						<th scope="col"><span>DISTRITO - DPTO</span></th>
						<th scope="col"><span>PLANO</span></th>
						<th scope="col"><span>FECHA PROGRAMACIÓN</span></th>
					</tr>
				</thead>
				<?php if ( @$data ) { ?>
				<tbody>
				<?php foreach ( $data as $i => $row ) { ?>
				<tr>
					<td><strong><?=$i+1?></strong></td>
					<td><strong><?=$row->id?></strong></td>
					<td><strong><?=$row->tsnombre?></strong></td>
					<td><strong><?=$row->cliente?></strong></td>
					<td><strong><?=$row->distrito . ' - ' . $row->dpto?></strong></td>
					<td><strong><?=$row->plano?></strong></td>
					<td><strong><?=date('d-m-Y', $row->fecha_instalacion)?></strong></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>