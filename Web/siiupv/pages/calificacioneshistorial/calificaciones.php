<?php
  require '../basedatos/conexion.php';
   require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=4){
    header('Location: ../../index.php');
    exit;
  }
  $res= select($conexion,'alumnos');

  //$consulta_todo = "SELECT 'alumnos.matricula', 'personas.nombre', 'personas.paterno', 'personas.materno', 'carreras.nombre' as carrera, 'alumnos.promedio_ingreso', 'alumnos.puntos_ceneval' as nombre_carrera FROM alumnos INNER JOIN personas on 'personas.id' = 'alumnos.id_persona' INNER JOIN carreras on 'carreras.id' = 'alumnos.id_carrera'";

  //$consulta_todo = "SELECT alumnos"."."."id, alumnos". ".".  "matricula, personas". ".". "nombre, personas". ".". "paterno, personas". ".". "materno, carreras". ".". "nombre as carrera, alumnos". ".". "promedio_ingreso, alumnos". ".". "puntos_ceneval, alumnos"."."."escuela_procedencia FROM alumnos INNER JOIN personas on personas". ".". "id = alumnos". ".". "id_persona INNER JOIN carreras on carreras". ".". "id = alumnos". ".". "id_carrera";
  
  //Sólo hace falta hacer la restricción sobre en quecuatrimestre está actualmente para que traer solo las calificaciones de ese cuatrimestre
  $consulta_todo = "SELECT mat.nombre as materia, his.calificacion as calificacion
                      FROM historial his
                      INNER JOIN personas per ON per.id = his.id_alumno
                      INNER JOIN materias mat ON mat.id = his.id_materia
                      INNER JOIN alumnos al ON al.id = his.id_alumno
                      where his.id_plan = al.id_plan ;";
 
   //echo $consulta_todo;

//SELECT alumnos.matricula, personas.nombre, personas.paterno, personas.materno, carreras.nombre as carrera, alumnos.promedio_ingreso, alumnos.puntos_ceneval as nombre_carrera FROM alumnos INNER JOIN personas on personas.id = alumnos.id_persona INNER JOIN carreras on carreras.id = alumnos.id_carrera
  $resultado = mysqli_query($conexion, $consulta_todo) or die('Error BD');

 ?>
 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Alumnos</title>

<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>
  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Alumnos>
        <small>Calificaciones:</small>
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
                 <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" >ID materia
                 <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Calificación
                 </th>
               </tr>
                </thead>
                <tbody>

                  <?php
                  //Aqui res son los rowes que extrae y el row es mostrar los rowes
                    while($row=$resultado->fetch_assoc()) {
                      echo "<tr role=\"row\" class=\"odd\">";
                      echo "<td>".$row["materia"]."</td>";
                      echo "<td>".$row["calificacion"]."</td>";
                      //Impoirtante aqui se usa el metodo get para mandarle el row por parametro
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
