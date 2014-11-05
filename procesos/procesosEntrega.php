<?php
include 'base.php';
conectarse();
session_start();
$data=0;
pg_query("update registro_equipo set estado='2',fecha_salida='$_POST[hoy]',descuento='$_POST[descuento]' where id_registro='$_POST[id_registro]'");

echo $data=0;
?>



	