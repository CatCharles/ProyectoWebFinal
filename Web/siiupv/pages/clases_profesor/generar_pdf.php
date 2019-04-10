<?php

  require '../basedatos/conexion.php';
  require_once '../dompdf/autoload.inc.php';
  // reference the Dompdf namespace
  use Dompdf\Dompdf;

  $id = $_GET['id'];  
  $id_maestro = $_GET['id_maestro']; 

  // Valores varios.
  $query = "select 
    `g`.`id` AS `id_grupo`,
    `g`.`clave` AS `cve_gpo`,
    `q`.`descripcion` AS `cuatrimestre`,
    `ca`.`nombre` AS `carrera`,
    `p`.`clave` AS `cve_plan`,    
    `mt`.`nombre` AS `materia`,
    `m`.`nombre_completo` AS `maestro`,    
    `g`.`id_cuatrimestre` AS `id_cuatrimestre`,
    `ca`.`id` AS `id_carrera`,
    `p`.`id` AS `id_plan`,
    `m`.`id` AS `id_maestro`, 
    c.estatus 
    from ((((((`siiupv`.`grupos` `g` join `siiupv`.`clases` `c` on((`g`.`id` = `c`.`id_grupo`))) join `siiupv`.`cuatrimestres` `q` on((`g`.`id_cuatrimestre` = `q`.`id`))) join `siiupv`.`planes_estudio` `p` on(((`g`.`id_carrera` = `p`.`id_carrera`) and (`g`.`id_plan` = `p`.`id`)))) join `siiupv`.`carreras` `ca` on((`p`.`id_carrera` = `ca`.`id`))) join `siiupv`.`vwmaestros` `m` on((`c`.`id_maestro` = `m`.`id`))) join `siiupv`.`materias` `mt` on((`c`.`id_materia` = `mt`.`id`))) 
    where id_maestro = {$id_maestro}";

  $varios = selectEspecial($conexion,$query);

  // Nombre del alumno.
  $query = "select CONCAT(a.paterno,' ',a.materno,' ',a.nombre) as nombre_alumno, a.matricula, b.id_alumno as id_alumno, b.calificacion, b.unidad1, b.unidad2, b.unidad3, b.id_clase from vwalumnos a inner join alumnos_con_clases b on 
            a.id = b.id_alumno where b.id_clase = '{$id}' 
    order by nombre_alumno";

  $res = selectEspecial($conexion,$query);

  // Clave de la clase.
  $query = "select clave from clases where id = '{$id}'";
  $clave_clase = selectEspecial($conexion,$query);

  // Nombre del profesor.
  $query = "select CONCAT(p.nombre,' ',p.paterno,' ',p.materno) as nombre_maestro from maestros m inner join personas p on m.id_persona = p.id where m.id = {$id_maestro}";
  $nombre_maestro = selectEspecial($conexion,$query);

  $valores = $varios->fetch_assoc();
  $clave = $clave_clase->fetch_assoc();
  $profesor = $nombre_maestro->fetch_assoc();
  //$cantidad_alumnos = $result_cantidad->fetch_assoc();

  //echo $cantidad_alumnos;

  // Generar de PDF.
	// Instancia a Dompdf.
	$dompdf = new Dompdf();

	$content = '';

	$n_columnas = 30;
	$numero_lista = 1;

	  

	// Estructura.
	$content .= '<div>';
	$content .= '<img src="./img/LogoUPV.png" height="100px">';
	$content .= '</div>';

	$content .= '<div>';
	$content .= 'CLASE: <b>'. $clave['clave'] .'</b><br>';

	$content .= 'PROFESOR: <b>'. $profesor['nombre_maestro'] .'</b><br>';    
	$content .= 'MATERIA: <b>'.$valores['materia'].'</b><br>';    

	$content .= 'CLAVE: <b>'.$valores['cve_gpo'].'</b><br>';
	$content .= 'CUATRIMESTRE: <b>'.$valores['cuatrimestre'].'</b><br>';
	$content .= '</div>';

	$content .= '<table border="1" class="table table-bordered table-striped">';
	$content .= '<thead>';
	$content .= '<tr>';
	$content .= '<th>#</th>';
	$content .= '<th>Matricula</th>';    
	$content .= '<th colspan="10"> Nombre del alumno </th>';
	for ($i=1; $i < $n_columnas+1 ; $i++) { 
	  $content .= '<th>'.$i.'</th>';
	}
	$content .= '</tr>';
	$content .= '</thead>';
	$content .= '<tbody>';   
	foreach ($res as $data) {
	  $content .= '<tr>';
	  $content .= '<td>';
	  $content .= $numero_lista++;
	  $content .= '</td>';
	  $content .= '<td>';
	  $content .= $data['matricula'];
	  $content .= '</td>';      
	  $content .= '<td colspan="10">';
	  $content .= $data['nombre_alumno'];
	  $content .= '</td>';
	  for ($i=1; $i < $n_columnas+1 ; $i++) { 
	    $content .= '<td> </td>';
	  }
	  $content .= '</tr>';
	}  
	$content .= '</tbody>';
	$content .= '</tfoot>';
	$content .= '</tfoot>';    
	$content .= '</table>';

	$dompdf->loadHtml($content);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream();

  redirect('clases_profesor.php');

?>