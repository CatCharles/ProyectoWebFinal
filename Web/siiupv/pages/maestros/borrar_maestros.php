<?php
  require '../basedatos/conexion.php';
  require '../sesion/abre_sesion.php';
if($_SESSION['tipo']!=1){
    header('Location: ../../index.php');
		exit;
  }


  $id = $_GET['id'];
  $delete_id = borrar_registro($conexion,$id,'cuatrimestres');

  $query = "delete from maestros where id_persona = {$id}";
  $borrar = crear_registro($conexion,$query);


  $query = "delete from personas where id = {$id}";
  $borrar = crear_registro($conexion,$query);


  redirect('maestros.php');

?>
