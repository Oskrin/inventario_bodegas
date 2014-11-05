<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$id = $_GET['com'];
$arr_data = array();

$consulta = pg_query("select  P.cod_productos, P.codigo, P.articulo, D.cantidad, D.precio_costo, D.total_costo from detalles_ordenes D, productos P where D.cod_productos= P.cod_productos and D.id_ordenes='" . $id . "'");

while ($row = pg_fetch_row($consulta)) {
    $arr_data[] = $row[0];
    $arr_data[] = $row[1];
    $arr_data[] = $row[2];
    $arr_data[] = $row[3];
    $arr_data[] = $row[4];
    $arr_data[] = $row[5];
}
echo json_encode($arr_data);
?>
