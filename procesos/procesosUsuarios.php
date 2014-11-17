<?php

session_start();
include 'base.php';
conectarse();
$cont = 0;


if ($_POST['oper'] == "add") {
    $consulta = pg_query("select max(id_usuario) from usuario");
    while ($row = pg_fetch_row($consulta)) {
        $cont = $row[0];
    }
    $cont++;

    pg_query("insert into usuario values('$cont','$_POST[nombre_usuario]','$_POST[apellido_usuario]','$_POST[ci_usuario]','$_POST[telefono_usuario]','$_POST[celular_usuario]','$_POST[cargo_usuario]','$_POST[password_usuario]','$_POST[email_usuario]','$_POST[direccion_usuario]','$_POST[user]','$_POST[id_bodega]','Activo')");
} else {
    if ($_POST['oper'] == "edit") {
        pg_query("update usuario set id_usuario='$_POST[id_usuario]',nombre_usuario='$_POST[nombre_usuario]',apellido_usuario='$_POST[apellido_usuario]',ci_usuario='$_POST[ci_usuario]',telefono_usuario='$_POST[telefono_usuario]',celular_usuario='$_POST[celular_usuario]',cargo_usuario='$_POST[cargo_usuario]',clave='$_POST[password_usuario]',email_usuario='$_POST[email_usuario]',direccion_usuario='$_POST[direccion_usuario]',usuario='$_POST[user]',id_bodega='$_POST[id_bodega]' where id_usuario='$_POST[id_usuario]'");
        echo "update usuario set id_usuario='$_POST[id_usuario]',nombre_usuario='$_POST[nombre_usuario]',apellido_usuario='$_POST[apellido_usuario]',ci_usuario='$_POST[ci_usuario]',telefono_usuario='$_POST[telefono_usuario]',celular_usuario='$_POST[celular_usuario]',cargo_usuario='$_POST[cargo_usuario]',clave='$_POST[password_usuario]',email_usuario='$_POST[email_usuario]',direccion_usuario='$_POST[direccion_usuario]',usuario='$_POST[user]',id_bodega='$_POST[id_bodega]' where id_usuario='$_POST[id_usuario]'";
    }else{
       if ($_POST['oper'] == "del") {
          pg_query("update usuario set estado='Pasivo' where id_usuario='$_POST[id]'"); 
       } 
    }
}
?>
