<?php
  require '../basedatos/conexion.php';
  $res= select($conexion,'cuatrimestres');
  require '../sesion/abre_sesion.php';
  if($_SESSION['tipo']!=2){
    header('Location: index.php');
		exit;
  }
  $query="Select count(*) as cant from carreras";
  $carreras = selectEspecial($conexion,$query);
  $query="Select count(*) as cant from grupos";
  $alumnos = selectEspecial($conexion,$query);
  $query="Select count(*) as cant from clases";
  $maestros = selectEspecial($conexion,$query);
  $query="Select count(*) as cant from planes_estudio";
  $aulas = selectEspecial($conexion,$query);
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
         <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('fondo.jpg') center center;">
              <h3 class="widget-user-username" style="color:black;">Director de Carrera</h3>
              <h5 class="widget-user-desc">Director</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="/Web/siiupv/dist/img/profile.ico" alt="User Avatar">
            </div>
            <div class="box-footer">
          <div class="row">
      <div class="col-sm-4 border-right">
        <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php foreach($maestros as $v){echo $v["cant"];} ?></h3>

              <p>Clases</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="../../pages/clases/clases.php" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
                  <!-- /.description-block -->
                </div>

                <!-- /.col -->
                <div class="col-sm-4 border-right">

                                <!-- small box -->
                        <div class="small-box bg-green">
                          <div class="inner">
                            <h3><?php foreach($alumnos as $v){echo $v["cant"];} ?><sup style="font-size: 20px"></sup></h3>

                            <p>Grupos</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-android-bookmark"></i>
                          </div>
                          <a href="../../pages/grupos/grupo.php" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                    <!-- small box -->
                      <div class="small-box bg-red">
                        <div class="inner">
                          <h3><?php foreach($aulas as $v){echo $v["cant"];} ?></h3>

                          <p>Planes de estudio</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-ios-bookmarks"></i>
                        </div>
                        <a href="../../pages/planes/planes.php" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
                      </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->

              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        
        <div class="row">
       
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
                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
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
                  <div class="item" align="center">
                    <img src="carousel3.png"  align="center" alt="Third slide">

                    <div class="carousel-caption">
                      3
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
