<?php
include 'base.php';
conectarse();
$cont=1;
$repe=0;
$data=0;
$consulta = pg_query("select * from recomendaciones");
	while ($row = pg_fetch_row($consulta)) {
	$cont++;
}
$consulta = pg_query("select * from recomendaciones where id_registro_equipo='$_POST[id]'");
	while ($row = pg_fetch_row($consulta)) {
	$repe=$row[0];
}
if($repe==0){
	pg_query("insert into recomendaciones values('$cont','$_POST[id]','$_POST[reco]')");
	$data=1;
}
if($repe!=0){
	pg_query("update recomendaciones set recomendacion='$_POST[reco]' where id_recomendacion='$repe'");
	$data=1;
}
echo $data;

?>
