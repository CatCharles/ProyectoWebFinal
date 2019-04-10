<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }
  
  $res= select($conexion,'materias');

  $id = $_GET['id'];
  $delete_id = borrar_registro($conexion,$id,'materias');
  if($delete_id){
      echo   "eliminado.";
      redirect('materias.php');
  } else {
      echo "Eliminación falló" ;
      redirect('materias.php');
  }
?>
