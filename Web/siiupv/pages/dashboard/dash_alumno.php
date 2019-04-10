<?php
  require '../basedatos/conexion.php';
  $res= select($conexion,'cuatrimestres');
  require '../sesion/abre_sesion.php';
  if($_SESSION['tipo']!=4){
    header('Location: index.php');
		exit;
  }

  $usuario = $_SESSION['usuario'];
  $query_id = "SELECT alumnos.id AS id_a, personas.id, usuarios.username FROM usuarios INNER JOIN personas INNER JOIN alumnos WHERE usuarios.username = '" . $usuario . "' AND usuarios.id_persona = personas.id AND alumnos.id_persona = personas.id";
  $id_s = mysqli_query($conexion,$query_id);
  //session_start();
  while($id = $id_s->fetch_assoc()) {
    $_SESSION['id'] = $id['id_a'];
  }
  
$query="Select count(*) as cant from carreras";
  $carreras = selectEspecial($conexion,$query);
  $query="Select count(*) as cant from alumnos";
  $alumnos = selectEspecial($conexion,$query);
  $query="Select count(*) as cant from maestros";
  $maestros = selectEspecial($conexion,$query);
  $query="Select count(*) as cant from aulas";
  $aulas = selectEspecial($conexion,$query);



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

<html>

<title>Inicio</title>

<?php require '../menus/head.php' ?>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

        <div class="">
          <h1>SisUPV</h1>
        </div>
         <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('fondo.jpg') center center;">
              <h3 class="widget-user-username" style="color:black;"><?php 
          while($datos = $resultado->fetch_assoc()){
    #array_push($misaccesorios, $datos);
              echo $datos['nombre'] . " " . $datos['paterno'] . " ". $datos['materno'];
            }        
        ?></h3>
              <h5 class="widget-user-desc">Alumno</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="/Web/siiupv/dist/img/profile.ico" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="small-box bg-aqua">
            <div class="inner">
              <h3><i class="fa fa-bookmark"></i> </h3>

              <p>Horario</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="../../pages/horario_clases_alumno/ver.php" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="small-box bg-green">
            <div class="inner">
              <h3><i class="fa fa-graduation-cap"></i></h3>

              <p>Calificaciones</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-bookmark"></i>
            </div>
            <a href="../../pages/calificacioneshistorial/calificaciones.php" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                   <div class="small-box bg-yellow">
            <div class="inner">
              <h3><i class="fa fa-calendar"></i></h3>

              <p>Historial</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-briefcase"></i>
            </div>
            <a href="../../pages/calificacioneshistorial/historial.php" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <div class="row">
       
        <!-- ./col -->
        
        <!-- ./col -->
        
        <!-- ./col -->
       
        <!-- ./col -->
      </div>


      <!-- /.col -->
        <div >
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Universidad Politécnica de Victoria</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  
                </ol>
                <div class="carousel-inner">
                  <div class="item active" align="center">
                    <img src="carousel1.png" align="center" alt="First slide">

                    <div class="carousel-caption">
                      1
                    </div>
                  </div>
                  <div class="item" align="center">
                    <img src="carousel2.jpg" align="center" alt="Second slide">

                    <div class="carousel-caption">
                      2
                    </div>
                  </div>
                  </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <!-- /.col -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php require '../menus/footer.php' ?>

</div>

</body>
</html>
