<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];

$consulta = pg_query("select * from productos P, usuario U, bodega_productos B where P.articulo like '%$texto2%' and  P.cod_productos = B.cod_productos and B.id_bodega= U.id_bodega and U.id_bodega='$_SESSION[id_bodega]'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[3],
        'cod_producto2' => $row[0],
        'codigo2' => $row[1],
        'precio2' => $row[6],
        'disponibles' => $row[39]
    );
}

echo $data = json_encode($data);
?>
