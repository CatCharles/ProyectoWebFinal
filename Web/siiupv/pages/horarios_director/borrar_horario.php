<?php
  require '../basedatos/conexion.php';
  $res= select($conexion,'horarios');
  
  $id = $_GET['id'];
  $dia = $_GET['dia'];
  $delete_id = borrar_registro_especial($conexion,$id,$dia,'horarios');
  if($delete_id){
      
      redirect('horario.php');
  } else {
      echo "Eliminación falló" ;
      //redirect('horario.php');
  }
?>
