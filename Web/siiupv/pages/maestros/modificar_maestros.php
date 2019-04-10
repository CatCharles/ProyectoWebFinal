<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }
  
  $dato = $_GET['id'];
  $query = "select * from personas p, maestros m where p.id = m.id_persona and m.id_persona = {$dato};";
  $res = selectEspecial($conexion,$query);
  $carrera= select($conexion,'carreras');

  $tipo = selectEspecial($conexion,"SELECT * FROM usuarios WHERE id_persona = {$dato};");
  define('RAIZ','../../');


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

        $actualizar = crear_registro($conexion,$query);
        if(empty($errores)){
          $query = "update personas SET curp={$curp},nombre='{$nombre}',paterno='{$paterno}',materno={$materno},nss={$nss},correo='{$correo}',telefono_movil={$movil},telefono_casa={$casa},fecha_nac='{$fecha}' where id = {$dato};";
          echo $query;
          $actualizar = crear_registro($conexion,$query);
          
          if($actualizar){
            $query = "update maestros SET numero_empleado={$numero},grado_academico='{$grado}',tipo_contrato='{$tipo}',id_carrera={$carrera} where id_persona={$dato};";
            echo $query;
            $agregar = crear_registro($conexion,$query);
            echo 'ya pase';
            $query = "UPDATE usuarios SET username = '{$correo}', tipo = {$rango} WHERE id_persona = {$dato};";
            echo $query;
            $agregar = crear_registro($conexion,$query);
            echo 'ya pase';
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
<title>Modificar maestro</title>
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
        <small>Editar maestro.</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

     <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Modificar maestro</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id={$dato}" ?>" role="form">
              <?php foreach ($res as $maestro) {    ?>
              <div class="box-body">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">CURP</label>
                  <input type="text" class="form-control" id="curp" placeholder="Ingrese una descripcion" name="curp" maxlength=11 value="<?php echo $maestro["curp"]?>">
                </div>
                <div class="form-group">
                  <label for="">* Nombre</label>
                  <input type="text" class="form-control" id="nombre" placeholder="Ingrese un nombre" name="nombre" maxlength=30 required value="<?php echo $maestro["nombre"]?>">
                </div>
                <div class="form-group">
                 <label for="">* Paterno</label>
                 <input type="text" class="form-control" id="paterno" placeholder="Ingrese un apellido paterno" maxlength=30 name="paterno" required value="<?php echo $maestro["paterno"]?>">
                </div>
                <div class="form-group">
                  <label for="">Materno</label>
                  <input type="text" class="form-control" id="materno" placeholder="Ingrese un apellido materno" maxlength=30 name="materno" value="<?php echo $maestro["materno"]?>">
                </div>
                <div class="form-group">
                  <label for="">NSS</label>
                  <input type="text" class="form-control" id="nss" placeholder="Ingrese su nss" name="nss" maxlength=15 value="<?php echo $maestro["nss"]?>">
                </div>
                <div class="form-group">
                  <label for="">* Correo electronico</label>
                  <input type="email" class="form-control" id="correo" placeholder="Ingrese su correo" maxlength=20 name="correo" required value="<?php echo $maestro["correo"]?>">
                </div>
                <div class="form-group">
                  <label for="">Telefono movil</label>
                  <input type="text" class="form-control" id="telefono_movil" placeholder="Ingrese su telefono movil" maxlength=15 name="movil"  value="<?php echo $maestro["telefono_movil"]?>">
                </div>
                <div class="form-group">
                  <label for="">Telefono Casa</label>
                  <input type="text" class="form-control" id="telefono_casa" placeholder="Ingrese su telefono de casa" maxlength=15 name="casa"  value="<?php echo $maestro["telefono_casa"]?>">
                </div>
                <div class="form-group">
                  <label for="">Fecha Nacimiento</label>
                  <input type="date" class="form-control" name="fecha"  value="<?php echo $maestro["fecha_nac"]?>" required>
                </div>

                </div>
                  <div class="col-md-6">

                <div class="form-group">
                  <label for="">* Numero empleado</label>
                  <input type="number" class="form-control" id="numero_empleado" placeholder="Ingrese su numero de empleado" maxlength=11 name="numero" required value="<?php echo $maestro["numero_empleado"]?>">
                </div>
                <div class="form-group">
                  <label for="">* Grado Academico</label>
                  <select name="grado" class="form-control" required>
                    <option value="prepa" <?php if($maestro["grado_academico"] == "prepa") echo 'selected'; ?> >Preparatoria</option>
                      <option value="maestria" <?php if($maestro["grado_academico"] == "maestria") echo 'selected'; ?> >Maestria</option>
                      <option value="licenciatura" <?php if($maestro["grado_academico"] == "lic") echo 'selected'; ?> >Licenciatura</option>
                      <option value="doctorado" <?php if($maestro["grado_academico"] == "doc") echo 'selected'; ?> >Doctorado</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="">* Tipo contrato</label>
                  <select name="tipo" class="form-control">
                    <option value="pa" <?php if($maestro["tipo_contrato"] == "pa") echo 'selected'; ?> >PA</option>
                    <option value="ptc" <?php if($maestro["tipo_contrato"] == "ptc") echo 'selected'; ?> >PTC</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="">* Carrera</label>
                  <select name="carrera" class="form-control" required>
                    <?php
                    foreach ($carrera as $carrerita) {
                      // code...
                      echo "<option value=\"{$carrerita["id"]}\"";
                      if($maestro["id_carrera"] == $carrerita["id"]) echo 'selected';
                      echo '>'.utf8_encode($carrerita["nombre"]).'</option>';
                    }
                     ?>
                  </select>
                </div>
                <?php
                foreach ($tipo as $ti) {
                  $r = $ti['tipo'];
                }
                ?>
                <div class="form-group">
                    <label for="">* Rango</label>
                    <select name="rango" class="form-control" required>
                      <option value=2 <?php if($r == 2) echo 'selected'; ?> >Director</option>
                      <option value=3 <?php if($r == 3) echo 'selected'; ?> >Profesor</option>
                    </select>
                  </div>

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
    <!-- /.content -->
  <?php require  '../menus/footer.php' ?>
</body>
</html>
