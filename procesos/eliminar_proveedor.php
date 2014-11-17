<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////////eliminar proveedores////////////////////
pg_query("Update proveedores Set estado='Pasivo' where id_proveedor='$_POST[id_proveedor]'");
//////////////////////////////////////////////////////

$data = 1;
echo $data;
?>