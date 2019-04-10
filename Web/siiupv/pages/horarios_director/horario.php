<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
    exit;
  }

  $query = 'select h.id_clase, h.id_aula, c.clave as clase_id, dia, a.nombre as aula_id, hora_inicio, hora_fin from horarios h inner join clases c on h.id_clase = c.id inner join aulas a on a.id = h.id_aula';
  //echo $query;                    
  $res= selectEspecial($conexion,$query);

  $query = 'select id, nombre from aulas';
  $aula = selectEspecial($conexion,$query);

  $query = 'select id, clave from clases';
  $clase = selectEspecial($conexion,$query);
  /*if ($_POST['buscar']) {
      
    }*/
 ?>
 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Horario</title>
<?php require '../menus/head.php' 
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Horarios
        <small>Tabla de horarios.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">      
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Buscar horarios</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
              <div class="row"><div class="col-sm-6"></div>
              <div class="col-sm-6"></div></div>

              <div class="row">
                <div class="col-sm-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th rowspan="1" colspan="2">
                      <a  href="agregar_horario.php">
                        <h5><i class="fa fa-fw fa-gears"></i>Agregar nuevo horario</h5></a>
                      </th>
                       <th rowspan="1" colspan="2">
                     
                        <h5 class="box-title">Elija un aula</h5>
              <select class="form-control" name="aula" id="select2_aula">
                <?php 
                      foreach ($aula as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo utf8_encode(($v["nombre"])) ?></option>   
                    <?php  }
                    ?>
              </select>
                      </th>
                      <th rowspan="1" colspan="2">
                        <h5 class="box-title">Elija una clase</h5>
              <select class="form-control" name="clase" id="select2_clase">
                    <?php 
                      foreach ($clase as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo $v["clave"] ?></option>   
                    <?php  }
                    ?>                     
              </select>
              <button type="submit" class="btn btn-primary" name="buscar">Buscar</button>
                      </th>
                  </tr>
                <tr role="row">
                  <!--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID
                  </th>-->
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">ID de clase
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Dia
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">ID de aula
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Hora de inicio
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Hora de fin
                  </th>
                </tr>
                </thead>
                <tbody>

                <?php
                
                  foreach ($res as $clases) {
                    echo "<tr role=\"row\" class=\"odd\">";
                    echo "<td>".$clases['clase_id']."</td>";
                    
                    echo "<td>".$clases["dia"]."</td>";
                    
                    echo "<td>".$clases["aula_id"]."</td>";
                    
                    echo "<td>".utf8_encode($clases["hora_inicio"])."</td>";
                    
                    echo "<td>".$clases["hora_fin"]."</td>";
                                        
                    echo "<td>
                    <div class=\"btn-group\">
                      <a  href=\"modificar_horario.php?id=".$clases["id_clase"]."\" type=\"button\" class=\"btn btn-info\"><i class=\"fa fa-fw fa-pencil\"></i></a>
                      <a  href=\"borrar_horario.php?id=".$clases["id_clase"]."&dia=".$clases["dia"]."\" type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-fw fa-trash\"></i></a>
                    </div>
                  </td>";
                    echo "</tr>";
                  }
                ?>                   
                </tbody>
                <tfoot>
                  <!--<tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>-->
                </tfoot>              
              </table></div></div>
              </div>            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <!-- /.col -->
      </div>






    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php require '../menus/footer.php' ?>

</div>

</body>
</html>
