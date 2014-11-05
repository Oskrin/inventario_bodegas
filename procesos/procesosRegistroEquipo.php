<?php
include 'base.php';
conectarse();
session_start();
$data=1;

if($_POST['tipo']=="g")
{
pg_query("insert into registro_equipo values('$_POST[txtRegistro]','$_POST[txtColorId]','$_POST[txtMarcaId]','$_POST[txtClienteId]','$_POST[txtSerie]','$_POST[txtObservaciones]','$_POST[txtAccesorios]','0','$_SESSION[id]','$_POST[txtIngreso]','$_POST[txtTipoEquipoId]','$_POST[txtModelo]','$_POST[txtSalida]','0','')");
$data=0;
}
if($_POST['tipo']=="m")
{	
	pg_query("update registro_equipo set id_registro='$_POST[txtRegistro]',id_color='$_POST[txtColorId]',id_marca='$_POST[txtMarcaId]',id_cliente='$_POST[txtClienteId]',nro_serie='$_POST[txtSerie]',observaciones='$_POST[txtObservaciones]',detalles='$_POST[txtAccesorios]',estado='0',id_usuario='$_SESSION[id]',fecha_ingreso='$_POST[txtIngreso]',id_categoria='$_POST[txtTipoEquipoId]',modelo='$_POST[txtModelo]',fecha_salida='$_POST[txtSalida]' where id_registro='$_POST[txtRegistro]'");
	$data=0;
}
echo $data=0;
?>



	