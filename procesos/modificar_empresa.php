<?php

include 'base.php';
conectarse();
error_reporting(0);


///////////////valores imagen//////////
$extension = explode(".", $_FILES["archivo"]["name"]);

$extension = end($extension);
$type = $_FILES["archivo"]["type"];
$tmp_name = $_FILES["archivo"]["tmp_name"];
$size = $_FILES["archivo"]["size"];
$nombre = basename($_FILES["archivo"]["name"], "." . $extension);
//////////////////////////

if ($nombre == ""  ) {
    pg_query("Update empresa Set nombre_empresa='$_POST[nombre_empresa]', ruc_empresa='$_POST[ruc_empresa]', direccion_empresa='$_POST[direccion_empresa]', telefono_empresa='$_POST[telefono_empresa]', celular_empresa='$_POST[celular_empresa]', fax_empresa='$_POST[fax_empresa]', email_empresa='$_POST[correo_empresa]' , pagina_web='$_POST[pagina_empresa]', descripcion='$_POST[descripcion_empresa]', propietario='$_POST[propietario_empresa]' where id_empresa='$_POST[id_empresa]' ");
} else {
    $foto = $_POST[id_empresa] . '.' . $extension;
    move_uploaded_file($_FILES["archivo"]["tmp_name"], "../fotos_empresa/" . $foto);
    pg_query("Update empresa Set nombre_empresa='$_POST[nombre_empresa]', ruc_empresa='$_POST[ruc_empresa]', direccion_empresa='$_POST[direccion_empresa]', telefono_empresa='$_POST[telefono_empresa]', celular_empresa='$_POST[celular_empresa]', fax_empresa='$_POST[fax_empresa]', email_empresa='$_POST[correo_empresa]' , pagina_web='$_POST[pagina_empresa]', descripcion='$_POST[descripcion_empresa]', propietario='$_POST[propietario_empresa]', imagen='$foto' where id_empresa='$_POST[id_empresa]' ");
}

$data = 1;
echo $data;
?>
