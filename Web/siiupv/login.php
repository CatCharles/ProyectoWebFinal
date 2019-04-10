<?php
require 'pages/basedatos/conexion.php';
$valido=false;
if (isset($_POST['aceptar'])) {
  $usuario=$_POST['usuario'];
  $contrasena=$_POST['contrasena'];
  $resultado=valida_usuario_bd($conexion,$usuario,$contrasena);
  if(!$resultado){
    $valido=false;
  }else{
    $valido=true;
    session_start();
    foreach ($resultado as $r) {
      $_SESSION['usuario']=$usuario;
      $_SESSION['contrasena']=$contrasena;
      $_SESSION['nombre']=$r["nombre"];
      $_SESSION['paterno']=$r["paterno"];
      $_SESSION['tipo']=$r["tipo"];
      $_SESSION['id_persona']=$r["id_persona"];
    }
    header('Location:index.php');
  }
}
?>
<!DOCTYPE html>
<html>
<?php require 'pages/menus/head.php' ?>
<body class="hold-transition login-page" style="background: url(fondo.jpg)  no-repeat center;">
<div class="login-box">
  <div class="login-logo">
    <img src="UP_Victoria.png" style="align-content: center;padding-top: 0px; height: 111px;"><h1 >SISUPV</h1>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Inicia sesion para entrar al sistema (admin/admin)</p>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="usuario">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="password" name="contrasena">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        
        <?php
				if(!$valido && isset($_POST['aceptar'])) {
					echo '<p>Usuario y/o contraseña no valido</p>';
				}
			  ?>

        <!-- /.col -->
        <div class="col-xs-4">
          <input type="submit"  class="btn btn-primary btn-block btn-flat" name="aceptar" value="Ingresar">
        </div>
        <!-- /.col -->
      </div>
    </form>


    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>

</body>
</html>
