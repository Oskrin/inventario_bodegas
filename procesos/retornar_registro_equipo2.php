<?php

include 'base.php';
conectarse();
error_reporting(0);
$id = $_GET['com'];
$arr_data = array();

$consulta = pg_query("select R.id_registro, C.id_cliente, C.nombres_cli, R.fecha_ingreso, R.fecha_salida, CA.id_categoria, CA.nombre_categoria, R.modelo, R.nro_serie, CO.id_color, CO.nombre_color, M.id_marca, M.nombre_marca, U.nombre_usuario, U.apellido_usuario, R.observaciones, R.detalles  from registro_equipo R, clientes C, categoria CA, color CO, marcas M, usuario U where R.id_color = CO.id_color and R.id_marca = M.id_marca and R.id_cliente = C.id_cliente and R.id_usuario = U.id_usuario and R.id_categoria = CA.id_categoria and R.estado = '0' and R.id_registro > '$id' order by R.id_registro asc limit 1");
while ($row = pg_fetch_row($consulta)) {
    $arr_data[] = $row[0];
    $arr_data[] = $row[1];
    $arr_data[] = $row[2];
    $arr_data[] = $row[3];
    $arr_data[] = $row[4];
    $arr_data[] = $row[5];
    $arr_data[] = $row[6];
    $arr_data[] = $row[7];
    $arr_data[] = $row[8];
    $arr_data[] = $row[9];
    $arr_data[] = $row[10];
    $arr_data[] = $row[11];
    $arr_data[] = $row[12];
    $arr_data[] = $row[13];
    $arr_data[] = $row[14];
    $arr_data[] = $row[15];
    $arr_data[] = $row[16];
}
echo json_encode($arr_data);
?>
