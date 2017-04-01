<script type="text/javascript">
    $(function() {
      $('#frmasistencia #fecha').val(<?php echo "'".$fecha."'"; ?>);                
    });
    </script>

      </div>
      <script src="<?=base_url()?>js/departamentos.js"></script>


      <div class="list-mod-panel">
        <h1 style="float: left;"> Asistencia de Técnicos &nbsp;&nbsp;</h1>        
      </div>
      <br>
      <fieldset class="search">
        <legend></legend>        
         <form class="form-inline" role="form" id="frmasistencia">
        <div class="container_buscar_fecha"> 
          <span class="" style="margin-bottom: 15px;">Fecha: <?php echo date('l, j \of  F Y') ?></span>

        <div class="form-group" style="margin-top: 15px;">

            <label style="display: inline; float: left; width:6%" for="ejemplo_email_1">DNI:</label>          
            <input style="float: left;width: 12%" type="text" size="8" id="dni" name="dni" value="<?php echo $dni?>">
          <label style="display: inline; float: left; width: 6%; margin-left:10px" for="ejemplo_email_1">Fecha:</label>
          <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha" value="<?php echo $fecha?>" style="float: left;width: 12%">


          <input type="hidden" class="form-control" id="date" name="date" value="<?php echo $fecha?>"> 

          <button type="button" style="float:left;width:12%" class="btn btn-success" id="btnbuscar">Buscar</button>     
        </div>

        </div>
      </fieldset>
      <br>
      <div style="padding-top:10px;" id="resultadoasistencia">
<?php
  if(!empty($result1)){    
?>
<input type="hidden" id="result" name="result" value="result1">

<table class="table table-bordered table-striped">      
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombres</th>
                  <th>fecha</th>
                  <th>Asistencia</th>
                  <th>Descanso</th>
                  <th>Motivo</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php                
                
                  $i=1;
                  foreach ($result1 as $key => $val) {
                    $asistencia = '';
                    $descanso = '';
                    $motivo = '';
                    if(isset($val->asistencia) && isset($val->descanso) && isset($val->motivo)){
                      $asistencia = ($val->asistencia == '1') ? 'checked="checked"' : '';
                      $descanso = ($val->descanso == '1') ? 'checked="checked"' : '';
                      $motivo = (trim($val->motivo) != '') ? $val->motivo : '';
                    }
                  ?>
                  <tr>
                    <td><?php echo $val->id ?></td>
                    <input type="hidden" id="id-<?php echo $i ?>" name="id-<?php echo $i ?>" value="<?php echo $val->id ?>">
                    <td><?php echo $val->nombres ?></td>
    <td><?php echo date('Y-m-d',$val->fecha) ?></td>
<input type="hidden" id="fecha-<?php echo $i ?>" name="fecha-<?php echo $i ?>" value="<?php echo $val->fecha; ?>">

                    <td><input type="checkbox" class="form-control" id="asistencia-<?php echo $val->id ?>" name="asistencia-<?php echo $i ?>" <?php echo $asistencia ?> value="1"></td>

                    <td><input type="checkbox" class="form-control" id="descanso-<?php echo $i ?>" name="descanso-<?php echo $i ?>" <?php echo $descanso ?> value="1" ></td>

                    <td><input type="text" class="form-control" id="motivo-<?php echo $i ?>" name="motivo-<?php echo $i ?>" placeholder="Motivo" value="<?php echo $motivo ?>"></td>


  <td align="center">  
<?php 
if ($val->asistencia==1 or $val->descanso==1)
 $img=base_url().'encuesta/img/asistio.png';
else
$img= base_url().'encuesta/img/falto.png'; 

?>

  <img width="25px" height="30px" src="<?php echo $img; ?>"></td>

                  </tr>
                  <?php
                  $i++;
                  }                
              ?>
                <tr>
                  <td colspan="5">Total Registros: <?php echo count($result1) ?></td>
                </tr>
                <input type="hidden" id="cantidad" name="cantidad" value="<?php echo count($result1) ?>">
              </tbody>
            </table>
<?php 
  }else if(!empty($result2)) {?>

<input type="hidden" id="result" name="result" value="result2">
      <table class="table table-bordered table-striped">      
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombres</th>
                  <th>Asistencia</th>
                  <th>Descanso</th>
                  <th>Motivo</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php                
                
                  $i=1;
                  foreach ($result2 as $key => $val) {
                    $asistencia = '';
                    $descanso = '';
                    $motivo = '';
                    if(isset($val->asistencia) && isset($val->descanso) && isset($val->motivo)){
                      $asistencia = ($val->asistencia == '1') ? 'checked="checked"' : '';
                      $descanso = ($val->descanso == '1') ? 'checked="checked"' : '';
                      $motivo = (trim($val->motivo) != '') ? $val->motivo : '';
                    }
                  ?>

                  <tr>
                    <td><?php echo $val->id ?></td>
                    <input type="hidden" id="id-<?php echo $i ?>" name="id-<?php echo $i ?>" value="<?php echo $val->id ?>">
                    <td><?php echo $val->nombres ?></td>

                    <td><input type="checkbox" class="form-control" id="asistencia-<?php echo $val->id ?>" name="asistencia-<?php echo $i ?>" <?php echo $asistencia ?> value="1"></td>

                    <td><input type="checkbox" class="form-control" id="descanso-<?php echo $i ?>" name="descanso-<?php echo $i ?>" <?php echo $descanso ?> value="1" ></td>

                    <td><input type="text" class="form-control" id="motivo-<?php echo $i ?>" name="motivo-<?php echo $i ?>" placeholder="Motivo" value="<?php echo $motivo ?>"></td>


  <td align="center">  
<?php 
$img= base_url().'encuesta/img/falto.png'; 

if (isset($val->asistencia) and isset($val->descanso))
  if ($val->asistencia==1 or $val->descanso==1){    
   $img=base_url().'encuesta/img/asistio.png';
  }
 
  
?>

  <img width="25px" height="30px" src="<?php echo $img; ?>"></td>

                  </tr>
                  <?php
                  $i++;
                  }
                
              ?>
                <tr>
                  <td colspan="5">Total Registros: <?php echo count($result2) ?></td>
                </tr>
                <input type="hidden" id="cantidad" name="cantidad" value="<?php echo count($result2) ?>">
              </tbody>
            </table>
            <?php 
          }
            ?>
            </div>
          <div class="divbuttons">
          <input class="btnsearch" type="button" value="Guardar Asistencia" id="grabar" >          
          </div>            
            </form>
    </div>
  </div>
</body>
<script type="text/javascript">
    $("#fecha").datepicker();
    $( "#fecha" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
</script>
</html>



