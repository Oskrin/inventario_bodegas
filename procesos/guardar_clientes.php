<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

///////////////////contador clientes////////////////////////
$cont = 0;
$consulta = pg_query("select max(id_cliente) from clientes");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
/////////////////////////////////////////////////////////

if (pg_query("insert into clientes values('$cont','$_POST[tipo_docu]','$_POST[ruc_ci]','$_POST[nombres_cli]','$_POST[tipo_cli]','$_POST[direccion_cli]','$_POST[nro_telefono]','$_POST[nro_celular]','$_POST[pais_cli]','$_POST[ciudad_cli]','$_POST[email]','$_POST[cupo_credito]','$_POST[notas_cli]','Activo')")) {
    $data = 1;
}

echo $data;
?>
