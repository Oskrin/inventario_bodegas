<?php

session_start();
include 'base.php';
conectarse();
$cont = 0;


if ($_POST['oper'] == "add") {
    $consulta = pg_query("select max(id_bodega) from bodegas");
    while ($row = pg_fetch_row($consulta)) {
        $cont = $row[0];
    }
    $cont++;

    pg_query("insert into bodegas values('$cont','$_POST[nombre_bodega]', '$_POST[ubicacion]', '$_POST[telefono]', '$_POST[movil]','Activo')");
}
if ($_POST['oper'] == "edit") {
    pg_query("update bodegas set nombre_bodega='$_POST[nombre_bodega]', ubicacion='$_POST[ubicacion]', telefono='$_POST[telefono]',movil='$_POST[movil]' where id_bodega='$_POST[id_bodega]'");
}
?>
