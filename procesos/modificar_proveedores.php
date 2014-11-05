<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

////////////////////modificar proveedores///////////////
pg_query("Update proveedores Set tipo_documento='$_POST[tipo_docu]', identificacion_pro='$_POST[ruc_ci]',empresa_pro='$_POST[empresa_pro]',representante_legal='$_POST[representante_legal]',visitador='$_POST[visitador]',direccion_pro='$_POST[direccion_pro]',telefono='$_POST[nro_telefono]',celular='$_POST[nro_celular]',fax='$_POST[fax]',pais='$_POST[pais_pro]',ciudad='$_POST[ciudad_pro]',forma_pago='$_POST[forma_pago]',correo='$_POST[correo]',principal='$_POST[principal_pro]' ,observaciones='$_POST[observaciones_pro]' ,estado='Activo' where id_proveedor='$_POST[id_proveedor]'");
///////////////////////////////////////////////////////

$data = 1;
echo $data;
?>
