<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////datos detalle factura/////
$campo1 = $_POST['campo1'];
$campo2 = $_POST['campo2'];
$campo3 = $_POST['campo3'];
$campo4 = $_POST['campo4'];
$campo5 = $_POST['campo5'];
$campo6 = $_POST['campo6'];
///////////////////////////////
//
/////////////////contador inventario///////////
$cont1 = 0;
$consulta = pg_query("select max(id_inventario) from inventario");
while ($row = pg_fetch_row($consulta)) {
    $cont1 = $row[0];
}
$cont1++;
//////////////////////////////////////////////////
//
////////////guardar factura compra////////
pg_query("insert into inventario values('$cont1','$_SESSION[id]','1','$_POST[comprobante]','$_POST[fecha_actual]','$_POST[hora_actual]','Activo')");
////////////////////////////////////////
//
////////////agregar detalle inventario////////
$arreglo1 = explode('|', $campo1);
$arreglo2 = explode('|', $campo2);
$arreglo3 = explode('|', $campo3);
$arreglo4 = explode('|', $campo4);
$arreglo5 = explode('|', $campo5);
$arreglo6 = explode('|', $campo6);
$nelem = count($arreglo1);
///////////////////////////////////////////

for ($i = 0; $i <= $nelem; $i++) {

    /////////////////contador detalle inventario/////////////
    $cont2 = 0;
    $consulta = pg_query("select max(id_detalle_inventario) from detalle_inventario");
    while ($row = pg_fetch_row($consulta)) {
        $cont2 = $row[0];
    }
    $cont2++;
    //////////////////////////  
    //
    //////////////guardar detalle_factura////////
    pg_query("insert into detalle_inventario values('$cont2','$cont1','$arreglo1[$i]','$arreglo2[$i]','$arreglo3[$i]','$arreglo4[$i]','$arreglo5[$i]','$arreglo6[$i]','Activo')");
    ////////////////////////////////////////////
    //
    //////////////modificar productos///////////
//    $consulta2 = pg_query("select * from bodega_productos where cod_productos = '$arreglo1[$i]' and id_bodega='$_SESSION[id_bodega]'");
//    while ($row = pg_fetch_row($consulta2)) {
//        $utilidad_mi = $row[7];
//        $utilidad_ma = $row[8];
//    }
//    $total1 = ($arreglo2[$i] * $utilidad_mi) / 100;
//    $total2 = $arreglo2[$i] + $total1;
//    $total3 = ($arreglo2[$i] * $utilidad_ma) / 100;
//    $total4 = $arreglo2[$i] + $total3;

//    $format_numero = number_format($total2, 2, '.', '');
//    $format_numero2 = number_format($total4, 2, '.', '');

//    pg_query("Update productos Set precio_compra='" . $arreglo2[$i] . "', iva_minorista = '" . $format_numero . "' , iva_mayorista = '" . $format_numero2 . "' where cod_productos='" . $arreglo1[$i] . "'");
    pg_query("Update bodega_productos Set stock_bodega='" . $arreglo4[$i] . "' ,existencia='" . $arreglo4[$i] . "', diferencia='" . $arreglo6[$i] . "' where cod_productos='" . $arreglo1[$i] . "' and id_bodega='$_SESSION[id_bodega]'");
    ///////////////////////////////////////////
}
$data = 1;
echo $data;
?>
