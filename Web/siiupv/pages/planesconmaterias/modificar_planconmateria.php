<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
    exit;
  }
  $dato = $_GET['id'];
  $query="SELECT * FROM planes_con_materias WHERE CONCAT(id_carrera,id_plan,id_materia) =".$dato;
  $res = selectEspecial($conexion,$query);

    $query = 'select id,nombre from carreras';
    $carreras = selectEspecial($conexion,$query);

    $query = 'select id,clave from planes_estudio';
    $planes = selectEspecial($conexion,$query);

    $query = 'select id,descripcion from cuatrimestres';
    $cuatrimestres = selectEspecial($conexion,$query);

    $query = 'select id,nombre from materias';
    $materias = selectEspecial($conexion,$query);
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

        if(empty($carrera)){
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
        $query = "update planes_con_materias SET id_carrera ='{$carrera}', id_plan='{$plan}',id_materia='{$materia}',cuatrimestre='{$cuatrimestre}',  creditos='{$creditos}', horas_practica='{$practicas}',horas_teoricas='{$teoricas}' WHERE CONCAT(id_carrera,id_plan,id_materia)={$dato}";
        $actualizar = crear_registro($conexion,$query); 
        echo $query;
        echo "Llave repetida, este plan con clase ya fue agregado";
        if($actualizar){
          redirect('planesconmaterias.php');
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
<title>Modificar asignación de materia</title>
<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Planes de estudio con materia
        <small>Editar plan con materia.</small>
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
                <!--carreras-->
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
              <!--plan-->
              <div class="form-group">
                  <label for="exampleInputPassword1">Plan de estudio</label>
                    <select class="form-control" name="plan" id="select2_plan">
                      <?php 
                      foreach ($planes as $v) { 
                      if($cuatri['id_plan'] == $v['id']){ 
                        ?>
                        <option value="<?php echo (int)$v["id"] ?>" selected>
                        <?php echo ($v["clave"]) ?></option>  
                        <?php 
                      }else{ ?> 
                        <option value="<?php echo (int)$v["id"] ?>" >
                        <?php echo ($v["clave"]) ?></option>
                        <?php 
                         } 
                     ?>
                    <?php 
                       }
                    ?>
                         
                                            
                    </select>
              </div>
              <!--materias-->
              <div class="form-group">
                  <label for="exampleInputPassword1">Materia</label>
                   <select class="form-control" name="materia" id="select2_materia">
                    <?php 
                      foreach ($materias as $v) { 
                        if($cuatri['id_materia'] == $v['id']){
                        ?>
                        <option value="<?php echo (int)$v["id"] ?>" selected>
                        <?php echo utf8_encode($v["nombre"]) ?></option>
                      <?php 
                    } else {?>
                        <option value="<?php echo (int)$v["id"] ?>">
                        <?php echo utf8_encode($v["nombre"]) ?></option>   
                    <?php  }
                  }
                    ?>             
                  </select>
                  </div>
              <!--cuatris-->
              <div class="form-group">
                    <label for="exampleInputEmail1">Cuatrimestre</label>
                    <input type="number" class="form-control" name="cuatrimestre" max="10"  min="0" required value="<?php echo $cuatri['cuatrimestre'] ?>">
              </div>
              <!--creditos-->
              <div class="form-group">
                    <label for="exampleInputEmail1">Creditos</label>
                    <input type="number" class="form-control" name="creditos" max="9"  min="2" required value="<?php echo $cuatri['creditos'] ?>">
              </div>
              <!--practicas-->
              <div class="form-group">
                    <label for="exampleInputEmail1">Horas prácticas</label>
                    <input type="number" class="form-control" name="practicas"   min="1" required value="<?php echo $cuatri['horas_practica'] ?>">
              </div>
              <!--teoricas-->
              <div class="form-group">
                    <label for="exampleInputEmail1">Horas teoricas</label>
                    <input type="number" class="form-control" name="teoricas"   min="2" required value="<?php echo $cuatri['horas_teoricas'] ?>">
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
      </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php require '../menus/footer.php' ?>

</div>

  <script type="text/javascript" src="script.js"></script> 
</body>
</html>
