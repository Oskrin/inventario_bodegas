<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];
$consulta = pg_query("select * from bodegas where nombre_bodega like '%$texto2%'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[1],
        'id_bodega' => $row[0],
    );
}
echo $data = json_encode($data);
?>