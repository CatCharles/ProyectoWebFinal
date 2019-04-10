<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }
  

    $table = 'materias';
    $errores = '';

    if(isset($_POST['submit'])){
        $nombre = $_POST['nombre'];
        $nombreCorto = $_POST['nombreCorto'];

        if(empty($nombre)){
          $errores = 'Dame tu nombre <br/>';
        }
        if(empty($nombreCorto)){
          $errores = 'Dame tu nombreCorto <br/>';
        }
        if(empty($errores)){
          $query = "insert into materias (nombre, nombre_corto) values ('$nombre','$nombreCorto');";
          $agregar = crear_registro($conexion,$query);
          if($agregar){
            redirect('materias.php');
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
<title>Agregar materia</title>
<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Materias
        <small>Nueva materia.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">


        <div class="row" >
        <div class="col-xs-6">
          <div class="box" >
            <div class="box-header">
              <h3 class="box-title">Agregar Materia</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" align="">
              <!-- form start -->
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                <div class="box-body">
               
                  <div class="form-group">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre de materia" maxlength=30 required>
                  </div>
                  <div class="form-group">
                    <label for="">Nombre Corto</label>
                    <input type="text" class="form-control" name="nombreCorto" placeholder="Ingrese el nombre de materia corto" maxlength=10 required>
                  </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="submit">Agregar</button>
                </div>
              </form>
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
