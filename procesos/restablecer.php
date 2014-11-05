<?php
include 'base.php';
$data=0;
pg_query("update registro_equipo set estado='0' where id_registro='$_POST[id]'");
$data=1;
echo $data;
?>
