<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }
  
  $res= select($conexion,'carreras');
  
  $id = $_GET['id'];
  $delete_id = borrar_registro($conexion,$id,'carreras');
  if($delete_id){
      echo   "Carrera eliminada.";
      redirect('carreras.php');
  } else {
      echo "Eliminación falló" ;
      redirect('carreras.php');
  }
?>
