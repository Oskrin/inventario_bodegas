<?php

session_start();
include 'base.php';
conectarse();
$data = "";
$cont = 0;

$contrasena = md5($_POST['clave']);

$consulta = pg_query("select * from usuario where usuario='$_POST[usuario]' and clave='$contrasena'");
while ($row = pg_fetch_row($consulta)) {
    $cont = 1;
    $_SESSION['id'] = $row[0];
    $_SESSION['nombres'] = $row[1] . " " . $row[2];
    $_SESSION['cargo'] = $row[6];
    $_SESSION['user'] = $row[10];
    $_SESSION['id_bodega'] = $row[11];
}

$_SESSION['empresa'] = "Alizon Online ";
$_SESSION['slogan'] = "SERVICIOS INTEGRALES";
$_SESSION['propietario'] = "JUAN PABLO GUERRA";
$_SESSION['direccion'] = "Av. Bolivar";
$_SESSION['telefono'] = "";
$_SESSION['celular'] = "0994793032";
$_SESSION['pais_ciudad'] = "Cotacahi - Ecuador";

if ($cont == 1) {
    $data = 1;
} else {
    $data = 0;
}

echo $data;
?>
