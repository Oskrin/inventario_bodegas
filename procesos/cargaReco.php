<?php
include 'base.php';
$data="";
$consulta = pg_query("select * from recomendaciones where id_registro_equipo='$_POST[id]'");   
while ($row = pg_fetch_row($consulta)) {		
	$data=$row[2];
}
echo $data;
?>