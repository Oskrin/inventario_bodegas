<?php
include 'base.php';
conectarse();
$cont=1;
$repe=0;
if($_POST['oper']=="add")
{
	$consulta = pg_query("select * from trabajo");
	while ($row = pg_fetch_row($consulta)) {
		$cont++;
	}
	$consulta = pg_query("select * from trabajo where nombre_trabajo='$_POST[nombre_trabajo]'");
	while ($row = pg_fetch_row($consulta)) {
		$repe++;
	}
	if($repe==0)
	{
		pg_query("insert into trabajo values('$cont','$_POST[nombre_trabajo]','$_POST[precio_trabajo]')");
	}	
}
if($_POST['oper']=="edit")
{
	pg_query("update trabajo set id_trabajo='$_POST[id_trabajo]',nombre_trabajo='$_POST[nombre_trabajo]',precio_trabajo='$_POST[precio_trabajo]' where id_trabajo='$_POST[id_trabajo]'");
}
?>
