<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////////eliminar clientes////////////////////
pg_query("delete  from proveedores where id_proveedor='$_POST[id_proveedor]'");
//////////////////////////////////////////////////////

$data = 1;
echo $data;
?>