<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
    exit;
  }
  $dato = $_GET['id'];
  $res= obtener_resultado_por_id($conexion,$dato,'planes_estudio');

    $query = 'select id,nombre from carreras';
    $carreras = selectEspecial($conexion,$query);


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
        $query = "update planes_estudio SET clave ='{$clave}', fecha_inicio='{$fecha_inicio}',fecha_termino='{$fecha_termino}',activo='{$activo}',  numero_cuatrimestres='{$cuatrimestre}', id_carrera='{$carrera}' WHERE id={$dato}";
        $actualizar = crear_registro($conexion,$query); 
        echo $query;
        if($actualizar){
          redirect('planes.php');
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
<title>Modificar plan</title>
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
        <small>Editar plan.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

     <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Modificar plan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id={$dato}" ?>" role="form">
              <?php foreach ($res as $cuatri) {  ?>

              <div class="box-body">
              <div class="form-group">

                  <label for="">Clave</label>
                  <input type="text" class="form-control" name="clave" placeholder="Ingrese la clave" value=" <?php echo $cuatri["clave"]?> " required>
              </div>
              <div class="form-group">
                  <label for="exampleInputPassword1">Carrera</label>
                   <select class="form-control" name="carrera" id="select2_carrera">
                    <?php 
                      foreach ($carreras as $v) { 
                      if($cuatri['id_carrera'] == $v['id']){ 
                        ?>
                        <option value="<?php echo (int)$v["id"] ?>" selected>
                        <?php echo utf8_encode($v["nombre"]) ?></option>  
                        <?php 
                      }else{ ?> 
                        <option value="<?php echo (int)$v["id"] ?>" >
                        <?php echo utf8_encode($v["nombre"]) ?></option>
                        <?php 
                         } 
                     ?>
                    <?php 
                       }
                    ?>
                                            
                    </select>
                  </div>
                 <!-- Date -->
              <div class="form-group">
                <label>Fecha de inicio:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="datepicker" name="inFecha_inicio" style="line-height: 1;" value="<?php echo $cuatri['fecha_inicio'] ?>" >
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                <label>Fecha de termino:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control pull-right" id="datepicker2" name="inFecha_termino" style="line-height: 1;" value="<?php echo $cuatri['fecha_termino'] ?>">
                </div>
                <!-- /.input group -->
              </div>
              <div class="form-group">
                    <label for="exampleInputPassword1">Activo</label>
                    <select class="form-control" name="Activo" id="select2_activo" required>
                      <?php if($cuatri['activo==1']){ ?>
                      <option value="1" selected>Sí</option>
                    <?php } else{ ?>
                      <option value="1">Sí</option>
                    <?php } ?>

                    <?php if($cuatri['activo==0']){ ?>
                      <option value="0" selected>Sí</option>
                    <?php } else{ ?>
                      <option value="0">No</option>
                    <?php } ?>
                             
                    </select>
              </div>
              <div class="form-group">
                    <label for="exampleInputPassword1">N° de cuatrimestres:          </label>
                    <input type="number" name="cuatris" max="10" min="8" value="<?php echo $cuatri['numero_cuatrimestres'] ?>" required style="width: 45px;text-align: center;">
              </div>


              </div>
              <!-- /.box-body -->
      <?php } ?>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="submit">Modificar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
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

<?php require 'select2.php' ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#select2_plan').select2();
    $('#select2_cuatri').select2();
    $('#select2_carrera').select2();

  });
</script>