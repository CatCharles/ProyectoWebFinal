<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }
  
  $res= select($conexion,'aulas');
  define('RAIZ','../../');
  $id = $_GET['id'];
  $delete_id = borrar_registro($conexion,$id,'aulas');
  if($delete_id){
      echo   "Aula eliminada.";
      redirect('aulas.php');
  } else {
      echo "Eliminación falló" ;
      redirect('aulas.php');
  }
?>
