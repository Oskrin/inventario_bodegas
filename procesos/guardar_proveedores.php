<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

//////////contador proveedores////////////
$cont = 0;
$consulta = pg_query("select max(id_proveedor) from proveedores");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
////////////////guardar proveedores////////////////
pg_query("insert into proveedores values('$cont','$_POST[tipo_docu]','$_POST[ruc_ci]','$_POST[empresa_pro]','$_POST[representante_legal]','$_POST[visitador]','$_POST[direccion_pro]','$_POST[nro_telefono]','$_POST[nro_celular]','$_POST[fax]','$_POST[pais_pro]','$_POST[ciudad_pro]','$_POST[forma_pago]','$_POST[correo]','$_POST[principal_pro]','$_POST[observaciones_pro]','Activo')");
//////////////////////////////////////////////////

$data = 1;
echo $data;
?>
