<?php

session_start();
include 'base.php';
conectarse();
$cont = 0;
$repe = 0;

if ($_POST['oper'] == "add") {
    $consulta = pg_query("select max(id_marca) from marcas");
    while ($row = pg_fetch_row($consulta)) {
        $cont = $row[0];
    }
    $cont++;

    $consulta2 = pg_query("select * from marcas where nombre_marca='$_POST[nombre_marca]'");
    while ($row = pg_fetch_row($consulta2)) {
        $repe++;
    }
    if ($repe == 0) {
        pg_query("insert into marcas values('$cont','$_POST[nombre_marca]','Activo')");
    }
}
if ($_POST['oper'] == "edit") {
    pg_query("update marcas set id_marca='$_POST[id_marca]',nombre_marca='$_POST[nombre_marca]' where id_marca='$_POST[id_marca]'");
}
?>
