<?php
  require '../basedatos/conexion.php';
require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
		exit;
  }
    $table = 'planes_con_materias';
    $errores = '';

    //Querys para llenar los campos requeridos.

    $query = 'select id,nombre from carreras';
    $carreras = selectEspecial($conexion,$query);

    $quer = 'select id,clave from planes_estudio';
    $planes = selectEspecial($conexion,$quer);
    
    $quer = 'select id,nombre from materias';
    $materias = selectEspecial($conexion,$quer);
    $agregar = "falso";
    
    if(isset($_POST['submit'])){

        $materia = strtoupper($_POST['materia']);
        $carrera = $_POST['carrera'];
        $plan = $_POST['plan'];
        $creditos = $_POST['creditos'];
        $practicas = $_POST['practicas'];
        $cuatrimestre = $_POST['cuatrimestre'];
        $teoricas = $_POST['teoricas'];



        if(empty($materia)){
          $errores = 'Dame tu clave <br/>';
        }

        if(empty($carrera) || $carrera=="0"){
          $errores .= 'Dame tu carrera <br/>';
        }

        if(empty($plan)){
          $errores .= 'Dame tu plan <br/>';
        }

        
        if(empty($cuatrimestre)){
          $errores .= 'Dame tu cuatrimestre2 <br/>';
        }
        if(empty($creditos)){
          $errores .= 'Dame tu cuatrimestre3 <br/>';
        }
        if(empty($teoricas)){
          $errores .= 'Dame tu cuatrimestre3 <br/>';
        }
        if(empty($practicas)){
          $errores .= 'Dame tu cuatrimestre3 <br/>';
        }
   		
        
       if(empty($errores)){
          $query = "insert into {$table}(`id_carrera`, `id_plan`, `id_materia`, `cuatrimestre`, `creditos`, `horas_practica`, `horas_teoricas`)  values ('{$carrera}','{$plan}','{$materia}','{$cuatrimestre}','{$creditos}', '{$practicas}', '{$teoricas}');";
          $agregar = crear_registro($conexion,$query);
        echo "Llave repetida, este plan con clase ya fue agregado". "<br>";
          echo $query;
          if($agregar){
            redirect('planesconmaterias.php');

          }else{
          	
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
<title>Agregar materias al plan de estudio</title>
<?php require '../menus/head.php' ?>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Agregar
        <small>Materias para el plan.</small>
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
              <h3 class="box-title">Agregar materias al plan de estudio.</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" align="">
              <!-- form start -->
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
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
                                        
                </select>

            	</div>
            	<div class="form-group">
                    <label for="exampleInputPassword1">Plan de estudio</label>
                    <select class="form-control" name="plan" id="select2_plan">
                     <!-- <?php 
                        foreach ($planes as $v) { ?>
                          <option value="<?php echo (int)$v["id"] ?>">
                          <?php echo $v["clave"] ?></option>   
                      <?php  }
                      ?>
                            -->                
                    </select>
                  </div>
                  <div class="form-group">
	                <label for="exampleInputPassword1">Materia</label>
	                 <select class="form-control" name="materia" id="select2_materia">
	                  <?php 
	                    foreach ($materias as $v) { ?>
	                      <option value="<?php echo (int)$v["id"] ?>">
	                      <?php echo utf8_encode($v["nombre"]) ?></option>   
	                  <?php  }
	                  ?>             
	                </select>
	                </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Cuatrimestre</label>
                    <input type="number" class="form-control" name="cuatrimestre" id="cuatrimestre" max="10"  min="0" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Creditos</label>
                    <input type="number" class="form-control" name="creditos" id="creditos" max="9"  min="2" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Horas prácticas</label>
                    <input type="number" class="form-control" name="practicas"  id="practicas" min="1" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Horas teoricas</label>
                    <input type="number" class="form-control" name="teoricas" id="teoricas"  min="2" required>
                  </div>

                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="submit" id="agregarplanmateria" >Agregar
                  </button>
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
 

</body>
</html>