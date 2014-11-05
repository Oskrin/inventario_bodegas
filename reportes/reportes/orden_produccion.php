<?php
require('../dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../../images/logo_empresa.jpg" />
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
        <h3>ORDENES DE PRODUCCIÓN</h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();  
    $sum=0; 
    $cant=0;
    $sql=pg_query("select * from ordenes_produccion,productos where ordenes_produccion.cod_productos=productos.cod_productos and id_ordenes='$_GET[id]'");
    $codigo.='<table style="border:solid 0px;" border=0>';                      
    while($row=pg_fetch_row($sql)){
        $codigo.='<tr>                
        <td style="width:110px;text-align:left;font-weight:bold">Comprobante Nro:</td>    
        <td style="width:70px;text-align:left;">'.$row[2].'</td>    
        <td style="width:100px;text-align:left;font-weight:bold">Fecha:</td>    
        <td style="width:100px;text-align:left;">'.$row[3].'</td>    
        <td style="width:100px;text-align:left;font-weight:bold">Cantidad:</td>    
        <td style="width:100px;text-align:left;">'.$row[6].'</td>    
        <td style="width:100px;text-align:left;font-weight:bold">Precio Venta:</td>    
        <td style="width:70px;text-align:left;">'.$row[18].'</td>    
        </tr>';
        $cant=$row[6];
        $codigo.='<tr>                
        <td style="text-align:left;font-weight:bold">Código :</td>    
        <td colspan="2" style="text-align:left;">'.$row[10].'</td>    
        <td style="text-align:left;font-weight:bold">Prodcuto:</td>    
        <td colspan="2" style="text-align:left;">'.$row[12].'</td>    
        <td style="text-align:left;font-weight:bold">T. Precio Venta:</td>    
        <td style="text-align:left;">'.(number_format(($row[6]*$row[18]),2,',','.')).'</td>    
        </tr>';
    }
    $codigo.='</table><br/>'; 

    $codigo.='<table>';                      
    $codigo.='<tr>                
    <td style="width:70px;text-align:center;">Cantidad</td>
    <td style="width:200px;text-align:center;">Cod. Producto</td>
    <td style="width:300px;text-align:center;">Descripción</td>
    <td style="width:70px;text-align:center;">P. Unitario</td>
    <td style="width:70px;text-align:center;">P. Total</td></tr><hr>';
    $codigo.='</table>';
    $sql=pg_query("select * from detalles_ordenes,productos where detalles_ordenes.cod_productos=productos.cod_productos and id_ordenes='$_GET[id]'");
    $codigo.='<table>';                      
    while($row=pg_fetch_row($sql)){
        $codigo.='<tr>                
        <td style="width:70px;text-align:center;">'.$row[3].'</td>
        <td style="width:200px;text-align:left;">'.$row[8].'</td>
        <td style="width:300px;text-align:left;">'.$row[10].'</td>
        <td style="width:70px;text-align:center;">'.$row[4].'</td>
        <td style="width:70px;text-align:center;">'.$row[5].'</td></tr>';   
        $sum=$sum+$row[5];     
    }
    $codigo.='</table>';
    $codigo.='<hr>';
    $codigo.='<table>';                                                
    $codigo.='<tr>
    <td style="width:650px;text-align:right;font-weight:bold">'."Total Orden".'</td>
    <td style="width:80px;text-align:center;font-weight:bold">'.(number_format($sum,2,',','.')).'</td>';
    $codigo.='</tr>';                           
    $codigo.='<tr>
    <td style="width:650px;text-align:right;font-weight:bold">'."Precio por Producto".'</td>
    <td style="width:80px;text-align:center;font-weight:bold">'.(number_format(($sum/$cant),2,',','.')).'</td>';
    $codigo.='</tr>';                           
    $codigo.='</table>'; 
    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('orden_produccion.pdf',array('Attachment'=>0));
?>