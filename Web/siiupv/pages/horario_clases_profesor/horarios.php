<?php
require '../basedatos/conexion.php';
require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=3){
    header('Location: ../../index.php');
    exit;
  }
$res= selectEspecial($conexion,'SELECT materias.nombre AS "materia", grupos.clave, clases.estatus, horarios.dia, aulas.nombre, horarios.hora_inicio,horarios.hora_fin FROM clases INNER JOIN materias on clases.id_materia= materias.id INNER JOIN grupos ON clases.id_grupo= grupos.id INNER JOIN horarios ON horarios.id_clase= clases.id INNER JOIN aulas on horarios.id_aula= aulas.id WHERE clases.estatus=1 AND id_maestro=(select id from maestros where id_persona = '.$_SESSION['id_persona'].') ' );

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<title>Historial de clases</title>

<?php require '../menus/head.php' ?>


<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php require '../menus/header.php' ?>
    <?php require '../menus/sidebar.php' ?>

    <div class="content-wrapper">

      <!--Titulo dentro del contened-->
      <section class="content-header">
        <h1>
          Clases
          <small>Tabla de clases.</small>
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
           
              <!-- /.box-header -->
              <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  <div class="row"><div class="col-sm-6"></div>
                  <div class="col-sm-6"></div></div>

                  <div class="row"><div class="col-sm-12">

                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                     
                        <tr role="row">       
                    
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Materia</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Grupo</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">dia </th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Aula</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Hora</th>
                      </thead>
                      <tbody>

                        <?php
                        if($res!=false)
                        {
                          foreach ($res as $clase) 
                          {
                            echo "<tr role=\"row\" class=\"odd\">";
                            echo "<td>".$clase["materia"]."</td>";
                            echo "<td>".$clase["clave"]."</td>";
                            if($clase["dia"]==1)
                              echo "<td> Lunes </td>";
                            if($clase["dia"]==2)
                              echo "<td> Martes </td>";
                            if($clase["dia"]==3)
                              echo "<td> Miercoles </td>";
                            if($clase["dia"]==4)
                              echo "<td> Jueves </td>";
                            if($clase["dia"]==5)
                              echo "<td> Viernes </td>";
                            if($clase["dia"]==6)
                              echo "<td> Sabado </td>";
                            echo "<td>".$clase["nombre"]."</td>";
                            echo "<td>".$clase["hora_inicio"]."-".$clase["hora_fin"]. "</td>";
                            echo "</tr>";

                          }
                        }


                      ?>


                      <!--   -->
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
