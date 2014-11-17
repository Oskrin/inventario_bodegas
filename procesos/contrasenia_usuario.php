<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

$contrasena = md5($_POST['verificar_nueva']);

///////////////////modificar usuario//////////////////
pg_query("Update usuario Set clave='$contrasena' where id_usuario='$_POST[id_usuario]'");

///////////////////////////////////////////////////////

$data = 1;
echo $data;
?>
