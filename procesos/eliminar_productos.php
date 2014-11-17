<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////////eliminar productos////////////////////
pg_query("Update productos Set estado='Pasivo' where cod_productos='$_POST[cod_productos]'");
//////////////////////////////////////////////////////

$data = 1;
echo $data;
?>