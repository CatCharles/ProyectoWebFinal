<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=3){
    header('Location: ../../index.php');
    exit;
  }
  require_once '../dompdf/autoload.inc.php';
  // reference the Dompdf namespace
  use Dompdf\Dompdf;

  $id = $_GET['id'];
  //echo $id;
  $id_maestro = $_GET['id_maestro'];  

  // Valores varios.
  $query = "select 
    `g`.`id` AS `id_grupo`,
    `g`.`clave` AS `cve_gpo`,
    `q`.`descripcion` AS `cuatrimestre`,
    `ca`.`nombre` AS `carrera`,
    `p`.`clave` AS `cve_plan`,    
    `mt`.`nombre` AS `materia`,
    `m`.`nombre_completo` AS `maestro`,    
    `g`.`id_cuatrimestre` AS `id_cuatrimestre`,
    `ca`.`id` AS `id_carrera`,
    `p`.`id` AS `id_plan`,
    `m`.`id` AS `id_maestro`, 
    c.estatus 
    from ((((((`siiupv`.`grupos` `g` join `siiupv`.`clases` `c` on((`g`.`id` = `c`.`id_grupo`))) join `siiupv`.`cuatrimestres` `q` on((`g`.`id_cuatrimestre` = `q`.`id`))) join `siiupv`.`planes_estudio` `p` on(((`g`.`id_carrera` = `p`.`id_carrera`) and (`g`.`id_plan` = `p`.`id`)))) join `siiupv`.`carreras` `ca` on((`p`.`id_carrera` = `ca`.`id`))) join `siiupv`.`vwmaestros` `m` on((`c`.`id_maestro` = `m`.`id`))) join `siiupv`.`materias` `mt` on((`c`.`id_materia` = `mt`.`id`))) 
    where id_maestro = {$id_maestro}";

  $varios = selectEspecial($conexion,$query);

  // Nombre del alumno.
  $query = "select CONCAT(a.paterno,' ',a.materno,' ',a.nombre) as nombre_alumno, a.matricula, b.id_alumno as id_alumno, b.calificacion, b.unidad1, b.unidad2, b.unidad3, b.id_clase as clase from vwalumnos a inner join alumnos_con_clases b on 
            a.id = b.id_alumno where b.id_clase = '{$id}' 
    order by nombre_alumno";

  $res = selectEspecial($conexion,$query);

  $query = "select clave, capacidad, id_grupo, estatus from clases where id='{$id}'";
  $datos_clase = selectEspecial($conexion,$query);
  $datos_clase = $datos_clase->fetch_assoc();

  $query = "select DATE_FORMAT(c.fecha_termino,'%d/%m/%Y') as fecha_termino from cuatrimestres c inner join grupos g on c.id = g.id_cuatrimestre where g.id = '{$datos_clase['id_grupo']}'";
  $fecha_fin = selectEspecial($conexion,$query);
  $fecha_fin = $fecha_fin->fetch_assoc();
  $hoy = date("d/m/Y");

  //echo $hoy . " " . $fecha_fin['fecha_termino'];

  if (isset($_POST['firmar_grupo'])) {
    $query = "update clases
                  set 
                  estatus = 2
                where id = '$id'";    
    $actualizar = crear_registro($conexion,$query);
    if($actualizar){
      redirect('clases_profesor.php');
    }
  }

  if (isset($_POST['submit'])) {

    $query = "select COUNT('contador') as cantidad from vwalumnos a inner join alumnos_con_clases b on 
            a.id = b.id_alumno where b.id_clase = 1";
    $cant_alum = selectEspecial($conexion,$query);

    $cant_alum = $cant_alum->fetch_assoc();  

    for ($i=0; $i < $cant_alum['cantidad'] ; $i++) { 
      $id = $_POST['id'.$i];
      $clase = $_POST['clase'.$i];
      $u1 = $_POST['u1'.$i];
      $u2 = $_POST['u2'.$i];
      $u3 = $_POST['u3'.$i];
      //$calificacion = $_POST['calificacion_f'.$i];
      $calificacion = ($u1 + $u2 + $u3)/3;

      //echo $id . '<br>';
      //echo $clase . '<br>';

      echo $u1 . " " . $u2 . " " . $u3 . "<br>";

      if ($u1 < 70 || $u2 < 70 || $u3 < 70) {
        $calificacion = 60;
      }

      $query = "update alumnos_con_clases
                  set 
                  unidad1 = '$u1', 
                  unidad2 = '$u2', 
                  unidad3 = '$u3',
                  calificacion = '$calificacion'
                where id_alumno = '$id' and id_clase = '$clase'";
        $actualizar = crear_registro($conexion,$query);
    }

    if($actualizar){
      redirect('#');
    }

  }


 ?>
 <!DOCTYPE html> 
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<title>Clases</title>
<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Clases
        <small>Calificar clase <?php echo $datos_clase['clave'] ?>.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Calificar clase <?php echo $datos_clase['clave'] ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row"><div class="col-sm-6"></div>
                <div class="col-sm-6"></div></div>

                <div class="row"><div class="col-sm-12">

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id={$id}&id_maestro={$id_maestro}" ?>" role="form">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                   <tr>
                  <th rowspan="1" colspan="5">
                    <a  href="agregar_grupo.php">
                      <!--<h5><i class="fa fa-fw fa-gears"></i></h5></a>-->
                    </th>
                </tr>
                <tr role="row">
                  <!--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID-->
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Nombre del alumno
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Unidad 1</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Unidad 2</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Unidad 3</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Promedio                  
                  </th>
                </tr>
                </thead>
                <tbody>

                <?php
                  
                  if ($datos_clase['estatus'] == 2) {
                    $estado = "disabled";
                  } else {
                    $estado = "";
                  }
                  
                  $contador = 0;
                  if (!empty($res)) {                  
                    foreach ($res as $dato) {
                      echo "<input value=\"{$dato["id_alumno"]}\" name=\"id{$contador}\" hidden>";
                      echo "<input value=\"{$dato["clase"]}\" name=\"clase{$contador}\" hidden>";  
                      echo "<tr role=\"row\" class=\"odd\">";
                      echo "<td class=\"sorting_2\">".$dato["nombre_alumno"]."</td>";
                      echo "<td><input style=\"width:40px\" type=\"text\" name=\"u1{$contador}\" value=\"{$dato["unidad1"]}\" placeholder=\"\" $estado></td>";
                      echo "<td><input style=\"width:40px\" type=\"text\" name=\"u2{$contador}\" value=\"{$dato["unidad2"]}\" placeholder=\"\" $estado></td>";
                      echo "<td><input style=\"width:40px\" type=\"text\" name=\"u3{$contador}\" value=\"{$dato["unidad3"]}\" placeholder=\"\" $estado></td>";
                      echo "<td><input style=\"width:40px\" type=\"text\" name=\"calificacion_f{$contador}\" value=\"{$dato["calificacion"]}\" disabled></td>";

                      echo "</tr>";
                      $contador++;
                    }
                  }

                ?>                
                <!--<a  href=\"borrar_grupo.php?id=".$clase["id_clase"]."\" type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-fw fa-trash\"></i></a>-->

                   <!--   -->
              </tbody>
                <tfoot>
                <!--<tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>-->

                </tfoot>
              </table> 

                  <div class="box-footer">
                    <?php  ?>
                    <?php if ($datos_clase['estatus'] == 1 && !empty($res)){ ?>                                      
                      <button type="submit" class="btn btn-primary" name="submit">Confirmar</button>                    
                      <?php if ($fecha_fin['fecha_termino'] == $hoy){ ?>                     
                        <button type="submit" class="btn btn-danger" name="firmar_grupo">Firmar grupo</button> 
                      <?php } ?>                            
                    <?php } ?>
                  </div>             

              </form>
              </div></div>
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
