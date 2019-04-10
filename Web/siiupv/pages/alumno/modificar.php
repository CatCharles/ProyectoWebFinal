<?php 
	require '../basedatos/conexion.php';
	require '../sesion/abre_sesion.php';
	if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }

  $dato = $_GET['id'];


  $res= obtener_resultado_por_id($conexion,$dato,'alumnos');
	$carreras_al = select($conexion, 'carreras');
	
	$planes_al = select($conexion, 'planes_estudio');

  $id_persona = "";
  foreach ($res as $pers) {
	$id_persona = $pers['id_persona'];
  }
  
  foreach ($res as $carreras) {
	$id_carrera = $carreras['id_carrera']; 
  }
  
  $carrera = obtener_resultado_por_id($conexion, $id_carrera, 'carreras');
  $persona = obtener_resultado_por_id($conexion, $id_persona, 'personas');

  if(isset($_POST['submit'])){

		$nombre = $_POST['nombre'];
		$paterno = $_POST['paterno'];
		$materno = $_POST['materno'];
		$curp = $_POST['curp'];
		$nss = $_POST['nss'];
		$correo = $_POST['correo'];
		$tel_movil = $_POST['tel_movil'];
		$tel_casa = $_POST['tel_casa'];
		$fecha_nac = $_POST['fecha_nac'];

		if(empty($materno)) $materno = 'null'; else $materno = "'".$materno."'";
		if(empty($curp)) $curp = 'null'; else $curp = "'".$curp."'";
		if(empty($nss)) $nss = 'null'; else $nss = "'".$nss."'";
		if(empty($tel_movil)) $tel_movil = 'null'; else $tel_movil = "'".$tel_movil."'";
		if(empty($tel_casa)) $tel_casa = 'null'; else $tel_casa = "'".$tel_casa."'";

		if(empty($erroresP)){
		  $query = "update personas SET nombre = '{$nombre}', paterno = '{$paterno}', materno = {$materno}, curp = {$curp}, nss = {$nss}, correo = '{$correo}', telefono_movil = {$tel_movil}, telefono_casa = {$tel_casa}, fecha_nac = '{$fecha_nac}' where id = {$id_persona};";
		  $agregar = crear_registro($conexion,$query);
		}

			$matricula = $_POST['matricula'];
			$carrera = $_POST['carrera'];
			$plan = $_POST['plan'];	
			$escuela_proc = $_POST['escuela_proc'];	
			$promedio = $_POST['promedio'];	
			$puntos_cen = $_POST['puntos_cen'];

		  if(empty($errores)){
				$query = "update alumnos SET id_carrera={$carrera}, escuela_procedencia='{$escuela_proc}', id_plan = {$plan}, promedio_ingreso='{$promedio}', puntos_ceneval='{$puntos_cen}' WHERE id={$dato}";
				$actualizar = crear_registro($conexion,$query);

				$query = "UPDATE usuarios SET username = '{$correo}' WHERE id_persona = {$id_persona};";
			 $agregar = crear_registro($conexion,$query);

				if($actualizar){
				  redirect('mostrar.php');
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

<title>Modificar alumno</title>

<?php require '../menus/head.php' ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

	<!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Alumnos
        <small>Editar alumno.</small>
      </h1>
    </section>

	<!-- Main content -->
	<section class="content container-fluid">

	  <!-- SELECT2 EXAMPLE -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Modificar alumno</h3>
		</div>
	<!-- /.box-header -->
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id={$dato}" ?>" role="form">
			<div class="box-body">
				
				
				<div class="row">
				
				<div class="col-md-6">
					<?php foreach ($persona as $d_persona) { ?>
						
					
					<h4 class="box-title">Datos personales:</h4>

					<div class="form-group">
						<label for="">* Nombre</label>
						<input type="text" name="nombre" class="form-control" maxlength=30 value="<?php echo utf8_encode($d_persona['nombre']); ?>" required>
					</div>

					<div class="form-group">
				 		<label for="">* Apellido paterno</label>
				    	<input type="text" name="paterno" class="form-control" maxlength=30 value="<?php echo utf8_encode($d_persona['paterno']); ?>" required>
					</div>

					<div class="form-group">
						<label for="">Apellido materno</label>
						<input type="text" name="materno" class="form-control" maxlength=30 value="<?php echo utf8_encode($d_persona['materno']); ?>">
					</div>

					<div class="form-group">
				  		<label for="">CURP</label>
						<input type="text" name="curp" class="form-control" value="<?php echo utf8_encode($d_persona['curp']); ?>" minlenght=18 maxlength=18>
					</div>

					<div class="form-group">
				  		<label for="">NSS</label>
						<input type="text" name="nss" class="form-control" value="<?php echo $d_persona['nss']; ?>" maxlength=11 minlenght=11 >
					</div>

					<div class="form-group">
				  		<label for="">* Correo electronico</label>
						<input type="email" name="correo" class="form-control" value="<?php echo utf8_encode($d_persona['correo']); ?>" required>
					</div>

					<div class="form-group">
				  		<label for="">Teléfono móvil</label>
						<input type="text" name="tel_movil" class="form-control" value="<?php echo $d_persona['telefono_movil']; ?>" minlenght=10 maxlength=10>
					</div>

					<div class="form-group">
				  		<label for="">Teléfono casa</label>
						<input type="text" name="tel_casa" class="form-control" value="<?php echo $d_persona['telefono_casa']; ?>" minlenght=7 maxlength=7>
					</div>

					<div class="form-group">
				  		<label for="">* Fecha de nacimiento</label>
						<input type="date" name="fecha_nac" class="form-control" value="<?php echo $d_persona['fecha_nac']; ?>" required>
					</div>
					<?php } ?>
				
				</div>
		  		
		  	  	<div class="col-md-6">
		  	  		<?php foreach ($res as $d_alumno) { ?>

					<div class="form-group">
						<div class="form-group">
							<h4 class="box-title">Datos de Alumno:</h4>

							<label for="">* Matricula</label>
							<input type="text" class="form-control" name="matricula" value="<?php echo $d_alumno['matricula']; ?>" readonly>
							</div>

							<div class="form-group">
							<label for="">* Carrera</label>
							<select name="carrera" class="form-control" readonly>
								<?php	
									while ($carrera = mysqli_fetch_array($carreras_al)) {
											echo '<option value="'.$carrera['id'].'"';
											if ($d_alumno['id_carrera'] == $carrera['id']) echo 'selected';
											echo '>'.utf8_encode($carrera['nombre']).'</option>';
									}
								?>
						    </select>
							</div>

							<div class="form-group">
							<label for="">* Plan de estudios</label>
							<select name="plan" class="form-control" required>
								<?php	
									while ($planes = mysqli_fetch_array($planes_al)) {
											echo '<option value="'.$planes['id'].'"';
											if ($d_alumno['id_plan'] == $planes['id']) echo 'selected';
											echo '>'.utf8_encode($planes['clave']).'</option>';
									}
								?>
						    </select>
							</div>

							<div class="form-group"> 
								<label for="">* Escuela procedencia</label>
								<input type="text" class="form-control" name="escuela_proc" value="<?php echo utf8_encode($d_alumno['escuela_procedencia']); ?>" required>
							</div>

							<div class="form-group"> 
								<label for="">* Promedio de ingreso</label>
								<input type="number" step="any" class="form-control" name="promedio" value="<?php echo $d_alumno['promedio_ingreso']; ?>" requiered>
							</div>

							<div class="form-group"> 
								<label for="">* Puntos ceneval</label>
								<input type="number" class="form-control" name="puntos_cen" value="<?php echo $d_alumno['puntos_ceneval']; ?>" required>
							</div>

					</div>
				
				</div>
		 		
		 		</div>
		 		<?php } ?>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
			  <button type="submit" class="btn btn-primary" name="submit">Modificar</button>
			</div>
		</form>
	</div>








	</section>

	<!-- /.content -->
  <?php require  '../menus/footer.php' ?>
</body>
</html>
