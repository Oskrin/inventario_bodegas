<?php
function conectarse() {
	//if (!($conexion = pg_pconnect("dbname=df2jp28bdkuafd host=ec2-54-204-32-91.compute-1.amazonaws.com port=5432 user=larfyvwbaurpxo password=WV84lJxFXf7aqF6BXCXgwcI-tC sslmode=require"))) {			   
		if (!($conexion = pg_pconnect("host=localhost port=5432 dbname=mantenimiento_inventario user=postgres password=root"))) {			   
        exit();
    } else {   
          
    }
    return $conexion;
}
conectarse();

?>
