<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
  if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }

  $res= select($conexion,'cuatrimestres');
  
  $id = $_GET['id'];
  $delete_id = borrar_registro($conexion,$id,'cuatrimestres');
  if($delete_id){
      echo   "Cliente eliminado.";
      redirect('cuatrimestres.php');
  } else {
      echo "Eliminación falló" ;
      redirect('cuatrimestres.php');
  }
?>
