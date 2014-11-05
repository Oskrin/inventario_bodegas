<?php
include 'base.php';
conectarse();
session_start();	
if($_POST['tipo']=="g")
{		
pg_query("update registro_equipo set tecnico='$_SESSION[nombres]', estado='3' where id_registro='$_POST[id_registro]'");
}

if($_POST['tipo']=="m")
{		
pg_query("update registro_equipo set tecnico='', estado='0' where id_registro='$_POST[id_registro]'");
}

?>