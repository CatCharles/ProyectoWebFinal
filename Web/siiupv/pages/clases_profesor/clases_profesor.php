<?php
  require '../basedatos/conexion.php';
require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=3){
    header('Location: ../../index.php');
    exit;
  }  

  $query = "select `g`.`id` AS `id_grupo`,`g`.`clave` AS `cve_gpo`,`q`.`descripcion` AS `cuatrimestre`,`ca`.`nombre` AS `carrera`,`p`.`clave` AS `cve_plan`,`c`.`clave` AS `cve_clase`,`mt`.`nombre` AS `materia`,`m`.`nombre_completo` AS `maestro`,`c`.`id` AS `id_clase`,`g`.`id_cuatrimestre` AS `id_cuatrimestre`,`ca`.`id` AS `id_carrera`,`p`.`id` AS `id_plan`,`m`.`id` AS `id_maestro`, c.estatus from ((((((`siiupv`.`grupos` `g` join `siiupv`.`clases` `c` on((`g`.`id` = `c`.`id_grupo`))) join `siiupv`.`cuatrimestres` `q` on((`g`.`id_cuatrimestre` = `q`.`id`))) join `siiupv`.`planes_estudio` `p` on(((`g`.`id_carrera` = `p`.`id_carrera`) and (`g`.`id_plan` = `p`.`id`)))) join `siiupv`.`carreras` `ca` on((`p`.`id_carrera` = `ca`.`id`))) join `siiupv`.`vwmaestros` `m` on((`c`.`id_maestro` = `m`.`id`))) join `siiupv`.`materias` `mt` on((`c`.`id_materia` = `mt`.`id`))) where id_maestro =(select id from maestros where id_persona = ".$_SESSION['id_persona'].")"; // Modificar id_maestro.
  //$query = "select id_maestro, carrera, cve_clase, cve_plan, cuatrimestre, cve_gpo, id_clase from vwgruposconclase where id_maestro = '1'"; // Modificar id_maestro.
  $res= selectEspecial($conexion,$query);
 ?>
 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Clases</title>
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
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Calificar clases</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row"><div class="col-sm-6"></div>
                <div class="col-sm-6"></div></div>

                <div class="row"><div class="col-sm-12">


                <table id="example1" class="table table-bordered table-striped">
                <thead>
                   <tr>
                  <th rowspan="1" colspan="5">
                    <a  href="agregar_grupo.php">
                      <!--<h5><i class="fa fa-fw fa-gears"></i></h5></a>-->
                    </th>
                </tr>
                <tr role="row">
                  <!--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID-->
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Carrera
                  </th>
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Materia
                  </th>                  
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Clave de clase
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Plan de estudio</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Cuatrimestre
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Clave del grupo
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Estado
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Herramientas
                  </th>                  
                </tr>
                </thead>
                <tbody>

                <?php
                  foreach ($res as $clase) {
                    echo "<tr role=\"row\" class=\"odd\">";
                    echo "<td class=\"sorting_2\">".utf8_encode($clase["carrera"])."</td>";
                    echo "<td>".utf8_encode($clase["materia"])."</td>";
                    echo "<td>".$clase["cve_clase"]."</td>";                    
                    echo "<td>".$clase["cve_plan"]."</td>";
                    echo "<td>".$clase["cuatrimestre"]."</td>";
                    echo "<td>".$clase["cve_gpo"]."</td>";

                    if ($clase["estatus"]=="1") { // En curso.
                      echo "<td><span class=\"label label-warning\">En curso</span></td>";                   
                    } else if ($clase["estatus"]=="2") { // Calificada.
                      echo "<td><span class=\"label label-primary\">Calificada</span></td>";                       
                    } else if ($clase["estatus"]=="0") { // Baja.
                      echo "<td><span class=\"label label-danger\">Baja</span></td>";
                    }
                    

                    echo "<td>
                    <div class=\"btn-group\">
                      <a  href=\"alumnos_clase.php?id=".$clase["id_clase"]."&id_maestro=".$clase["id_maestro"]."\" type=\"button\" class=\"btn btn-info\"><i class=\"fa fa-eye\"></i></a>
                      <a href=\"generar_pdf.php?id=".$clase["id_clase"]."&id_maestro=".$clase["id_maestro"]."\" type=\"button\" name=\"pdf\" class=\"btn btn-danger\"><i class=\"fa fa-file-pdf-o\"></i></a>
                    </div>
                  </td>";
                    echo "</tr>";
                  }
                ?>

                <!--<a  href=\"borrar_grupo.php?id=".$clase["id_clase"]."\" type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-fw fa-trash\"></i></a>-->

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
