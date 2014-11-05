<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////////eliminar clientes////////////////////
pg_query("delete  from productos where cod_productos='$_POST[cod_productos]'");
//////////////////////////////////////////////////////

$data = 1;
echo $data;
?>