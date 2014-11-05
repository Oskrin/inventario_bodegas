<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////contador productos//////////
$cont = 0;
$consulta = pg_query("select max(cod_productos) from productos");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
////////////////////////////////////////

///////////////valores imagen//////////
$extension = explode(".", $_FILES["archivo"]["name"]);

$extension = end($extension);
$type = $_FILES["archivo"]["type"];
$tmp_name = $_FILES["archivo"]["tmp_name"];
$size = $_FILES["archivo"]["size"];
$nombre = basename($_FILES["archivo"]["name"], "." . $extension);
//////////////////////////

$foto = $cont . '.' . $extension;
move_uploaded_file($_FILES["archivo"]["tmp_name"], "../fotos_productos/" . $foto);



/////////////////guardar productos///////
$valor = number_format($_POST[precio_compra], 2, '.', '');
pg_query("insert into productos values('$cont','$_POST[cod_prod]','$_POST[cod_barras]','$_POST[nombre_art]','$_POST[iva]','$_POST[series]','$valor','$_POST[utilidad_minorista]','$_POST[utilidad_mayorista]','$_POST[precio_minorista]','$_POST[precio_mayorista]','$_POST[categoria]','$_POST[marca]','$_POST[stock]','$_POST[minimo]','$_POST[maximo]','$_POST[fecha_creacion]','$_POST[modelo]','$_POST[aplicacion]','$_POST[descuento]','$_POST[vendible]','$_POST[inventario]','$foto')");
////////////////////////////////////////
//////////////////inicializar kardex////////
//
/////////////contador kardex//////////
$cont2 = 0;
$consulta2 = pg_query("select max(id_kardex) from kardex_valorizado");
while ($row = pg_fetch_row($consulta2)) {
    $cont2 = $row[0];
}
$cont2++;

$saldo = $_POST[stock] * $_POST[precio_compra];
$format_numero = number_format($saldo, 2, '.', '');
pg_query("insert into kardex_valorizado values('$cont2','$cont','$_POST[fecha_creacion]','Inventario inicial','','','$_POST[stock]','$valor','0.00','','','$format_numero','Activo')");
////////////////////////////////////////

$data = 1;
echo $data;
?>
