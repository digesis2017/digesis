    
    <script type="text/javascript">
    $(function() {
      $('#frmmonedero #fecha').val(<?php echo "'".$fecha."'"; ?>);                
    });
    </script>
    </div>
      <script src="<?=base_url()?>js/departamentos.js"></script>
      <div class="list-mod-panel">
        <h1 style="float: left;"> Monedero &nbsp;&nbsp;</h1>        
      </div>
      <br>

  <fieldset class="search">
        <legend></legend>        
    <form class="form-inline" role="form" id="frmmonedero">
        <div class="container_buscar_fecha"> 
          <span class="" style="margin-bottom: 25px;">Fecha: <?php echo date('l, j \of  F Y') ?></span>

        <div class="form-group" style="margin-top: 15px;">

      <label style="display: inline; float: left; width:6%" for="ejemplo_email_1">Supervisor:</label>
              <select style="display: inline; float: left; width:12%" name="supid" id="supervisorid">
                  <option value="0">-Seleccione-</option>
                  <?php foreach ( $supervisores as $key => $supervisor ) { ?>
                  <option <?=(@$supid==$key ? 'selected' : '')?>  value="<?=$key?>"><?=$supervisor?></option>
                  <?php } ?>
                </select>

            <label style="display: inline; float: left; width:6%" for="ejemplo_email_1">Tecnico:</label>
            <select required id="tecnico1id" name="tecnico1id" style="float: left;width: 12%">                
                <option <?php echo (empty($perfil))? 'selected':'' ?> value="all">Todos los Tecnicos </option>
                <option <?php echo ($perfil==1)? 'selected':'' ?> value="1">Tecnico 1</option>
                <option <?php echo ($perfil==2)? 'selected':'' ?> value="2">Tecnico 2 </option>                
              </select>

          <label style="display: inline; float: left; width: 6%; margin-left:10px" for="ejemplo_email_1">Fecha:</label>          
          <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha" value="<?php echo $fecha?>" style="float: left;width: 12%">

          <input type="hidden" class="form-control" id="date" name="date" value="<?php echo $fecha?>">
          <button type="button" style="float:left;width:12%" class="btn btn-success" id="btnbuscar">Buscar</button>     
        </div>
              
        </div>
     </form>
  </fieldset>
      
      <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Nombres</th>
              <th>Perfil</th>
              <th>Comi. Dia</th>
              <th>Comi. Mes</th>
              <th>Detalle</th>             
            </tr>
          </thead>
          <tbody>         
<?php
if(!empty($result)):
          foreach($result as $key=>$value):
          ?>
          <tr>
            <td data-label="Fecha"><?php echo $value['nombres']; ?></td>
            <td data-label="Cant.SOT"><?php echo $value['perfil']; ?></td>
            <td data-label="Monto SOT"><?php echo $value['comidia'] ?></td>
            <td data-label="Desc.Asist"><?php echo $value['comimes']['monto'] ?></td>
            <td data-label="Desc.RF"><a href="<?php echo base_url().'index.php/monedero/detalle?dni='.$value['detalle']['dni'].'&fecha='.$value['detalle']['fecha']  ?>"><img src="http://digesis.pe/img/editar.png"></a></td>            
          </tr>
          <?php 
            endforeach;
          endif;  
          ?>  
          </table>        