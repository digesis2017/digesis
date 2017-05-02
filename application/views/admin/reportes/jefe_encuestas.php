			</div>

			<script src="<?=base_url()?>js/exportar.js"></script>
			<div class="list-mod-panel">
				<h1 style="float: left;"> Reportes / Encuestas / JEFE &nbsp;&nbsp;</h1>
				<a href="#" id="exportar"><img style="width: 25px;height: 25px;" src="<?=base_url()?>/img/excel.png"></a>
			</div>
			<br><br><br>
			<table id="tbl_exportar" class="table tableseg table-bordered table-striped">
				<thead>
					<tr>
						<th scope="col"><span>JEFE</span></th>
						<th scope="col"><span>SUPERVISORES</span></th>
						<th scope="col"><span>Preg. 1</span></th>
						<th scope="col"><span>Preg. 2</span></th>
						<th scope="col"><span>Preg. 3</span></th>
						<th scope="col"><span>Preg. 4</span></th>
						<th scope="col"><span>Preg. 5</span></th>
						<th scope="col"><span>PROMEDIO</span></th>
					</tr>
				</thead>
				<?php if ( isset($data) && count($data) ) { ?>
				<tbody>
				<tr>
					<td><strong><?=$jefes[$jefeid]?></strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong><?=isset($data['promedio'])?$data['promedio']:'-'?></strong></td>
				</tr>
					<?php if ( isset($data['supervisores']) && count($data['supervisores']) ) { ?>
					<?php foreach ( $data['supervisores'] as $supid => $data_s ) { ?>
					<tr>
						<td><strong>-</strong></td>
						<td><strong><?=$supervisores[$supid]?></strong></td>
						<td><strong><?php echo @$promedio[$supid]['promedio'][1]; ?></strong></td>
						<td><strong><?php echo @$promedio[$supid]['promedio'][2]; ?></strong></td>
						<td><strong><?php echo @$promedio[$supid]['promedio'][3]; ?></strong></td>
						<td><strong><?php echo @$promedio[$supid]['promedio'][4]; ?></strong></td>
						<td><strong><?php echo @$promedio[$supid]['promedio'][5]; ?></strong></td>
						<td><strong><?=isset($data_s['promedio'])?$data_s['promedio']:'-'?></strong></td>
					</tr>
					<?php } ?>
					<?php } ?>
				</tbody>
				<?php } ?>
			</table>
			<br><br>
			<input class="btnsearch" type="button" value="Regresar" onclick="window.location='<?=base_url()?>index.php/reportes/encuestas';">
		</div>
	</div>
</body>
</html>