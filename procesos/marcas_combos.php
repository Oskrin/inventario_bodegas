<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$consulta = pg_query("select * from marcas");
echo "<option value=''>Seleccione una Marca</option>";
while ($row = pg_fetch_row($consulta)) {
    if ($row['id_marca'] == $_GET['id']) {
        echo "<option selected id='$row[0]' value='$row[1]'> $row[1]</option>";
    } else {
        echo "<option id='$row[0]' value='$row[1]'> $row[1]</option>";
    }
}
?>
