<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
    exit;
  }
  $query = "SELECT CONCAT(pm.id_carrera,pm.id_plan,pm.id_materia) as id,
			car.nombre as carrera,pe.clave as plan,m.nombre as materia, cuatrimestre,creditos,horas_practica,horas_teoricas 
			FROM planes_con_materias pm
			INNER JOIN carreras car ON pm.id_carrera=car.id
			INNER JOIN planes_estudio pe ON pm.id_plan=pe.id 
			INNER JOIN materias m ON pm.id_materia=m.id;";
						
  $res= selectEspecial($conexion,$query);
 ?>
 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Planes de estudio con materias</title>
<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Planes de estudio con materias correspondientes
        <small>Tabla de planes de estudio con sus materias correspondientes.</small>
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
              <h3 class="box-title">Buscar en planes de estudio con materias</h3>
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
                  <th rowspan="1" colspan="3">
                    <a  href="agregar_planconmateria.php">
                      <h5><i class="fa fa-fw fa-gears"></i>Agregar un Nuevo Registro</h5></a>
                    </th>
                  <th rowspan="1" colspan="3"></th>
                  <th rowspan="1" colspan="3">
                     <a href="agregar_seriacion.php" type="button" class="btn btn-info"><i class="fa fa-fw fa-pencil"></i>Agregar seriación de materias</a>
                </tr>
                <tr role="row">
                	<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID
                  </th>
                  <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Plan de estudio
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Carrera
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Materia
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">N° de cuatrimestre
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Creditos
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Horas prácticas
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Horas teoricas                  	
                  </th>                 
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Herramientas
                  </th>
                </tr>
                </thead>
                <tbody>

                <?php
                  foreach ($res as $cuatri) {
                    echo "<tr role=\"row\" class=\"odd\">";
                    echo "<td class=\"sorting_2\">".$cuatri["id"]."</td>";
                    echo "<td>".$cuatri["plan"]."</td>";
                    echo "<td>".utf8_encode($cuatri["carrera"])."</td>";
                    echo "<td>".utf8_encode($cuatri["materia"])."</td>";
                    echo "<td>".$cuatri["cuatrimestre"]."</td>";
                    echo "<td>".$cuatri["creditos"]."</td>";
                    echo "<td>".utf8_encode($cuatri["horas_practica"])."</td>";
                    echo "<td>".utf8_encode($cuatri["horas_teoricas"])."</td>";

                    echo "<td>
                    <div class=\"btn-group\">
                      <a  href=\"modificar_planconmateria.php?id=".$cuatri["id"]."\" type=\"button\" class=\"btn btn-info\"><i class=\"fa fa-fw fa-pencil\"></i></a>
                      <a  href=\"borrar_planconmateria.php?id=".$cuatri["id"]."\" type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-fw fa-trash\"></i></a>
                    </div>
                  </td>";
                    echo "</tr>";

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
