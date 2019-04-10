<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=4){
    header('Location: ../../index.php');
    exit;
  }
  $res= select($conexion,'alumnos');


  if (isset($_SESSION['id'])) {
    $dato = $_SESSION['id'];
  }
  //session_destroy();

  //$dato = $_GET['id'];
  

  //$consulta_todo = "SELECT 'alumnos.matricula', 'personas.nombre', 'personas.paterno', 'personas.materno', 'carreras.nombre' as carrera, 'alumnos.promedio_ingreso', 'alumnos.puntos_ceneval' as nombre_carrera FROM alumnos INNER JOIN personas on 'personas.id' = 'alumnos.id_persona' INNER JOIN carreras on 'carreras.id' = 'alumnos.id_carrera'";

  $consulta_todo = "SELECT "."alumnos.id AS id, alumnos.matricula AS mat, personas.id AS id_p, personas.nombre AS nombre, personas.paterno AS paterno, personas.materno AS materno FROM alumnos INNER JOIN personas WHERE alumnos.id = " . $dato . " AND personas.id = alumnos.id_persona";


 // echo $consulta_todo;


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
        <?php 
          while($datos = $resultado->fetch_assoc()){
    #array_push($misaccesorios, $datos);
              echo $datos['nombre'] . " " . $datos['paterno'] . " ". $datos['materno'];
            }        
        ?>
        <small>Horario</small>
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
              <h3 class="box-title">Horario</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row"><div class="col-sm-6"></div>
                <div class="col-sm-6"></div></div>

                <div class="row"><div class="col-sm-12">


                  <table id="example1" class="table table-bordered table-striped">
                <thead>
                 <tr role="row">
                    <!--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" >-->
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Materia
                      </th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Maestro
                      </th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Lunes
                      </th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Martes
                      </th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Miercoles
                      </th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Jueves
                      </th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Viernes
                      </th>
                    <!--</th>-->
                    
                  </tr>
                </thead>
                <tbody>
                    
                  <?php
                  //Aqui res son los rowes que extrae y el row es mostrar los rowes
                    $query_clase = "SELECT id_clase FROM alumnos_con_clases WHERE id_alumno =". $dato;
                    $clases = mysqli_query($conexion, $query_clase) or die('Error clases');
                    while($clase=$clases->fetch_assoc()) {

                      $query_clase_uno = "SELECT clave, id_materia, id_maestro FROM clases WHERE id =". $clase['id_clase'];
                      $clase_uno = mysqli_query($conexion, $query_clase_uno) or die('Error clases'); 
                      while ($uno = $clase_uno->fetch_assoc()) {
                        
                        //materia
                        $query_materia = "SELECT nombre FROM materias WHERE id =". $uno['id_materia'];
                        $materias = mysqli_query($conexion, $query_materia) or die('Error materias'); 
                        while ($materia = $materias->fetch_assoc()) {
                          echo "<tr><th>" . $materia['nombre'] ."  </th>"; 
                        }

                        //maestro
                        $query_maestro = "SELECT id_persona FROM maestros WHERE id =". $uno['id_maestro'];
                        $maestros = mysqli_query($conexion, $query_maestro) or die('Error maestros'); 
                        while ($maestro = $maestros->fetch_assoc()) {
                          $nombre_profe = "SELECT nombre, paterno, materno FROM personas WHERE id=" . $maestro['id_persona'];
                          $profe = mysqli_query($conexion, $nombre_profe) or die ('Error nombre profe'); 
                          while ($nom = $profe->fetch_assoc()) {
                            echo "<td>" . $nom['nombre'] . " " . $nom['paterno'] . " " . $nom['materno'] ."  </td>";    
                          }
                        }

                        //horario
                        $query_horarios = "SELECT * FROM horarios WHERE id_clase=" . $clase['id_clase'];
                        $horarios = mysqli_query($conexion, $query_horarios) or die ('Error horarios'); 
                        while ($dia = $horarios->fetch_assoc()) {
                          switch ($dia['dia']) {
                            //lunes
                            case '1':
                              echo "<td>". $dia['hora_inicio'] . " - " . $dia['hora_fin']."</td>";
                              break;
                            case '2':
                              echo "<td>". $dia['hora_inicio'] . " - " . $dia['hora_fin']."</td>";
                              break;
                            case '3':
                              echo "<td>". $dia['hora_inicio'] . " - " . $dia['hora_fin']."</td>";
                              break;
                            case '4':
                              echo "<td>". $dia['hora_inicio'] . " - " . $dia['hora_fin']."</td>";
                              break;
                            case '5':
                              echo "<td>". $dia['hora_inicio'] . " - " . $dia['hora_fin']."</td>";
                              break;
                            default:
                              # code...
                              break;
                          }
                        }
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
