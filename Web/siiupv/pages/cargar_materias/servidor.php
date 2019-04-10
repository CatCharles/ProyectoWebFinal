<?php
    require '../basedatos/conexion.php';

    $tipo = $_GET['tipo'];
    //$tabla=$_GET['tabla'];



    if ($tipo == '1') {
    	$id_clase = $_GET['id'];
    	$clave = $_GET['clave'];
    	$id_grupo = $_GET['id_grupo'];
    	$id_carrera = $_GET['id_carrera'];
    	$id_plan = $_GET['id_plan'];
    	$id_materia = $_GET['id_materia'];
    	//$id_maestro = $_GET['id_maestro'];
    	$cuatri = $_GET['cuatri'];

    	$query = "select 
    		class.clave as clave_clase, 
    		class.capacidad, 
    		gp.clave as clave_grupo,
    		carr.siglas as siglas_carrera,
    		pl.clave as clave_plan,
    		mat.nombre as nombre_materia,
    		CONCAT(per.paterno,\" \",per.materno,\" \",per.nombre) as nombre_profesor,
            pm.cuatrimestre as cuatrimestre,
            (select CONCAT(hora_inicio,\" \",hora_fin) from horarios where dia=1 and id_clase = class.id) as lunes,
            (select CONCAT(hora_inicio,\" \",hora_fin) from horarios where dia=2 and id_clase = class.id) as martes,
            (select CONCAT(hora_inicio,\" \",hora_fin) from horarios where dia=3 and id_clase = class.id) as mierc,
            (select CONCAT(hora_inicio,\" \",hora_fin) from horarios where dia=4 and id_clase = class.id) as jueves,
            (select CONCAT(hora_inicio,\" \",hora_fin) from horarios where dia=5 and id_clase = class.id) as viernes
    		from clases class inner join grupos gp on class.id_grupo = gp.id
    						  inner join carreras carr on class.id_carrera = carr.id
    						  inner join planes_estudio pl on class.id_plan = pl.id
    						  inner join materias mat on class.id_materia = mat.id
    						  inner join maestros mas on class.id_maestro = mas.id
                              inner join personas per on mas.id_persona = per.id
                              inner join planes_con_materias pm on (class.id_carrera = pm.id_carrera
                              									and class.id_plan = pm.id_plan
                                                                and class.id_materia = pm.id_materia)
            where class.id = ${id_clase} and pm.cuatrimestre = ${cuatri}";
    	
    	//echo $query;
    	//$query = "select cve_plan, maestro from vwgruposconclase where materia = \"${id_materia}\"";    	    
    	//	echo $query;
	    $resultados = selectEspecial($conexion,$query);
	    //echo $resultados;
	    $respuesta=array();
	    while($fila = $resultados->fetch_assoc()){
	        $respuesta[]=array(
	        	'id_clase'=>$id_clase,
	            'cve_clase'=>$fila['clave_clase'],
	            'cap'=>$fila['capacidad'],
	            'cve_grupo'=>$fila['clave_grupo'],
	            'carrera'=>$fila['siglas_carrera'],
	            'cve_plan'=>$fila['clave_plan'],
	            'materia'=>$fila['nombre_materia'],
	            'profesor'=>$fila['nombre_profesor'],
	            'cuatri'=>$fila['cuatrimestre'],
	            'lun'=>$fila['lunes'],
	            'mar'=>$fila['martes'],
	            'mie'=>$fila['mierc'],
	            'jue'=>$fila['jueves'],
	            'vie'=>$fila['viernes']
	        );
	    }

	   echo json_encode($respuesta);
    } else if($tipo == 2) {
       $id_alumno = $_GET['id_alumno'];
       $id_clase = $_GET['id_clase'];
       $query = "insert into alumnos_con_clases
       			values(${id_alumno},${id_clase},0,0,0,0)";
       //echo $query;
       $resultados = selectEspecial($conexion,$query);

       $query = "";
      
    } else if($tipo == 3) {
       $id_alumno = $_GET['id_alumno'];
       $id_clase = $_GET['id_clase'];
       $query = "select count(1) as respuesta from alumnos_con_clases
       			where id_alumno = ${id_alumno} and id_clase = ${id_clase}";
       //echo $query;
       $resultados = selectEspecial($conexion,$query);
       $respuesta=array();
       while($fila = $resultados->fetch_assoc()){
         $respuesta[]=array(
           'respuesta'=>$fila['respuesta']
         );
       }
        
       echo json_encode($respuesta);           
    }

?>