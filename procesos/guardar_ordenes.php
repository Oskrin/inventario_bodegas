<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////datos ordenes de produccion/////
$campo1 = $_POST['campo1'];
$campo2 = $_POST['campo2'];
////////////////////////////////////
//
//////descompner arreglo///////////
$arreglo1 = explode('|', $campo1);
$arreglo2 = explode('|', $campo2);
$nelem1 = count($arreglo1);
//////////////////////////////////
//
/////////////////contador ordenes de produccion///////////
$cont1 = 0;
$consulta = pg_query("select max(id_ordenes) from ordenes_produccion");
while ($row = pg_fetch_row($consulta)) {
    $cont1 = $row[0];
}
$cont1++;

for ($i = 0; $i <= $nelem1; $i++) {

    ////////////guardar ordenes produccion////////
    pg_query("insert into ordenes_produccion values('$cont1','$_SESSION[id]','$_POST[comprobante]','$_POST[fecha_actual]','$_POST[hora_actual]','$arreglo1[$i]','$arreglo2[$i]','$_POST[subtotal]','Activo')");
    ////////////////////////////////////////
    //
    ////////modificar stock y precio del producto///
    $consulta2 = pg_query("select * from productos where cod_productos = '$arreglo1[$i]'");
    while ($row = pg_fetch_row($consulta2)) {
        $stock = $row[13];
        $utilidad_mi = $row[7];
        $utilidad_ma = $row[8];
    }

    $cal = $stock + $arreglo2[$i];
    $precio_costo = $_POST['subtotal'] / $arreglo2[$i];
    $format_numero = number_format($precio_costo, 2, '.', '');

    $total1 = ($format_numero * $utilidad_mi) / 100;
    $total2 = $format_numero + $total1;
    $utilidad_numero_mi = number_format($total2, 2, '.', '');

    $total3 = ($format_numero * $utilidad_ma) / 100;
    $total4 = $format_numero + $total3;
    $utilidad_numero_ma = number_format($total4, 2, '.', '');
    pg_query("Update productos Set precio_compra='" . $format_numero . "', iva_minorista = '" . $utilidad_numero_mi . "' , iva_mayorista = '" . $utilidad_numero_ma . "' , stock='" . $cal . "' where cod_productos='" . $arreglo1[$i] . "'");
    ///////////////////////////////////////////
}

/////detalles ordenes produccion//
$campo3 = $_POST['campo3'];
$campo4 = $_POST['campo4'];
$campo5 = $_POST['campo5'];
$campo6 = $_POST['campo6'];
///////////////////////////////
//
////////////agregar detalle_factura_compra////////
$arreglo3 = explode('|', $campo3);
$arreglo4 = explode('|', $campo4);
$arreglo5 = explode('|', $campo5);
$arreglo6 = explode('|', $campo6);
$nelem2 = count($arreglo3);
///////////////////////////////////////////
//
////////////////detalle ordenes produccion/////
for ($j = 0; $j <= $nelem2; $j++) {

    /////////////////contador detalle ordenes produccion/////////////
    $cont2 = 0;
    $consulta = pg_query("select max(id_detalles_ordenes) from detalles_ordenes");
    while ($row = pg_fetch_row($consulta)) {
        $cont2 = $row[0];
    }
    $cont2++;
    //////////////////////////  
    //
    ///guardar detalle_ordenes produccion/////
    pg_query("insert into detalles_ordenes values('$cont2','$cont1','$arreglo3[$j]','$arreglo4[$j]','$arreglo5[$j]','$arreglo6[$j]','Activo')");
    ////////////////////////////////
    //
    //////////////modificar productos///////////
    $consulta2 = pg_query("select * from productos where cod_productos = '$arreglo3[$j]'");
    while ($row = pg_fetch_row($consulta2)) {
        $stock2 = $row[13];
    }
    $cal2 = $stock2 - $arreglo4[$j];

    pg_query("Update productos Set stock='" . $cal2 . "' where cod_productos='" . $arreglo3[$j] . "'");
    ///////////////////////////////////////////
}

$data = 1;
echo $data;
?>
