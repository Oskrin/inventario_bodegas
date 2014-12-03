<?php

function conectarse() {
    if (!($conexion = pg_pconnect("host=localhost port=5432 dbname=inventario_bodegas user=postgres password=rootdow"))) {
        exit();
    }
    return $conexion;
}

conectarse();
?>
