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

        <div class="form-group">
          <label for="ejemplo_email_1">Fecha:</label>
          <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha" style="float: left;width: 40%" value="<?php echo $date ?>">
          <input type="hidden" class="form-control" id="date" name="date" value="<?php echo $date ?>">
          <button type="button" class="btn btn-success" id="btnbuscar">Buscar</button>     
        </div>      
        </div>
      </fieldset>
      <br>
      <div style="padding-top:10px;" id="resultadoasistencia">
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
                // echo '<pre>';
                // var_dump($result);
                // echo '</pre>';
                if(!empty($result)){
                  $i=1;
                  foreach ($result as $key => $val) {
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


  <td><img src="<?php echo ($asistencia==1)? base_url().'index.php/encuesta/img/asistio.png':base_url().'index.php/encuesta/img/falto.png' ?>"></td>

                  </tr>
                  <?php
                  $i++;
                  }
                }
              ?>
                <tr>
                  <td colspan="5">Total Registros: <?php echo count($result) ?></td>
                </tr>
                <input type="hidden" id="cantidad" name="cantidad" value="<?php echo count($result) ?>">
              </tbody>
            </table>
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



