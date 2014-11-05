<?php
include 'base.php';
conectarse();
$lista;
$data;
$consulta = pg_query("select * from trabajo_tecnico,usuario where trabajo_tecnico.id_tecnico=usuario.id_usuario and trabajo_tecnico.id_registro='$_POST[id_registro]'");   
while ($row = pg_fetch_row($consulta)) {
	$lista[]=$row[0];
	$lista[]=$row[1];	
	$lista[]=$row[2];	
	$lista[]=$row[6]." ".$row[7];	
	$lista[]=$row[3];	
	$lista[]=$row[4];	
	$consulta1=pg_query("select * from detalles_trabajo where id_trabajoTecnico='$row[0]'");
	while ($row1 = pg_fetch_row($consulta1)) {
		$lista[]=$row1[1];	
		$lista[]=$row1[2];	
		$lista[]=$row1[3];	
		$lista[]=$row1[4];	
		$lista[]=$row1[5];	
		$lista[]=$row1[6];	
	}
}
echo $data=json_encode($lista);  
?>