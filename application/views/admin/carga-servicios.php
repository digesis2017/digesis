			<script type="text/javascript">
				
		$(document).ready(function(){
    		var table =$('#myTable').DataTable( {
		        "language": {
        		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" 		 
        		},
        		"dom": '<"toolbar">frtip'
    		});

 //$("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');

$('#sel_categoria').on( 'change', function () {
	var id=$(this).val();
	document.location.href="/digesis/index.php/servicios?cat="+id;
});	
 

			$('#myTable tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('selected') ) {
			            $(this).removeClass('selected');
			        }
			        else {
			            table.$('tr.selected').removeClass('selected');
			            $(this).addClass('selected');
			        }
			    } );
			 
			    $('#button').click( function () {
			        table.row('.selected').remove().draw( false );
			    } );

		$('#myTable tr td').on( 'click', 'a.serv_delete', function () {
			var id=$(this).attr('data-id');
			var me=$(this);
			
			$.ajax({      				
				data: {id : id},
				url:   '/digesis/index.php/servicios/delete',
				type:  'POST',
				dataType: 'json',				
				success:  function (r) {							
				$(me).parent().parent().parent().fadeTo(800, 0, function () {       $(this).remove(); });			
  				}
  			}); 			
		});

			$("input#btn_agregar").on( "click", function() {
				
      			var servicio = $('input#txt_servicio').val();
      			var categoria = $('select#txt_categoria').val();
      			var motivos = $('input#txt_motivos').val();
      			var fotos = $('input#txt_fotos').val();
			if (servicio!="" && categoria!=""){
      			$.ajax({      				
	data: { servicio : servicio,categoria:categoria,motivos:motivos,fotos:fotos},
				url:   '/digesis/index.php/servicios/add',
				type:  'POST',
				dataType: 'json',				
				success:  function (r) {
				$("#msg_asignacion").html('Registro servicios correcto');	
				$("#msg_asignacion").fadeOut();
				$("#msg_asignacion").removeClass('hidden');			

				setTimeout(function() {
				$("#msg_asignacion").fadeIn();
    			$("#msg_asignacion").addClass('hidden');    			
				}, 3000);

  				}
  			});

  			}else{

				$("#msg_asignacion").fadeOut();
				$("#msg_asignacion").removeClass('hidden');			
				setTimeout(function() {
				$("#msg_asignacion").fadeIn();
    			$("#msg_asignacion").addClass('hidden');    			
				}, 3000);
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
				<p class="help-block">Seleccione un archivo xls.</p>
				</div>					
			<input class="btn" style="margin: 0px;" name="carga" type="submit" value="Cargar" />
			<br><br>
			<?php if ( @$error ) echo $error; ?>
			</form>					
			<hr style="border: 1px blue solid">			
			<br>

<div id="msg_asignacion" style="width: 100%" class="msgimportante hidden">Debe completar los datos</div>
		<fieldset class="row" style="border: solid 1px #b3b3b3;margin-left: 10px; margin-right: 10px;padding-top:10px; margin-bottom: 15px;">
		<legend>Agregar Servicio</legend>
		<!--<div class="row" style="border: solid 1px #b3b3b3;margin-left: 10px; margin-right: 10px;padding-top:10px; margin-bottom: 15px;">-->
			  <div class="col-xs-3">
			    <input type="text" id="txt_servicio" class="form-control" placeholder="servicio">
			  </div>
			  <div class="col-xs-2">
				<select style="width: 100px" id="txt_categoria" placeholder="categoria">
					<option>Categoria</option>
					<?php foreach($categorias as $key=>$row){ ?>
<option value="<?php echo trim($row->id) ?>">
<?php echo trim($row->nombre) ?>
</option>
					<?php } ?>
				</select>			 
			  </div>

			  <div class="col-xs-3">
			    <input type="text" id="txt_motivos" class="form-control" placeholder="motivos">
			  </div>
			  <div class="col-xs-1">
<input class="form-control" id="txt_fotos" placeholder="fotos" type="number" size="2" min="0" max="99" value="">
			  </div>
			  <div class="col-xs-2">
				<input type="button" id="btn_agregar" value="Agregar" class="btn"></input>
			  </div>

		</fieldset>
			  <!--</div>-->			

			<div class="toolbar">

<div class="col-xs-1"> 
	<span style="display:inline; width:150px;margin-right:10px; ">Filtrar por:</span>
</div>
			<div class="col-xs-2" style="margin-left: 15px;">		
				<select id="sel_categoria" placeholder="categoria">
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
			</div>			
			</div>
			<table class="table table-striped table-bordered" id="myTable" data-page-length='25'>
				<thead>
				<tr>
					<th scope="col"><span>#</span></th>			
					<th scope="col"><span>Servicio a ejecutar</span></th>
					<th scope="col"><span>Categoria</span></th>
					<th scope="col"><span>Motivos de solucion</span></th>
					<th scope="col"><span>Fotos</span></th>
					<th scope="col"><span>Accion</span></th>
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
					<td>

<strong><a class="serv_editar" style="color:blue" data-id="<?=$row->id ?>" href="/digesis/index.php/servicios/edit/<?=$row->id ?>">Editar</a></strong>
<span>|</span>

					<strong><a class="serv_delete" style="color:red" data-id="<?=$row->id ?>" href="#">Eliminar</a></strong></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>