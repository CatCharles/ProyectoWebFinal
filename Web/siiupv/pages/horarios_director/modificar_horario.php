<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
    exit;
  }
  $dato = $_GET['id'];
  $queryp = "select h.id_clase, h.id_aula, c.clave as clase_id, dia, a.nombre as aula_id, hora_inicio, hora_fin from horarios h inner join clases c on h.id_clase = c.id inner join aulas a on a.id = h.id_aula where h.id_clase = '{$dato}'";
  $res= selectEspecial($conexion,$queryp);

  $query = 'select id, nombre from aulas';
  $aula = selectEspecial($conexion,$query);

  $query = 'select id, clave as jalapls from clases';
  $clase = selectEspecial($conexion,$query);

  $table = 'horarios';
  $errores = '';

  $modTabla=0;

  $aulaSelec=0;
  $claseSelec=0;

  $aulaOcup=0;
  $claseOcup=0;

  if(isset($_POST['submit'])){

      $id_clase = $_POST['clase'];
        $id_aula = $_POST['aula'];
        $dia = $_POST['dia'];
        $hora_inicio = $_POST['h_inicio'];
        $hora_fin = $_POST['h_fin'];    

        if(empty($id_clase)){
          $errores .= 'Ingresa un ID de clase. <br/>';
        }

        if(empty($id_aula)){
          $errores .= 'Ingresa un ID de aula. <br/>';
        }

        if(empty($dia)){
          $errores .= 'Seleccione un dia. <br/>';
        }

        if(empty($hora_inicio)){
          $errores .= 'Seleccione una hora de inicio. <br/>';
        }

        if(empty($hora_fin)){
          $errores .= 'Seleccione una hora de fin. <br/>';
        }

        if(empty($errores)){
          echo 'aula: ' . $id_aula . '<br>';
          echo 'clase: ' .  $id_clase . '<br>';
          echo 'dia: ' . $dia . '<br>';
          echo 'h_inicio: ' . $hora_inicio . '<br>';
          echo 'h_fin: ' . $hora_fin . '<br>';
          $query = "insert into {$table}(id_clase, dia, id_aula, hora_inicio, hora_fin) values ({$id_clase},{$dia},{$id_aula}, '{$hora_inicio}', '{$hora_fin}');";
          echo $query;
        $actualizar = crear_registro($conexion,$query); 
        if($actualizar){
          redirect('horario.php');
        }
      }
      else {
          echo $errores;
      }
  }


    if(isset($_POST['verClase'])){
    $id_aula = $_POST['aula'];
    //echo $id_aula;
    $id_clase = $_POST['clase'];


        
    if(empty($id_aula)){
      $errores .= 'Seleccione un ID de aula. <br/>';
    }

    if(empty($id_clase)){
      $errores .= 'Seleccione un ID de aula. <br/>';
    }

    if(empty($errores)){
      $modTabla=2; 
      $aulaSelec = $id_aula;
      $claseSelec = $id_clase;
    } else {
        //echo $errores;
      }
  }


  if(isset($_POST['verAulas'])){
    $id_aula = $_POST['aula'];
    //echo $id_aula;
        
    if(empty($id_aula)){
      $errores .= 'Seleccione un ID de aula. <br/>';
    }

    if(empty($errores)){
      $modTabla=1; 
      $aulaSelec = $id_aula;
      } else {
        //echo $errores;
    }
  }

  function doHorario($hor1, $hor2,$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla){
  $errores2 = '';
  $query = "select * from horarios where id_aula =$aulaSelec";
  $aulaOcup = selectEspecial($conexion,$query);
  if(empty($aulaOcup)){
  //echo "VACIO";
    $errores2 .= 'No hay datos. <br/>';
  }
  //echo $modTabla;
  if ($modTabla==2) {
    $query = "select * from horarios where id_clase =$claseSelec";
    $claseOcup = selectEspecial($conexion,$query);
    if(empty($claseOcup)){
    //echo "VACIO";
      $errores2 .= 'No hay datos. <br/>';
    }
  }                                

  for ($i = 1; $i < 6; $i++) {
    $valDia=0;
    $valClas=0;                    
    if ($modTabla==2 && empty($errores2)) {
      foreach ($claseOcup as $op2) {
        if ($op2['dia']==$i and ($op2['hora_inicio']=="$hor1" or $op2['hora_fin']=="$hor2") and 
          $claseSelec==$op2['id_clase']) {
          echo "<td bgcolor = #30fcff> <b> IMPARTIENDO CLASE </b> </td>";
          $valDia=2;
        }
      }
    }
    if ($valDia!=2) {
      foreach ($aulaOcup as $op) {
        if ($op['dia']==$i and ($op['hora_inicio']=="$hor1" or $op['hora_fin']=="$hor2")) {
          echo "<td bgcolor = #ff3030> <b> AULA OCUPADA </b> </td>";
          $valDia=1;
        }
      }
    }
    if ($valDia==0) {
      echo "<td bgcolor =#8bff30> <B> AULA DISPONIBLE </B> </td>";
    }  
  }
                      
}        
 ?>
 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Modificar clase</title>
