<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];
$tipo = $_GET['tipo_precio'];

$consulta = pg_query("select * from productos P, usuario U, bodega_productos B where P.articulo like '%$texto2%' and  P.cod_productos = B.cod_productos and B.id_bodega= U.id_bodega and U.id_bodega='$_SESSION[id_bodega]'");
while ($row = pg_fetch_row($consulta)) {
    if ($tipo == "MINORISTA") {
        $data[] = array(
            'value' => $row[3],
            'codigo' => $row[1],
            'p_venta' => $row[9],
            'disponibles' => $row[39],
            'iva_producto' => $row[4],
            'carga_series' => $row[5],
            'cod_producto' => $row[0],
            'des' => $row[19],
            'inventar' => $row[21]
        );
    } else {
        if ($tipo == "MAYORISTA") {
            $data[] = array(
                'value' => $row[3],
                'codigo' => $row[1],
                'p_venta' => $row[10],
                'disponibles' => $row[39],
                'iva_producto' => $row[4],
                'carga_series' => $row[5],
                'cod_producto' => $row[0],
                'des' => $row[19],
                'inventar' => $row[21]
            );
        }
    }
}

echo $data = json_encode($data);
?>
