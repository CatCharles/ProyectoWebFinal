<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
  if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }

  $id = $_GET['id'];
  $delete_id = borrar_registro($conexion,$id,'personas');
  if($delete_id){
      echo   "eliminado.";
      redirect('mostrar.php');
  } else {
      echo "Eliminación falló" ;
      redirect('mostrar.php');
  }
?>
