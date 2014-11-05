<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////datos series/////
$campo1 = $_POST['campo1'];
$campo2 = $_POST['campo2'];

$arreglo1 = explode('|', $campo1);
$arreglo2 = explode('|', $campo2);
$nelem = count($arreglo1);
//////////////////////
///////////////////////////////////////////
for ($i = 1; $i < $nelem; $i++) {

    $cont = 0;
    ///////////compara productos///////////////
    $consulta2 = pg_query("select * from bodega_productos where cod_productos = '$arreglo1[$i]' and id_bodega='$_POST[id_bodega]'");
    while ($row = pg_fetch_row($consulta2)) {
        $cont++;
    }

    if ($cont == 0) {
        $cont1 = 0;
        /////////////////contador productos bodega/////////////
        $consulta = pg_query("select max(id_bodega_productos) from bodega_productos");
        while ($row = pg_fetch_row($consulta)) {
            $cont1 = $row[0];
        }
        $cont1++;
        /////////////////////////////////////////////  
        //
        ///guardar bodega_productos//////////////////
        pg_query("insert into bodega_productos values('$cont1','$arreglo1[$i]','$_POST[id_bodega]','$arreglo2[$i]','$_POST[fecha_actual]','$_POST[hora_actual]','$_SESSION[id]','Activo','','')");
        ////////////////////////////////   
        //
        ///////////////stock productos////////////////
        $consulta3 = pg_query("select * from productos where cod_productos = '$arreglo1[$i]'");
        while ($row = pg_fetch_row($consulta3)) {
            $stock = $row[13];
        }
        $cal = $stock - $arreglo2[$i];
        pg_query("Update productos Set stock='" . $cal . "' where cod_productos='" . $arreglo1[$i] . "'");
        //////////////////////////////////////////////
    } else {
        ////////////////stock productos///////////////
        $consulta4 = pg_query("select * from productos where cod_productos = '$arreglo1[$i]'");
        while ($row = pg_fetch_row($consulta4)) {
            $stock = $row[13];
        }
        $cal = $stock - $arreglo2[$i];
        pg_query("Update productos Set stock='" . $cal . "' where cod_productos='" . $arreglo1[$i] . "'");
        ////////////////////////////////////////////////
        //
        /////////////////////Stock bodega////////////////
        $consulta5 = pg_query("select * from bodega_productos where cod_productos = '$arreglo1[$i]' and id_bodega='$_POST[id_bodega]'");
        while ($row = pg_fetch_row($consulta5)) {
            $stock2 = $row[3];
        }
        $cal2 = $stock2 + $arreglo2[$i];
        pg_query("Update bodega_productos Set stock_bodega='" . $cal2 . "' where cod_productos='" . $arreglo1[$i] . "' and id_bodega='$_POST[id_bodega]'");
        //////////////////////////////////////////////////
    }
}
$data = 1;
echo $data;
?>
