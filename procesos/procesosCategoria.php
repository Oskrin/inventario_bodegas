<?php

session_start();
include 'base.php';
conectarse();
$cont = 0;
$repe = 0;

if ($_POST['oper'] == "add") {
    $consulta = pg_query("select max(id_categoria) from categoria");
    while ($row = pg_fetch_row($consulta)) {
        $cont = $row[0];
    }
    $cont++;

    $consulta2 = pg_query("select * from categoria where nombre_categoria='$_POST[nombre_categoria]'");
    while ($row = pg_fetch_row($consulta2)) {
        $repe++;
    }
    if ($repe == 0) {
        pg_query("insert into categoria values('$cont','$_POST[nombre_categoria]','Activo')");
    }
}
if ($_POST['oper'] == "edit") {
    pg_query("update categoria set id_categoria='$_POST[id_categoria]', nombre_categoria='$_POST[nombre_categoria]' where id_categoria='$_POST[id_categoria]'");
}
?>
