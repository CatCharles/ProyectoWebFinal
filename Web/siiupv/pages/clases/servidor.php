<?php
    require '../basedatos/conexion.php';

    $tipo = $_GET['tipo'];
    $tabla=$_GET['tabla'];



    if ($tipo == '1') {

    	$id_carrera=$_GET['id_carrera'];    	 

    	$query = "select id, clave from {$tabla} where id_carrera = '$id_carrera'";    	    
	    $resultados = selectEspecial($conexion,$query);
	    $respuesta=array();
	    while($fila = $resultados->fetch_assoc()){
	        $respuesta[]=array(
	            'id'=>$fila['id'],
	            'clave'=>$fila['clave']
	        );
	    }    

	    echo json_encode($respuesta);
    } else if($tipo == '2') {
    	$id_plan = $_GET['id_plan'];
    	$id_carrera = $_GET['id_carrera'];

    	$query = "select m.id, m.nombre from materias m inner join planes_con_materias p on m.id = p.id_materia where id_plan = '$id_plan' and id_carrera = '$id_carrera'";
      //echo $query;
	    $resultados = selectEspecial($conexion,$query);
	    $respuesta=array();
	    while($fila = $resultados->fetch_assoc()){
	        $respuesta[]=array(
	            'id'=>$fila['id'],
	            'nombre'=>utf8_encode($fila['nombre'])
	        );
	    }    

	    echo json_encode($respuesta);
	    //echo json_encode($respuesta);
      
    }else if ($tipo == '3'){
      $id_carrera=$_GET['id_carrera'];
      
      $query = "select ma.id as id,CONCAT(per.nombre,' ' ,per.paterno,' ' ,per.materno) as nombre from maestros ma inner join personas per ON ma.id_persona = per.id where ma.id_carrera = '$id_carrera'";
      $resultados = selectEspecial($conexion,$query);
      console.log($query);
	    $respuesta=array();
	    while($fila = $resultados->fetch_assoc()){
	        $respuesta[]=array(
	            'id'=>$fila['id'],
	            'nombre'=>$fila['nombre']
	        );
	    }    

	    echo json_encode($respuesta);
    }

?>