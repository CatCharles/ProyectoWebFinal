<?php
  require '../basedatos/conexion.php';
  
   $id = $_GET['id'];
  $query="DELETE FROM planes_con_materias WHERE CONCAT(id_carrera,id_plan,id_materia) =".$id;

  $res = selectEspecial($conexion,$query);

  if($res){
      echo   "Plan con materia eliminado.";
      redirect('planesconmaterias.php');
  } else {
      echo "Eliminación falló" ;
      redirect('planesconmaterias.php');
  }
?>
