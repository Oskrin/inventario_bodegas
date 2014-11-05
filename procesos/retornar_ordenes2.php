<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$id = $_GET['com'];
$arr_data = array();

$consulta = pg_query("select  P.cod_productos, P.codigo, P.articulo, O.cantidad, P.iva_minorista, O.sub_total from ordenes_produccion O, productos P where O.cod_productos = P.cod_productos and O.comprobante='" . $id . "'");

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
