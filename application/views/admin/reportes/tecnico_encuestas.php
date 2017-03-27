			</div>
				<script src="<?=base_url()?>js/exportar.js"></script>
			<div class="list-mod-panel">
				<h1 style="float: left;"> Reportes / Encuestas / TÉCNICO &nbsp;&nbsp;</h1>
				<a href="#" id="exportar"><img style="width: 25px;height: 25px;" src="/img/excel.png"></a>
			</div>
			<br><br><br>
			<table id="tbl_exportar" class="table table-bordered table-striped" >
				<thead>
					<tr>
						<th scope="col"><span>TÉCNICO</span></th>
						<th scope="col"><span>SOLICITUD</span></th>
						<th scope="col"><span>FECHA</span></th>
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
					<td><strong><?=$tecnicos[$tid]?></strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong>-</strong></td>
					<td><strong><?=isset($data['promedio'])?$data['promedio']:'-'?></strong></td>
				</tr>
					<?php if ( isset($data['solicitudes']) && count($data['solicitudes']) ) {
						$c=0;
 					$prom[1]=0;$prom[2]=0;$prom[3]=0;$prom[4]=0;$prom[5]=0;
					 ?>
					<?php foreach ( $data['solicitudes'] as $solicitud ) {
					$c++;
					 ?>
					<tr>
						<td><strong>-</strong></td>
						<td><strong><?=$solicitud->id?></strong></td>
						<td><strong><?=$solicitud->fecha_instalacion?></strong></td>
						<?php 							 
						  foreach ( $solicitud->encuestas as $key=>$value ) { 
							$prom[$key]=$prom[$key]+$value;
						  	?>
							<td><strong><?=$value?></strong></td>
						<?php } ?>
						<td><strong>
						<span style="color:<?php echo (@$solicitud->promedio<6)? 'red':'blue' ?> ">

						<?=isset($solicitud->promedio)?$solicitud->promedio:'-'?>


						</span></strong></td>
					</tr>
					<?php } ?>
					<?php } ?>
				</tbody>
				<?php } ?>				
				<tfoot>				
				<th>
					<td>-</td>
					<td>-</td>					
			<td>
			<?php $prom1= Round($prom[1]/$c,2); ?>
			<span style="color:<?php echo ($prom1<6)? 'red':'blue' ?> "> <?php echo $prom1; ?></span> </td>

			<td>
			<?php $prom1= Round($prom[2]/$c,2); ?>
			<span style="color:<?php echo ($prom1<6)? 'red':'blue' ?> "> <?php echo $prom1; ?></span> </td>

			<td>
			<?php $prom1= Round($prom[3]/$c,2); ?>
			<span style="color:<?php echo ($prom1<6)? 'red':'blue' ?> "> <?php echo $prom1; ?></span> </td>

			<td>
			<?php $prom1= Round($prom[4]/$c,2); ?>
			<span style="color:<?php echo ($prom1<6)? 'red':'blue' ?> "> <?php echo $prom1; ?></span> </td>

			<td>
			<?php $prom1= Round($prom[5]/$c,2); ?>
			<span style="color:<?php echo ($prom1<6)? 'red':'blue' ?> "> <?php echo $prom1; ?></span> </td>
			
					<td></td>
				</th>

				</tfoot>
			</table>
			<br><br>
			<input class="btnsearch" type="button" value="Regresar" onclick="window.location='<?=base_url()?>index.php/reportes/encuestas';">
		</div>
	</div>
</body>
</html>