<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Horarios
        <small>Editar horarios.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

     <div class="col-md-3">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Modificar horario</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id={$dato}" ?>" role="form">
              <?php foreach ($res as $clase) {    ?>
              <div class="box-body">
                <div class="form-group">
                  <!--<label for="">ID</label>-->
                  <input type="hidden" class="form-control" name="id" placeholder="Ingrese el ID" value=" <?php echo $clase["id"]?> " required readonly>
                </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">ID aula</label>
                    <select class="form-control" name="aula" id="select2_aula">
                      <?php 
                      foreach ($aula as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo utf8_encode(($v["nombre"])) ?></option>   
                      <?php  }
                      ?>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-primary" name="verAulas">Ver disponibilidad del aula</button> 
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">ID de clase</label>
                    <select class="form-control" name="clase" id="select2_clase" readonly = "readonly" />
                    <?php 
                      foreach ($res as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo $v["clase_id"] ?></option>   
                      <?php  }
                      ?>                     
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Dia</label>
                    <select class="form-control" name="dia">
                      
                      <option value="1">Lunes</option> 
                      <option value="2">Martes</option>
                      <option value="3">Miércoles</option>
                      <option value="4">Jueves</option>
                      <option value="5">Viernes</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Hora de inicio</label>
                    <select class="form-control" name="h_inicio">
                      <option value='7:00' selected>7:00</option> 
                      <option value='8:50'>8:50</option>
                      <option value='9:45'>9:45</option>
                      <option value='10:40'>10:40</option>
                      <option value='12:05'>12:05</option>
                      <option value='13:00'>13:00</option> 
                      <option value='13:55'>13:55</option>
                      <option value='14:55'>14:55</option>
                      <option value='15:50'>15:50</option>
                      <option value='16:45'>16:45</option>
                      <option value='17:40'>17:40</option> 
                      <option value='18:55'>18:55</option>
                      <option value='19:50'>19:50</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Hora de fin</label>
                    <select class="form-control" name="h_fin">
                      <option value='7:54' selected>7:54</option> 
                      <option value='8:49'>8:49</option>
                      <option value='9:44'>9:44</option>
                      <option value='10:39'>10:39</option>
                      <option value='12:04'>12:04</option>
                      <option value='12:59'>12:59</option> 
                      <option value='13:54'>13:54</option>
                      <option value='14:54'>14:54</option>
                      <option value='15:49'>15:49</option>
                      <option value='16:44'>16:44</option>
                      <option value='17:39'>17:39</option> 
                      <option value='18:54'>18:54</option>
                      <option value='19:49'>19:49</option>
                      <option value='20:44'>20:44</option>
                    </select>
                  </div>
              </div>
              <!-- /.box-body -->
                <?php } ?>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="submit">Modificar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
      </div>
    <div class="col-xs-9">
          <div class="box" >
            <div class="box-header">
              <h3 class="box-title">Horario</h3>
            </div>

             <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label=""></th>
                  <th  class="text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="5" aria-label="">DIA
                  </th>
                </tr>
                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">HORA</th>
                  
                  <td>Lunes</td>
                  <td>Martes</td>
                  <td>Miercoles</td>
                  <td>Jueves</td>
                  <td>Viernes</td>
                  </th>
                </tr>
              </thead>
              <tbody>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">7:00 - 7:54</th>
                  <?php
                    if ($aulaSelec!=0) {
                     
                        doHorario("07:00:00","07:54:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);  
                
                      
                    } 

                  ?>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">7:55 - 8:49</th>
                  <?php
                     if ($aulaSelec!=0) {
                      doHorario("07:55:00","08:49:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);  
                    } 
                  ?>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">8:50 - 9:44</th>
                   <?php
                     if ($aulaSelec!=0) {
                       doHorario("08:50:00","09:44:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);  
                    } 
                  ?>

                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">9:45 - 10:39</th>
                  <?php
                     if ($aulaSelec!=0) {
                      doHorario("09:45:00","10:39:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla); 
                    } 
                  ?>
                
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">10:40 - 11:09</th>
                  <td colspan = 5 class="text-center"> R E C E S O </td>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">11:10 - 12:04</th>
                  <?php
                     if ($aulaSelec!=0) {
                      doHorario("11:10:00","12:04:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">12:05 - 12:59</th>
                  <?php
                     if ($aulaSelec!=0) {
                      doHorario("12:05:00","12:59:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>


                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">13:00 - 13:54</th>
                  <?php
                     if ($aulaSelec!=0) {
                    doHorario("13:00:00","13:54:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">14:00 - 14:54</th>
                  <?php
                     if ($aulaSelec!=0) {
                      doHorario("14:00:00","14:54:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>                  
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">14:55 - 15:49</th>
                  <?php
                     if ($aulaSelec!=0) {
                   doHorario("14:55:00","15:49:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>   
                  </th>
                </tr>


                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">15:50 - 16:44</th>
                  <?php
                     if ($aulaSelec!=0) {
                   doHorario("15:50:00","16:44:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">16:45 - 17:39</th>
                  <?php
                     if ($aulaSelec!=0) {
                    doHorario("16:45:00","17:39:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">17:40 - 17:59</th>
                  <td colspan = 5 class="text-center"> R E C E S O </td>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">18:00 - 18:54</th>
                  <?php
                     if ($aulaSelec!=0) {
                    doHorario("18:00:00","18:54:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>

                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">18:55 - 19:49</th>
                  <?php
                     if ($aulaSelec!=0) {
                    doHorario("18:55:00","19:49:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>
                <tr role="row">
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">19:50 - 20:44</th>
                   <?php
                     if ($aulaSelec!=0) {
                    doHorario("19:50:00","20:44:00",$aulaSelec,$conexion,$query,$aulaOcup,$claseSelec,$claseOcup,$modTabla);
                    } 
                  ?>
                  </th>
                </tr>       
              </tbody>
                <tfoot>
                  <!--<tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>-->
                </tfoot>              
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <!-- /.col -->

    </section>

        </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php require '../menus/footer.php' ?>

</div>

</body>
</html>


