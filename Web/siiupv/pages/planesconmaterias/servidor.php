<?php
    require '../basedatos/conexion.php';

    $tipo = $_GET['tipo'];

    if($tipo =='1'){
    $nomEstado=$_GET['id_carrera'];

    $query="SELECT pl.id,pl.clave FROM planes_estudio pl WHERE pl.id_carrera = ('$nomEstado')";
    try{
        $resultados=selectEspecial($conexion,$query);
        $respuesta=array();
        while($fila = $resultados->fetch_assoc()){
            $respuesta[]=array(
                'id'=>$fila['id'],
                'nombre'=>$fila['clave'],
                'query' =>$query
            );
        }
    }catch(Exception $e){
        $respuesta = array('error' => $e.getMessage);
    }

    echo json_encode($respuesta);
}else if($tipo=='2'){
    $id_error = $_GET['id_error'];
    $tabla = $_GET['tabla'];
    $practicas = $_GET['practicas'];
    $teoricas =$_GET['teoricas'];
    $cuatrimestre = $_GET['cuatrimestre'];
    $creditos = $_GET['creditos'];

    $carrera = substr($id_error, 0,1);
    $plan = substr($id_error, 1,1);
    $materia = substr($id_error, 2,3);

    $query = "insert into {$tabla} (`id_carrera`, `id_plan`, `id_materia`, `cuatrimestre`, `creditos`, `horas_practica`, `horas_teoricas`)  values ('$carrera','$plan','$materia','$cuatrimestre','$creditos','$practicas','$teoricas');";
        ///echo $query;
        try{
        $resultado = crear_registro($conexion,$query);
        if(empty($resultado)){
            $resultado = "false";
            
        }else{
            $resultado = "true";
            
        }
  
        }catch(Exception $e){
            $resultado = array('error' => $e.getMessage);
            echo "Res3: ". $resultado;

        } 

        //echo "resultado : " + json_decode($resultado);
    echo ($resultado);
}
?>