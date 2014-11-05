<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];

$consulta = pg_query("select * from productos P, usuario U, bodega_productos B where P.articulo like '%$texto2%' and  P.cod_productos = B.cod_productos and B.id_bodega= U.id_bodega and U.id_bodega='$_SESSION[id_bodega]'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[3],
        'codigo' => $row[1],
        'precio' => $row[6],
        'stock' => $row[38],
        'p_venta' => $row[9],
        'existencia' => $row[22],
        'diferencia' => $row[23],
        'cod_producto' => $row[0]
    );
}

echo $data = json_encode($data);
?>
