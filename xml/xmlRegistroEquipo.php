<?php

include '../procesos/base.php';
$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
$search = $_GET['_search'];


if (!$sidx)
    $sidx = 1;
$result = pg_query("SELECT COUNT(*) AS count FROM registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and registro_equipo.estado='0'");
$row = pg_fetch_row($result);
$count = $row[0];
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages)
    $page = $total_pages;
$start = $limit * $page - $limit;
if ($start < 0)
    $start = 0;

if ($search == "true") {
    if ($_GET['searchOper'] == "eq") {
        if ($_GET['searchField'] == "txtCliente") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and (clientes.nombres_cli ='$_GET[searchString]') and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtSerie") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and registro_equipo.nro_serie='$_GET[searchString]' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtTipoEquipo") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and categoria.nombre_categoria='$_GET[searchString]' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtMarca") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and marcas.nombre_marca='$_GET[searchString]' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtColor") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and color.nombre_color='$_GET[searchString]' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "Estado") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and registro_equipo.estado='$_GET[searchString]' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
    }
    if ($_GET['searchOper'] == "bw") {
        if ($_GET['searchField'] == "txtCliente") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and (clientes.nombres_cli like'%$_GET[searchString]%') and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtSerie") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and registro_equipo.nro_serie like '%$_GET[searchString]%' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtTipoEquipo") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and categoria.nombre_categoria like '%$_GET[searchString]%' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtMarca") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and marcas.nombre_marca like '%$_GET[searchString]%' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "txtColor") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and color.nombre_color like '%$_GET[searchString]%' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
        if ($_GET['searchField'] == "Estado") {
            $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and registro_equipo.estado like '%$_GET[searchString]%' and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
        }
    }
} else {
    $SQL = "select * from registro_equipo,color,marcas,clientes,usuario,categoria where registro_equipo.id_color=color.id_color and registro_equipo.id_marca=marcas.id_marca and registro_equipo.id_cliente=clientes.id_cliente and registro_equipo.id_usuario=usuario.id_usuario and registro_equipo.id_categoria=categoria.id_categoria and registro_equipo.estado='0' ORDER BY $sidx $sord offset $start limit $limit";
}

$result = pg_query($SQL);
header("Content-type: text/xml;charset=utf-8");
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .= "<rows>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
while ($row = pg_fetch_row($result)) {
    $s .= "<row id='" . $row[0] . "'>";
    $s .= "<cell>" . $row[0] . "</cell>";
    $s .= "<cell>" . $row[24] . "</cell>";
    $s .= "<cell>" . $row[21] . "</cell>";
    $s .= "<cell>" . $row[9] . "</cell>";
    $s .= "<cell>" . $row[12] . "</cell>";
    $s .= "<cell>" . $row[4] . "</cell>";
    $s .= "<cell>" . $row[11] . "</cell>";
    $s .= "<cell>" . $row[46] . "</cell>";
    $s .= "<cell>" . $row[47] . "</cell>";
    $s .= "<cell>" . $row[18] . "</cell>";
    $s .= "<cell>" . $row[19] . "</cell>";
    $s .= "<cell>" . $row[15] . "</cell>";
    $s .= "<cell>" . $row[16] . "</cell>";
    $s .= "<cell>" . $row[6] . "</cell>";
    $s .= "<cell>" . $row[5] . "</cell>";
    $s .= "<cell>" . $row[35] . "</cell>";
    $s .= "<cell>" . $row[36] . " " . $row[37] . "</cell>";
    $s .= "<cell>" . $row[7] . "</cell>";
    if ($row[7] == "0") {
        $s .= "<cell>" . "Recibido" . "</cell>";
    }
    if ($row[7] == "1") {
        $s .= "<cell>" . "Reparado" . "</cell>";
    }
    if ($row[7] == "2") {
        $s .= "<cell>" . "Entregado" . "</cell>";
    }
    if ($row[7] == "3") {
        $s .= "<cell>" . "En reparación" . "</cell>";
    }
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>
