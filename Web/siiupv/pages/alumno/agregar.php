<?php
  require '../basedatos/conexion.php';
	require '../sesion/abre_sesion.php';
	if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
	}
	
	$table = 'alumnos';
	$t_persona = 'personas';
	$errores = '';

	$res = select($conexion,'carreras');
	$res2 = select($conexion,'planes_estudio');
	$id_persona = "";

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
		  $query = "insert into {$t_persona} (curp, nombre, paterno, materno, nss, correo, telefono_movil, telefono_casa, fecha_nac) values ({$curp},'{$nombre}','{$paterno}',{$materno},{$nss},'{$correo}',{$tel_movil},{$tel_casa}, '{$fecha_nac}'  );";
		  $agregar = crear_registro($conexion,$query);
		}

		$matricula = $_POST['matricula'];
		$carrera = $_POST['carrera'];
		$plan = $_POST['plan'];	
		$escuela_proc = $_POST['escuela_proc'];	
		$promedio = $_POST['promedio'];
		$puntos_cen = $_POST['puntos_cen'];

			$res = selectEspecial($conexion,"SELECT * FROM personas WHERE correo = '$correo'");
			foreach ($res as $persona) {
				$id_persona = $persona['id'];
			}


		if(empty($errores)){
			$query = "insert into {$table} (matricula, id_carrera, id_plan, escuela_procedencia, promedio_ingreso, puntos_ceneval, id_persona) values ('{$matricula}',{$carrera},{$plan},'{$escuela_proc}','{$promedio}','{$puntos_cen}',{$id_persona});";
			$agregar = crear_registro($conexion,$query);

			$query = "INSERT INTO usuarios (username, password, tipo, id_persona) values ('{$correo}',MD5('secret'),4,{$id_persona});";
			$agregar = crear_registro($conexion,$query);

			if($agregar){
				redirect('mostrar.php');
			}else{
				//echo "error";
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

<title>Agregar alumno</title>

<?php require '../menus/head.php' ?>
<head>
<script language="javascript" src="js/jquery-3.1.1.min.js"></script>
<script language="javascript">
			$(document).ready(function(){
				$("#carrera").change(function () {					
					$("#carrera option:selected").each(function () {
						id_carrera = $(this).val();
						$.post("includes/getPlan.php", { id_carrera: id_carrera }, function(data){
							$("#plan").html(data);
						});            
					});
				})
			});
</script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require '../menus/header.php' ?>
  <?php require '../menus/sidebar.php' ?>

  <div class="content-wrapper">

	<!--Titulo dentro del contened-->
  <section class="content-header">
      <h1>
        Alumnos
        <small>Nuevo alumno.</small>
      </h1>
    </section>

	<!-- Main content -->
	<section class="content container-fluid">

			<!-- SELECT2 EXAMPLE -->
	  <div class="box box-default">
		<div class="box-header with-border">
		<h3 class="box-title">Agregar alumno</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
		 <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
		  <div class="row">
			<div class="col-md-6">
			  <h4 class="box-title">Datos personales:</h4>

				<div class="form-group">
					<label for="">* Nombre</label>
					<input type="text" name="nombre" class="form-control" placeholder="ej. CARLOS ALBERTO" required>
				</div>

				<div class="form-group">
					<label for="">* Apellido paterno</label>
					<input type="text" name="paterno" class="form-control" placeholder="ej. PEREZ" required>
				</div>

				<div class="form-group">
					<label for="">Apellido materno</label>
					<input type="text" name="materno" class="form-control" placeholder="ej. RAMOS" >
				</div>

				<div class="form-group">
					<label for="">CURP</label>
					<input type="text" name="curp" class="form-control" placeholder="ej. ROTL971119MTSDRN01" maxlength=18 minlength=8>
				</div>

				<div class="form-group">
					<label for="">NSS</label>
					<input type="text" name="nss" class="form-control" placeholder="ej. 72795608040" maxlength=11 minlength=11>
				</div>

				<div class="form-group">
					<label for="">* Correo electronico</label>
					<input type="email" name="correo" class="form-control" placeholder="ej. 1630984@upv.edu.mx" required>
				</div>

				<div class="form-group">
					<label for="">Teléfono móvil</label>
					<input type="text" name="tel_movil" class="form-control" placeholder="ej. 8341528614" maxlength=10 minlength=10>
				</div>

				<div class="form-group">
					<label for="">Teléfono casa</label>
					<input type="text" name="tel_casa" class="form-control" placeholder="ej. 3139888" maxlength=7 minlength=7>
				</div>

				<div class="form-group">
					<label for="">* Fecha de nacimiento</label>
					<input type="date" name="fecha_nac" class="form-control" required>
				</div>
			  <!-- /.form-group -->
			</div>
			<!-- /.col -->
			<div class="col-md-6">
			  <div class="form-group">
				<div class="form-group">
				<h4 class="box-title">Datos de Alumno:</h4>

					<label for="">* Matricula</label>
					<input type="text" class="form-control" name="matricula" placeholder="ej. 1630444" required minlength=7 maxlength=7>
				</div>

				<div class="form-group">
					<label for="">* Carrera</label>
					<select name="carrera" id="carrera" class="form-control" required>
						<?php  
						while ($val = mysqli_fetch_array($res)) {
							echo '<option value="'.$val['id'].'">'.utf8_encode($val['nombre']).'</option>';
						}
						?>
					</select>
				</div>

				<div class="form-group">
					<label for="">* Plan de estudios</label>
					<select name="plan" id="plan" class="form-control" required>
						<?php  
						while ($val = mysqli_fetch_array($res2)) {
							echo '<option value="'.$val['id'].'">'.utf8_encode($val['clave']).'</option>';
						}
						?>
					</select>
				</div>

				<div class="form-group"> 
					<label for="">* Escuela procedencia</label>
					<input type="text" class="form-control" name="escuela_proc" placeholder="ej. CBTIS 236" required>
				</div>

				<div class="form-group"> 
					<label for="">* Promedio de ingreso</label>
					<input type="number" step="any" class="form-control" name="promedio" placeholder="ej. 9.6" required>
				</div>

				<div class="form-group"> 
					<label for="">* Puntos ceneval</label>
					<input type="number" class="form-control" name="puntos_cen" placeholder="ej. 98" required>
				</div>
			  </div>
			  <!-- /.form-group -->
			</div>
			<!-- /.col -->
		  </div>
		  <!-- /.row -->
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
		  <button type="submit" class="btn btn-primary" style="float: right;" name="submit">Agregar</button>
		</div>
	  </form>
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
