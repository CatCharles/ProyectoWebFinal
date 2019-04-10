<header>

  <style type="text/css">
    .special tr { display: block; float: left; } 
    .special td { display: block} 
  </style>
  
</header>
<?php
  require '../basedatos/conexion.php';

  /*$query = "select pm.id_carrera, pm.id_plan, pm.id_materia, pm.cuatrimestre, pm.creditos, pm.horas_practica, pm.horas_teoricas, m.nombre as nombre_materia, pe.clave, c.nombre from planes_con_materias pm inner join materias m on pm.id_materia = m.id inner join planes_estudio pe on pe.id = pm.id_plan inner join carreras c on c.id = pm.id_carrera where pm.id_carrera = 1 and pm.id_plan = 1";*/
  /*$query = "select pm.id_plan, m.nombre, pm.cuatrimestre from planes_con_materias pm inner join materias m on m.id  = pm.id_materia where pm.id_carrera = 1 and pm.id_plan = 1";*/

  /*select pm.id_plan, m.nombre, pm.cuatrimestre, c.clave, h.dia from planes_con_materias pm inner join materias m on m.id  = pm.id_materia inner join clases c on c.id_materia = pm.id_materia inner join horarios h on h.id_clase = c.id where pm.id_carrera = 1 and pm.id_plan = 1*/

  /*$query = "select pm.id_plan, m.nombre, pm.cuatrimestre, c.clave from planes_con_materias pm inner join materias m on m.id = pm.id_materia inner join clases c on c.id_materia = pm.id_materia where pm.id_carrera = 1 and pm.id_plan = 1 order by pm.cuatrimestre";*/

  //echo $query;                    
  //$res= selectEspecial($conexion,$query);

  session_start();
  $id_alumno = $_SESSION['id'];

  $query = "select h.id_carrera, h.id_plan, h.id_materia, h.calificacion, h.oportunidad, pm.cuatrimestre from historial h inner join planes_con_materias pm on (h.id_carrera = pm.id_carrera and h.id_plan = pm.id_plan and h.id_materia = pm.id_materia) where id_alumno = '". $id_alumno ."'";

  $historial = selectEspecial($conexion, $query);
    if(empty($historial)){}else{
  foreach ($historial as $data) {
    //echo $data['id_materia']." -> ".$data['calificacion'] . '<br>';
  }}

  // Datos institucionales.
  $query = "select id_plan, id_carrera from alumnos where id = '".$id_alumno."' LIMIT 1";
  $plan = selectEspecial($conexion,$query);
  $plan = $plan->fetch_assoc();

  ///echo "Plan de estudios: ".$plan['id_plan'] .  '<br>';

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
        Cargar materias
        <small></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">      
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Cargar materias</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
              <div class="row"><div class="col-sm-6"></div>
              <div class="col-sm-6"></div></div>

              <div class="row"><div class="col-sm-12">

              <table id="example1" class="table table-bordered table-striped special">
                <thead>
                <tr role="row">
                  <!--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID
                  </th>-->
                  <th style="width:150px" class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Primero            
                  </th>
                  <th style="width:150px" class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Segundo
                  </th>
                  <th style="width:150px" class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Tercero
                  </th>
                  <th style="width:150px" class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Cuarto
                  </th>
                  <th style="width:150px" class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Quinto
                  </th>
                  <th style="width:150px" class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="">Sexto
                  </th>

                </tr>
                </thead>
                <tbody id="materias_carrera">
              
                <?php
                  $contador = 0;
                  for ($i=1; $i <= 6; $i++) { 
                    // MODIFICAR ID CARRERA Y EL ID PLAN.
                     $query = "select 
                            m.nombre as nombre, 
                            pm.cuatrimestre as cuatrimestre,

                            c.clave as clave_clase, 
                            c.id as id_clase, 
                            c.id_grupo as id_grupo, 
                            c.id_carrera as id_carrera, 
                            c.id_plan as id_plan, 
                            c.id_materia as id_materia,
                            c.id_maestro as id_maestro

                      from 
                        planes_con_materias pm 
                        inner join materias m on m.id = pm.id_materia 
                        inner join clases c on m.id = c.id_materia  

                      where 
                        pm.id_carrera = '".$plan['id_carrera']."' 
                        and pm.id_plan = '".$plan['id_plan']."' 
                        and pm.cuatrimestre = {$i}
                      
                      order by pm.cuatrimestre";

                    //echo $query . '<br>';
                    //echo " <br>";

                    $res = ''; 
                    $res = selectEspecial($conexion,$query);
                    if ($res) {                      
                      echo "<tr role=\"row\" class=\"odd\">";
                      foreach ($res as $data) {
                        $clv_c = $data['clave_clase'];
                        $id_cl = $data['id_clase'];
                        $id_g = $data['id_grupo'];
                        $id_carr = $data['id_carrera'];
                        $id_mat = $data['id_materia'];
                        $id_tch = $data['id_maestro'];
                        $id_cuat = $data['cuatrimestre'];

                        //echo $clv_c . '<br>';
                        //echo $id_cl . '<br>';
                        //echo '<br>';


                        // Saber historial del alumno.
                        $query = "select h.calificacion, h.oportunidad, pm.cuatrimestre from historial h inner join planes_con_materias pm on (h.id_carrera = pm.id_carrera and h.id_plan = pm.id_plan and h.id_materia = pm.id_materia) where id_alumno = '".$id_alumno."' and pm.id_carrera = '".$plan['id_carrera']."' and pm.id_materia = '".$id_mat."' and pm.id_plan = '".$plan['id_plan']."' and pm.cuatrimestre = '".$i."'";
                        
                        $datos_his = '';

                        $datos_his = selectEspecial($conexion, $query);

                        // Saber que clases esta tomando.                      
                        $query = "select id_clase from alumnos_con_clases where id_clase = '".$id_cl."' and id_alumno = '".$id_alumno."'";

                        //echo $query;                    

                        $clase_tomada = '';

                        $clase_tomada = selectEspecial($conexion, $query);                    

                        $tipo = "btn btn-primary"; // tipo de botón.

                        if ($datos_his) {

                          $datos_his = $datos_his->fetch_assoc();
                          //echo 'Existe valor en '. $clv_c . " - " . $datos_his['calificacion'] . '<br>';

                          if ($datos_his['calificacion'] > 70) {
                            $tipo = "btn btn-success";
                          } else {
                            $tipo = "btn btn-danger";
                          }

                        }

                        if ($clase_tomada) {
                          //echo 'El alumno esta tomando la clase '.$id_c . '<br>';
                          $tipo = "btn btn-warning";
                        }

                        // Se crea el botón.
                        echo "<td style=\"width:150px\"><a id={$data['id_clase']} value =\"{$data['nombre']}\" 
                                onclick=\"cargarDatos(this,'{$clv_c}','{$id_cl}','{$id_g}','{$id_carr}','{$id_mat}',{$id_tch},{$id_cuat},'{$_SESSION['id']}')\" 
                                data-togle=\"modal\" data-target=\"#ventana_materias\" href=\"#\" 
                                class=\"{$tipo}\" style=\"width:150px\" data-toggle=\"modal\"> {$data['nombre']} </a></td>";
                        
                      }
                      echo "</tr>";
                    }
                    
                  }
                  //$opciones = '';

                  //foreach ($res as $data) {
                    //echo "<tr role=\"row\" class=\"odd\">";
                    /*echo "<td class=\"sorting_2\">".$clases["id"]."</td>";*/                    
                      /*if ($data['cuatrimestre'] == $i) {
                        echo "<td><a href=\"#ventana1\" class=\"btn btn-primary btn-lg\" data-toggle=\"modal\">{$data['nombre']}</a></td>";        
                      } else {*/

                    //echo "</tr>";
                  //}
                ?>                   
                </tbody>
                <tfoot>
                  <!--<tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>-->
                </tfoot>              
              </table></div></div>
              </div>            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <!-- /.col -->
      </div>


      <div class="modal fade" id="ventana_materias">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <!-- Header de la ventana. -->
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modla-title">Cargar materias</h4>
           </div>

           <!-- Contenido de la ventana. -->
           <div class="modal-body">
             <p>Universidad Politécnica de Victoria </p>

             <div class="row">      
             <div class="col-xs-12">
             <div class="box">
             <div class="box-header">
             <h3 class="box-title">Seleccione una clase</h3>
             </div>
             <!-- /.box-header -->
             <div class="box-body">
             <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
             <div class="row"><div class="col-sm-6"></div>
             <div class="col-sm-6"></div></div>

             <div class="row"><div class="col-sm-12">
             <table class="table table-bordered table-striped">
              <thead>
                 <tr>
                  <th>Clave de la clase</th>
                  <th>Maestro</th>
                  <th>Lunes</th>
                  <th>Martes</th>
                  <th>Miercoles</th>
                  <th>Jueves</th>
                  <th>Viernes</th>
                  <th>Capacidad</th>
                  <th>Operaciones</th>
                 </tr>
               </thead>
               <tbody id="mvalues">
                  <!-- Ajax: clases -->
               </tbody>
               <tfoot >
                 
                 
               </tfoot>
             </table>
           </div>
           </div>
           </div>
           </div>
           </div>
           </div>

          </div>
                     <!-- Footer de la ventana. -->
           <div class="modal-footer" id="eliminar">

             <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
             <button type="button" onclick="leerDatos(<?php echo $_SESSION['id'] ?>)" class="btn btn-default" data-dismiss="modal">Guardar cambios</button>
             
           </div>
        </div>                  
      </div>
    </div>
  </div>
  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php require '../menus/footer.php' ?>

</div>

<script type="text/javascript" src="script.js"></script>

</body>
</html>
