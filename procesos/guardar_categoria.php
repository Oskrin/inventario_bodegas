<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

///////////////contador categoria//////////////////
$cont = 0;
$consulta = pg_query("select max(id_categoria) from categoria");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
/////////////////////////////////////////////////

////////////////guardar categoria//////////////
pg_query("insert into categoria values('$cont','$_POST[nombre_categoria]','Activo')");
$data = 1;
/////////////////////////////////////////////

echo $data;
?>
