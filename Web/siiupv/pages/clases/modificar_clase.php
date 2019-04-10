<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=2){
    header('Location: ../../index.php');
    exit;
  }

  $dato = $_GET['id'];
  $res= obtener_resultado_por_id($conexion,$dato,'clases');
  
  $query = 'select id, clave from grupos';
  $grupos = selectEspecial($conexion,$query);

  $query = 'select id, nombre from carreras';
  $carreras = selectEspecial($conexion,$query);

  $query = 'select id, clave from planes_estudio';
  $planes = selectEspecial($conexion,$query);

  $query = 'select id, nombre from materias';
  $materias = selectEspecial($conexion,$query);
  
  $query = 'select ma.id as id,UPPER(CONCAT(per.nombre," " ,per.paterno," " ,per.materno)) as nombre from maestros ma inner join personas per ON ma.id_persona = per.id';
  $maestros = selectEspecial($conexion,$query);

  if(isset($_POST['submit'])){

      $id = $_POST['id'];
      $clave = $_POST['clave'];
      $capacidad = $_POST['capacidad'];
      $id_grupo = $_POST['grupo'];
      $id_carrera = $_POST['carrera'];
      $id_plan = $_POST['plan_estudio'];
      $id_materia = $_POST['materia'];
      $id_maestro = $_POST['maestro'];


        if(empty($id)){
          $errores = 'Ingresa el ID del grupo. <br/>';
        }

        if(empty($clave)){
          $errores = 'Ingresa una clave de grupo. <br/>';
        }

        if(empty($capacidad)){
          $errores = 'Ingresa una capacidad de grupo. <br/>';
        }

        if(empty($id_grupo)){
          $errores = 'Ingresa el identificador de un grupo. <br/>';
        }

        if(empty($id_carrera)){
          $errores = 'Ingresa el identificador de una carrera. <br/>';
        }

        if(empty($id_plan)){
          $errores = 'Ingresa el identificador de un plan. <br/>';
        }       

        if(empty($id_materia)){
          $errores = 'Ingresa el identificador de una materia. <br/>';
        } 
        if(empty($id_maestro)){
          $errores = 'Ingresa el identificador de una materia. <br/>';
        }

      if(empty($errores)){
        $query = "update clases SET clave='{$clave}',capacidad='{$capacidad}',id_grupo='{$id_grupo}',id_carrera='{$id_carrera}',id_plan='{$id_plan}', id_materia='{$id_materia}', id_maestro = '{$id_maestro}' WHERE id={$id}";
        echo $query;
        $actualizar = crear_registro($conexion,$query); 
        if($actualizar){
          redirect('clases.php');
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
<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

     <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Modificar clase</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id={$dato}" ?>" role="form">
              <?php foreach ($res as $clase) {    ?>
              <div class="box-body">
                <div class="form-group">
                  <!--<label for="">ID</label>-->
                  <input type="hidden" class="form-control" name="id" placeholder="Ingrese el ID" value=" <?php echo $clase["id"]?> " required readonly>
                </div>

                <div class="form-group">
                  <label for="">clave</label>
                  <input type="text" class="form-control" name="clave" placeholder="Ingrese una clave" value="<?php echo $clase["clave"]?>" required>
                </div>
                 
                <div class="form-group">
                  <label for="">capacidad</label>
                  <input type="text" class="form-control" name="capacidad"   value="<?php echo $clase["capacidad"]?>" required>
                </div>
                
                <div class="form-group">
                  <label for="">Grupo</label>

                  <select class="form-control" name="grupo" id="select2_grupo">
                    <?php 
                      foreach ($grupos as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo $v["clave"] ?></option>   
                    <?php  }
                    ?>
                                          
                  </select>

                </div>
                <div class="form-group">
                  <label for="">Carrera</label>

                  <select class="form-control" name="carrera" id="select2_carrera">
                    <?php 
                      foreach ($carreras as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo utf8_encode(($v["nombre"])) ?></option>   
                    <?php  }
                    ?>
                                          
                  </select>

                </div>
                <div class="form-group">
                  <label for="">Plan</label>

                  <select class="form-control" name="plan_estudio" id="select2_plan">
                    <?php 
                      foreach ($planes as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo $v["clave"] ?></option>   
                    <?php  }
                    ?>
                                          
                  </select>

                </div>
                <div class="form-group">
                  <label for="">Materias</label>

                  <select class="form-control" name="materia" id="select2_materia">
                    <?php 
                      foreach ($materias as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo utf8_encode($v["nombre"]) ?></option>   
                    <?php  }
                    ?>
                                          
                  </select>


                </div>
                
                 <div class="form-group">
                  <label for="">Maestros</label>

                  <select class="form-control" name="materia" id="select2_maestro">
                    <?php 
                      foreach ($maestros as $v) { ?>
                        <option value="<?php echo $v["id"]?>">
                        <?php echo utf8_encode($v["nombre"]) ?></option>   
                    <?php  }
                    ?>
                                          
                  </select>


                </div>

              </div>
              <!-- /.box-body -->
                <?php } ?>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="submit">Guardar</button>
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

