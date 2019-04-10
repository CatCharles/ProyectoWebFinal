<?php
if(!defined('RAIZ')){
    define('RAIZ','/Web/siiupv/');
}

 ?>
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo RAIZ . 'dist/img/profile.ico' ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo utf8_encode($_SESSION["nombre"].' '.$_SESSION["paterno"]); ?></p>
        <!-- Status
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        -->
      </div>
    </div>

    <!-- search form (Optional) 
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
      </div>
    </form>
     /.search form -->
    <!-- Sidebar Menu -->

    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">Menu opciones</li>
      <!-- Optionally, you can add icons to the links -->
      <?php 
      switch($_SESSION["tipo"]){
        case 1: // Administrador
          echo '<li><a href="'.RAIZ.'pages/alumno/mostrar.php'.'"><i class="fa fa-user-circle"></i> <span>Alumnos</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/aulas/aulas.php'.'"><i class="fa fa-archive"></i> <span>Aulas</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/carreras/carreras.php'.'"><i class="fa fa-handshake-o"></i> <span>Carreras</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/cuatrimestres/cuatrimestres.php'.'"><i class="fa fa-graduation-cap"></i> <span>Cuatrimestres</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/maestros/maestros.php'.'"><i class="fa fa-address-card"></i> <span>Maestros</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/materias/materias.php'.'"><i class="fa fa-book"></i> <span>Materias</span></a></li>';
          break;
        case 2: //Director
          echo '<li><a href="'.RAIZ.'pages/grupos/grupo.php'.'"><i class="fa fa-group"></i> <span>Grupos</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/clases/clases.php'.'"><i class="fa fa-university"></i> <span>Clases</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/horarios_director/horario.php'.'"><i class="fa fa-calendar-o"></i> <span>Horario</span></a></li>';

          echo '<li class="treeview" ><a href="#"><i class="fa fa-folder"></i> <span>Planes de estudio</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i></span></a>';
          echo '<ul class = "treeview-menu">';
          echo '<li><a href="'.RAIZ.'pages/planes/planes.php'.'"><i class="fa fa-folder-open"></i> <span>Planes de estudio</span></a></li>';     
          echo '<li><a href="'.RAIZ.'pages/planesconmaterias/planesconmaterias.php'.'"><i class="fa fa-tags"></i> <span>Planes con materias</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/planesconmaterias/seriacion.php'.'"><i class="fa fa-pencil-square-o"></i> <span>Seriacion de materias</span></a></li>';    
          echo '</ul></li>';
          break;
        case 3: //Profesor
        //clases del profesor           //ver lista de asistencia
          echo '<li><a href="'.RAIZ.'pages/clases_profesor/clases_profesor.php'.'"><i class="fa fa-graduation-cap"></i> <span>Clases</span></a></li>';
          //ver horario de clases
          echo '<li><a href="'.RAIZ.'pages/horario_clases_profesor/horarios.php'.'"><i class="fa fa-calendar-check-o"></i> <span>Horarios</span></a></li>';

          break;
        case 4: //Alumno
        		//horario de clase
        		//historial
        		//calificaiones actuales
          echo '<li><a href="'.RAIZ.'pages/horario_clases_alumno/ver.php'.'"><i class="fa fa-calendar"></i> <span>Horario de clases</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/cargar_materias/cargar_materias.php'.'"><i class="fa fa-check-circle"></i> <span>Cargar materias</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/calificacioneshistorial/calificaciones.php'.'"><i class="fa fa-bookmark"></i> <span>Calificaciones</span></a></li>';
          echo '<li><a href="'.RAIZ.'pages/calificacioneshistorial/historial.php'.'"><i class="fa fa-graduation-cap"></i> <span>Historial</span></a></li>';
          /*echo '<li><a href="'.RAIZ.'pages/horario_clases_alumno/ver.php'.'"><i class="fa fa-link"></i> <span>ver</span></a></li>';*/
          break;
      }  
      ?>
        





      </li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
