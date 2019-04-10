<?php
	require '../../basedatos/conexion.php';

	$id_carrera = $_POST['id_carrera'];
	
	$queryM = "SELECT id, clave FROM planes_estudio WHERE id_carrrera = '$id_carrera' ORDER BY clave";
	$resultadoM = selectEspecial($conexion,$queryM);
	
	$html= "<option value='0'>Seleccionar Plan</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option value='".$rowM['id']."'>".$rowM['clave']."</option>";
	}
	
	echo $html;
?>
