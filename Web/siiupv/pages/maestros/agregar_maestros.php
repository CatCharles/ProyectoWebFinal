

<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }

  $carrera= select($conexion,'carreras');
  $errores = '';

  if(isset($_POST['submit'])){

      $curp = $_POST['curp'];
      $nombre = $_POST['nombre'];
      $paterno = $_POST['paterno'];
      $materno = $_POST['materno'];
      $nss = $_POST['nss'];
      $correo = $_POST['correo'];
      $movil = $_POST['movil'];
      $casa = $_POST['casa'];
      $fecha = $_POST['fecha'];
      $numero = $_POST['numero'];
      $grado = $_POST['grado'];
      $tipo = $_POST['tipo'];
      $carrera = $_POST['carrera'];
      $rango = $_POST['rango'];

      if(empty($materno)) $materno = 'null'; else $materno = "'".$materno."'";
		if(empty($curp)) $curp = 'null'; else $curp = "'".$curp."'";
		if(empty($nss)) $nss = 'null'; else $nss = "'".$nss."'";
		if(empty($movil)) $movil = 'null'; else $movil = "'".$movil."'";
		if(empty($casa)) $casa = 'null'; else $casa = "'".$casa."'";



      if(empty($errores)){
        $query = "insert into personas (curp, nombre, paterno, materno, nss, correo, telefono_movil, telefono_casa, fecha_nac) values ({$curp},'{$nombre}','{$paterno}',{$materno},{$nss},'{$correo}',{$movil},{$casa},'{$fecha}');";
        $agregar = crear_registro($conexion,$query);
      
        if($agregar){
          $query = "select MAX(id) as max_id from personas";
          $res2 = selectEspecial($conexion,$query);
          $row = mysqli_fetch_array($res2);
          $maximo = $row["max_id"];

          $query = "insert into maestros (numero_empleado, grado_academico, tipo_contrato, id_persona, id_carrera) values ({$numero},'{$grado}','{$tipo}',{$maximo},{$carrera});";
          $agregar = crear_registro($conexion,$query);

          $query = "INSERT INTO usuarios (username, password, tipo, id_persona) values ('{$correo}',MD5('secret'),{$rango},{$maximo});";
			    $agregar = crear_registro($conexion,$query);

          if($agregar){
            redirect('maestros.php');
          }
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
<title>Agregar maestro</title>
<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

  <!--Titulo dentro del contened-->
<section class="content-header">
      <h1>
        Maestros
        <small>Nuevo maestro.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
<div class="row" >
        <div class="col-xs-12">
          <div class="box" >
            <div class="box-header">
              <h3 class="box-title">Agregar maestro</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" align="">
              <!-- form start -->
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">CURP</label>
                    <input type="text" class="form-control" id="curp" placeholder="Ingrese una descripcion" maxlength=11 name="curp">
                  </div>
                  <div class="form-group">
                    <label for="">* Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingrese un nombre" maxlength=30 name="nombre" required>
                  </div>
                  <div class="form-group">
                   <label for="">* Apellido paterno</label>
                   <input type="text" class="form-control" id="paterno" placeholder="Ingrese un apellido paterno" maxlength=30 name="paterno" required>
                  </div>
                  <div class="form-group">
                    <label for="">Apellido materno</label>
                    <input type="text" class="form-control" id="materno" placeholder="Ingrese un apellido materno" maxlength=30 name="materno">
                  </div>
                  <div class="form-group">
                    <label for="">NSS</label>
                    <input type="text" class="form-control" id="nss" placeholder="Ingrese su nss" name="nss" maxlength=15 >
                  </div>
                  <div class="form-group">
                    <label for="">* Correo electronico</label>
                    <input type="email" class="form-control" id="correo" placeholder="Ingrese su correo" maxlength=20 name="correo" required>
                  </div>
                  <div class="form-group">
                    <label for="">Telefono movil</label>
                    <input type="text" class="form-control" id="telefono_movil" placeholder="Ingrese su telefono movil" maxlength=15 name="movil" >
                  </div>
                  <div class="form-group">
                    <label for="">Telefono Casa</label>
                    <input type="text" class="form-control" id="telefono_casa" placeholder="Ingrese su telefono de casa" maxlength=15 name="casa" >
                  </div>
                  <div class="form-group">
                    <label for="">* Fecha Nacimiento</label>
                    <input type="date" class="form-control" id="nacimiento" placeholder="Ingrese su fecha de nacimiento" name="fecha" required>
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="">* Numero empleado</label>
                    <input type="number" class="form-control" id="numero_empleado" maxlength=11 placeholder="Ingrese su numero de empleado" name="numero" required>
                  </div>

                  <div class="form-group">
                    <label for="">* Grado Academico</label>
                    <select name="grado" class="form-control" required >
                      <option value="prepa">Preparatoria</option>
                      <option value="maestria">Maestria</option>
                      <option value="lic">Licenciatura</option>
                      <option value="doc">Doctorado</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">* Tipo contrato</label>
                    <select name="tipo" class="form-control" required>
                      <option value="pa">PA</option>
                      <option value="ptc">PTC</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">* Carrera</label>
                    <select name="carrera" class="form-control" required>
                      <?php
                      foreach ($carrera as $carrerita) {
                        // code...
                        echo "<option value=\"{$carrerita["id"]}\">".utf8_encode($carrerita["nombre"])."</option>";
                      }
                       ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">* Rango</label>
                    <select name="rango" class="form-control" required>
                      <option value="2" >Director</option>
                      <option value="3" >Profesor</option>
                    </select>
                  </div>

                </div>

                

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class="btn btn-primary" style="float: right;" name="submit">Agregar</button>
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
