<?php
  require '../basedatos/conexion.php';
require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
		exit;
  }
    $table = 'planes_estudio';
    $errores = '';

    //Querys para llenar los campos requeridos.

    $query = 'select id,nombre from carreras';
    $carreras = selectEspecial($conexion,$query);

    $quer = 'select MAX(id)+1 as max from planes_estudio';
    $maximo = selectEspecial($conexion,$quer);
    
    foreach ($maximo as $m) {
      # code...
      $maxi = $m["max"];
      }

    if(isset($_POST['submit'])){

        $clave = strtoupper($_POST['clave']);
        $carrera = $_POST['carrera'];
        $fecha_inicio = $_POST['inFecha_inicio'];
        $fecha_termino = $_POST['inFecha_termino'];
        $activo = $_POST['Activo'];
        $cuatrimestre = $_POST['cuatris'];

        if(empty($clave)){
          $errores = 'Dame tu clave <br/>';
        }

        if(empty($carrera)){
          $errores .= 'Dame tu carrera <br/>';
        }

        if(empty($fecha_inicio)){
          $errores .= 'Dame tu plan <br/>';
        }

        
        if(empty($cuatrimestre)){
          $errores .= 'Dame tu cuatrimestre2 <br/>';
        }
        if(empty($activo)){
          $errores .= 'Dame tu cuatrimestre3 <br/>';
        }

        if(empty($errores)){
          if(!empty($fecha_termino)){
            $query = "insert into {$table}(`id`, `clave`, `fecha_inicio`, `fecha_termino`, `activo`, `numero_cuatrimestres`, `id_carrera`)  values ('{$maxi}','{$clave}','{$fecha_inicio}','{$fecha_termino}','{$activo}', '{$cuatrimestre}', '{$carrera}');";
          }else{
          $query = "insert into {$table}(`id`, `clave`, `fecha_inicio`, `activo`, `numero_cuatrimestres`, `id_carrera`)  values ('{$maxi}','{$clave}','{$fecha_inicio}','{$activo}', '{$cuatrimestre}', '{$carrera}');";
            
          }
          $agregar = crear_registro($conexion,$query);
          echo $query;
          if($agregar){
            redirect('planes.php');
          }
        }
        echo $errores;
    }
 ?>
 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Agregar plan de estudio</title>
<?php require '../menus/head.php' ?>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Planes de estudio
        <small>Nuevo plan de estudio.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
<div class="row" >
        <div class="col-xs-6">
          <div class="box box-primary" >
            <div class="box-header">
              <h3 class="box-title">Agregar Plan de estudios.</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" align="">
              <!-- form start -->
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Clave</label>
                    <input type="text" class="form-control" name="clave" placeholder="Ingrese el ID ej. ITI-2010" required>
                  </div>
                  <!-- Date -->
              <div class="form-group">
                <label>Fecha de inicio:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="datepicker" name="inFecha_inicio" style="line-height: 1;" required >
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Fecha de termino:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="datepicker2" name="inFecha_termino" style="line-height: 1;">
                </div>
                <!-- /.input group -->
              </div>
                   
                  <div class="form-group">
                    <label for="exampleInputPassword1">Activo</label>
                    <select class="form-control" name="Activo" id="select2_activo" required>
                      <option value="1">Sí</option>
                      <option value="0">No</option>           
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">N° de cuatrimestres:          </label>
                    <input type="number" name="cuatris" max="10" min="8" value="8" required style="width: 45px;text-align: center;">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Carrera</label>
                     <select class="form-control" name="carrera" id="select2_carrera">
                      <?php 
                        foreach ($carreras as $v) { ?>
                          <option value="<?php echo (int)$v["id"] ?>">
                          <?php echo utf8_encode($v["nombre"]) ?></option>   
                      <?php  }
                      ?>
                                            
                    </select>

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