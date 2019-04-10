<?php
  require '../basedatos/conexion.php';
require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
    exit;
  }
    $table = 'seriacion';
    $errores = '';

    //Querys para llenar los campos requeridos.

    $query = 'select id,nombre from carreras';
    $carreras = selectEspecial($conexion,$query);

    $quer = 'select id,clave from planes_estudio';
    $planes = selectEspecial($conexion,$quer);
    
    $quer = 'select id,nombre from materias';
    $materias = selectEspecial($conexion,$quer);
   
   // $agregar = "falso";
    
    if(isset($_POST['submit'])){
       // var_dump($_POST);
        $materia = strtoupper($_POST['materia']);
        $carrera = $_POST['carrera'];
        $plan = $_POST['plan'];
        $materiarequerida= $_POST['materiarequerida'];

        if(empty($materia)){
          $errores = 'Dame tu clave <br/>';
        }

        if(empty($carrera) || $carrera=="0"){
          $errores .= 'Dame tu carrera <br/>';
        }

        if(empty($plan) || $plan =="0"){
          $errores .= 'Dame tu plan <br/>';
        }
        if(empty($materiarequerida)){
          $errores .= 'Dame tus materias <br/>';
        }



       if(empty($errores)){
        for($i=0; $i<count($materiarequerida); $i++){
          if($materiarequerida[$i] == $materia){}else{
          $query = "insert into {$table}(`id_carrera`, `id_plan`, `id_materia`, `id_materia_requerida`)  values ('{$carrera}','{$plan}','{$materia}','{$materiarequerida[$i]}');";
          echo "<br>".$query."<br>";
          $agregar = crear_registro($conexion,$query);
        }
        }          
          //if($agregar){
           // redirect('seriacion.php');
            //redirect('agregar_seriacion.php');

          //}
        }
        
       // echo $errores;
        
    }

 ?>
 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Agregar materias al plan de estudio</title>
<?php require '../menus/head.php' ?>

  <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Agregar
        <small>Seriacion.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
<div class="row" >

    <div class="col-xs-6">
          <div class="box box-primary" >
            <div class="box-header">
              <h3 class="box-title">Agregar materias requeridas.</h3></div>
            <!-- /.box-header -->
        <div class="box-body" align="">
              <!-- form start -->
           
              <div class="box-body">
            	<div class="form-group">
                <label for="exampleInputPassword1">Carrera</label>
                 <select class="form-control" name="carrera" id="select2_carrera">
                  <option value="0">Seleccione una carrera.</option>
                  <?php 
                    foreach ($carreras as $v) { ?>
                      <option value="<?php echo (int)$v["id"] ?>">
                      <?php echo utf8_encode($v["nombre"]) ?></option>   
                  <?php  }
                  ?>
                                        
                </select></div>
            	<div class="form-group">
                    <label for="exampleInputPassword1">Plan de estudio</label>
                    <select class="form-control" name="plan" id="select2_plan" >
                     <!-- <?php 
                        foreach ($planes as $v) { ?>
                          <option value="<?php echo (int)$v["id"] ?>">
                          <?php echo $v["clave"] ?></option>   
                      <?php  }
                      ?>
                            -->                
                    </select></div>
              <div class="form-group">
	                <label for="exampleInputPassword1">Materia</label>
	                 <select class="form-control" name="materia" id="select2_materia">
	                  <?php 
	                    foreach ($materias as $v) { ?>
	                      <option value="<?php echo (int)$v["id"] ?>">
	                      <?php echo utf8_encode($v["nombre"]) ?></option>   
	                  <?php  }
	                  ?>             
	                </select></div>
             <!-- /.box-body -->

              <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="submit" id="agregar1" >Agregar
                  </button></div>
                

        </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
  </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <div class="box box-primary" >
            <div class="box-header">
              <h3 class="box-title">Agregar materias requeridas.</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" align="">
              <!-- form start -->
             
          <div class="box-body">
              
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Seleccionar materias requeridas</label>
                <select class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                        style="width: 100%;" name="materiarequerida[]">
                        
                    <?php 
                      foreach ($materias as $v) { ?>
                        <option value="<?php echo (int)$v["id"] ?>">
                        <?php echo utf8_encode($v["nombre"]) ?></option>   
                    <?php  }
                    ?>       
                </select>
              </div>
             
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
                 
              
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <!-- /.col -->

<!--div row-->
</div>

</form>

   </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php require '../menus/footer.php' ?>

</div> 

<!-- Modal -->
<div class='modal modal-warning fade in' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='myModalLabel'>Modal title</h4>
      </div>
      <div class='modal-body'>
        ...
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-outline pull-left' data-dismiss='modal'>Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="script.js"></script>
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
 
  })
</script>

</body>
</html>