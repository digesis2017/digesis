<table class="table table-bordered table-striped">      
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombres</th>
                  <th>Asistencia</th>
                  <th>Descanso</th>
                  <th>Motivo</th>
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