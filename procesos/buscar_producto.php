<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];

$consulta = pg_query("select * from productos where codigo like '%$texto2%'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[1],
        'producto' => $row[3],
        'precio' => $row[6],
        'iva_producto' => $row[4],
        'carga_series' => $row[5],
        'cod_producto' => $row[0]
    );
}

$consulta2 = pg_query("select * from productos where cod_barras like '%$texto2%'");
while ($row = pg_fetch_row($consulta2)) {
    $data[] = array(
        'value' => $row[1],
        'producto' => $row[3],
        'precio' => $row[6],
        'iva_producto' => $row[4],
        'carga_series' => $row[5],
        'cod_producto' => $row[0]
    );
}

echo $data = json_encode($data);
?>
