<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

$consulta = pg_query("select id_bodega,nombre_bodega from bodegas");
while ($row = pg_fetch_row($consulta)) {   
       echo "<option id='$row[0]' value='$row[0]'> $row[1]</option>";
}
?>
