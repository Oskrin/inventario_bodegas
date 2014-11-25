<?php

include '../procesos/base.php';
conectarse();
$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
$search = $_GET['_search'];
if (!$sidx)
    $sidx = 1;

$result = pg_query("SELECT COUNT(*) AS count FROM productos");
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

if ($_GET['categoria'] == "") {
    $SQL = "select * from productos where articulo like '%$_GET[valor]%' and estado = 'Activo' ORDER BY $sidx $sord offset $start limit $limit";

    $result = pg_query($SQL);
    header("Content-type: text/xml;charset=utf-8");
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";
    while ($row = pg_fetch_array($result)) {
        $s .= "<row id='" . $row[0] . "'>";
        $s .= "<cell>" . $row[0] . "</cell>";
        $s .= "<cell>" . $row[1] . "</cell>";
        $s .= "<cell>" . $row[3] . "</cell>";
        $s .= "<cell>" . $row[6] . "</cell>";
        $s .= "<cell>" . $row[13] . "</cell>";
        $s .= "</row>";
    }
} else {
    $SQL = "select * from productos where categoria = '$_GET[categoria]' and articulo like '%$_GET[valor]%' and estado = 'Activo' ORDER BY $sidx $sord offset $start limit $limit";

    $result = pg_query($SQL);
    header("Content-type: text/xml;charset=utf-8");
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";
    while ($row = pg_fetch_array($result)) {
        $s .= "<row id='" . $row[0] . "'>";
        $s .= "<cell>" . $row[0] . "</cell>";
        $s .= "<cell>" . $row[1] . "</cell>";
        $s .= "<cell>" . $row[3] . "</cell>";
        $s .= "<cell>" . $row[6] . "</cell>";
        $s .= "<cell>" . $row[13] . "</cell>";
        $s .= "</row>";
    }
}
$s .= "</rows>";
echo $s;
?>
