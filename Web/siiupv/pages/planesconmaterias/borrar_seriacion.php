<?php
  require '../basedatos/conexion.php';
   $id = $_GET['id'];
  $query="DELETE FROM seriacion WHERE CONCAT(id_carrera,id_plan,id_materia,id_materia_requerida) =".$id;

  $res = selectEspecial($conexion,$query);

  if($res){
      echo   "Plan con materia eliminado.";
      redirect('seriacion.php');
  } else {
      echo "Eliminación falló" ;
      redirect('seriacion.php');
  }
?>
