<?php
  require '../basedatos/conexion.php';
  $res= select($conexion,'planes_estudio');
  
  $id = $_GET['id'];
  $delete_id = borrar_registro($conexion,$id,'planes_estudio');
  if($delete_id){
      echo   "Grupo eliminado.";
      redirect('planes.php');
  } else {
      echo "Eliminación falló" ;
      redirect('planes.php');
  }
?>
