<?php
require('../reportes/dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../images/logo_empresa.jpg" />
            <div id="me">
                <h2 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['empresa'].'</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['slogan'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['propietario'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['direccion'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: '.$_SESSION['telefono'].' Cel:  '.$_SESSION['celular'].' '.$_SESSION['pais_ciudad'].'</h4>
            </div>        
    </header>        
    <hr>
    <div id="linea">
        <h3>LISTA DE PRODUCTOS POR CATEGORÍAS Y MARCAS</h3>
    </div>';
    include '../procesos/base.php';
    conectarse();    
    $total=0;
    $repetido=0;   
    $codigo.='<div id="cuerpo">';
    
    if($_GET['marca']=="" && $_GET['categoria']==""){
         $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">MARCA: '."Todas".'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CATEGORÍA: '."Todas".'</h2><br />'; 
        $codigo.='<table border=0>';
         $codigo.='<tr style="font-weight:bold;">                
        <td style="width:200px;text-align:center;">Código</td>
        <td style="width:200px;text-align:center;">Producto</td>
        <td style="width:100px;text-align:center;">Precio Minorista</td>
        <td style="width:100px;text-align:center;">Precio Mayorista</td>
        <td style="width:100px;text-align:center;">Stock</td>
        </tr>
        <tr><td colspan=5><hr></td></tr>';
        $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos ");
        while($row=pg_fetch_row($sql)){
            $codigo.='<tr>                
            <td style="width:200px;text-align:center;">'.$row[0].'</td>    
            <td style="width:200px;text-align:center;">'.$row[2].'</td>
            <td style="width:100px;text-align:center;">'.$row[3].'</td>
            <td style="width:100px;text-align:center;">'.$row[4].'</td>
            <td style="width:100px;text-align:center;">'.$row[5].'</td>
            </tr>';
        }
        $codigo.='</table>';   
    }    
    if($_GET['marca']=="" && $_GET['categoria']!=""){
         $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">MARCA: '."Todas".'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CATEGORÍA: '.$_GET['categoria'].'</h2><br />';  
         $codigo.='<table border=0>';
        $codigo.='<tr style="font-weight:bold;">                
        <td style="width:200px;text-align:center;">Código</td>
        <td style="width:200px;text-align:center;">Producto</td>
        <td style="width:100px;text-align:center;">Precio Minorista</td>
        <td style="width:100px;text-align:center;">Precio Mayorista</td>
        <td style="width:100px;text-align:center;">Stock</td>
        </tr>
        <tr><td colspan=5><hr></td></tr>';
         $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where categoria='$_GET[categoria]'");
         while($row=pg_fetch_row($sql)){
            $codigo.='<tr>                
            <td style="width:200px;text-align:center;">'.$row[0].'</td>    
            <td style="width:200px;text-align:center;">'.$row[2].'</td>
            <td style="width:100px;text-align:center;">'.$row[3].'</td>
            <td style="width:100px;text-align:center;">'.$row[4].'</td>
            <td style="width:100px;text-align:center;">'.$row[5].'</td>
            </tr>';
         }
        $codigo.='</table>';  

    }
    if($_GET['marca']!="" && $_GET['categoria']==""){
         $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">MARCA: '.$_GET['marca'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CATEGORÍA: '."Todas".'</h2><br />';    
         $codigo.='<table border=0>';
        $codigo.='<tr style="font-weight:bold;">                
        <td style="width:200px;text-align:center;">Código</td>
        <td style="width:200px;text-align:center;">Producto</td>
        <td style="width:100px;text-align:center;">Precio Minorista</td>
        <td style="width:100px;text-align:center;">Precio Mayorista</td>
        <td style="width:100px;text-align:center;">Stock</td>
        </tr>
        <tr><td colspan=5><hr></td></tr>';
         $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where marca='$_GET[marca]'");
         while($row=pg_fetch_row($sql)){
            $codigo.='<tr>                
            <td style="width:200px;text-align:center;">'.$row[1].'</td>    
            <td style="width:200px;text-align:center;">'.$row[2].'</td>
            <td style="width:100px;text-align:center;">'.$row[3].'</td>
            <td style="width:100px;text-align:center;">'.$row[4].'</td>
            <td style="width:100px;text-align:center;">'.$row[5].'</td>
            </tr>';
         }
        $codigo.='</table>';
    }
    if($_GET['marca']!="" && $_GET['categoria']!=""){
         $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">MARCA: '.$_GET['marca'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CATEGORÍA: '.$_GET['categoria'].'</h2><br />';    
        $codigo.='<table border=0>';
        $codigo.='<tr style="font-weight:bold;">                
        <td style="width:200px;text-align:center;">Código</td>
        <td style="width:200px;text-align:center;">Producto</td>
        <td style="width:100px;text-align:center;">Precio Minorista</td>
        <td style="width:100px;text-align:center;">Precio Mayorista</td>
        <td style="width:100px;text-align:center;">Stock</td>
        </tr>
        <tr><td colspan=5><hr></td></tr>';
         $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,categoria,marca from productos where categoria='$_GET[categoria]' and marca='$_GET[marca]'");
         while($row=pg_fetch_row($sql)){
            $codigo.='<tr>                
            <td style="width:200px;text-align:center;">'.$row[1].'</td>    
            <td style="width:200px;text-align:center;">'.$row[2].'</td>
            <td style="width:100px;text-align:center;">'.$row[3].'</td>
            <td style="width:100px;text-align:center;">'.$row[4].'</td>
            <td style="width:100px;text-align:center;">'.$row[5].'</td>
            </tr>';
         }
        $codigo.='</table>';
    }
    $codigo.='</div>';

    
    
    
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporte_agrupados_prov.pdf',array('Attachment'=>0));
?>