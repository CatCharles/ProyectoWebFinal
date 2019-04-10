<?php
  define('RAIZ','/Web/siiupv/');
  require 'pages/sesion/abre_sesion.php';
  switch($_SESSION["tipo"]){
    case 1:
      header('Location: pages/dashboard/dash_admin.php');
    break;
    case 2:
      header('Location: pages/dashboard/dash_director.php');
    break;
    case 3:
      header('Location: pages/dashboard/dash_profesor.php');
    break;
    case 4:
      header('Location: pages/dashboard/dash_alumno.php');
    break;
  }
 ?>
