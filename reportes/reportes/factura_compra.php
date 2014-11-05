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
        <h3>FACTURA COMPRA </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $sql=pg_query("select id_factura_compra,comprobante,fecha_actual,hora_actual,num_serie,num_autorizacion,fecha_cancelacion,empresa_pro,representante_legal,factura_compra.forma_pago from factura_compra,proveedores where factura_compra.id_proveedor=proveedores.id_proveedor and id_factura_compra='$_GET[id]'");    
    while($row=pg_fetch_row($sql)){
        $codigo.='<table border=0>'; 
        $codigo.='<tr>
        <td style="width:100px;text-align:left;">Comprobante</td>   
        <td style="width:130px;text-align:left;">'.$row[1].'</td>   
        <td style="width:100px;text-align:left;">Fecha</td>
        <td style="width:130px;text-align:left;">'.$row[2].'</td>   
        <td style="width:100px;text-align:left;">Hora</td>
        <td style="width:130px;text-align:left;">'.$row[3].'</td></tr>
        <tr><td style="width:100px;text-align:left;">Nro. de Serie</td>   
        <td style="width:130px;text-align:left;">'.$row[4].'</td>   
        <td style="width:100px;text-align:left;">Nro de Autorización</td>   
        <td style="width:130px;text-align:left;">'.$row[5].'</td>   
        <td style="width:100px;text-align:left;">Fecha de cancelación</td>
        <td style="width:130px;text-align:left;">'.$row[6].'</td></tr>   
        <tr><td style="width:100px;text-align:left;">Empresa</td>   
        <td style="width:130px;text-align:left;"colspan=3>'.$row[7].'</td>   
        <td style="width:100px;text-align:left;">Forma de Pago</td>   
        <td style="width:130px;text-align:left;">'.$row[9].'</td></tr>   
        <tr><td style="text-align:left;"colspan=1>Representante</td>
        <td style="text-align:left;"colspan=5>'.$row[8].'</td>';
        $codigo.='</tr>';                     
        $codigo.='</table>';
    }    
    $sql=pg_query("select detalle_factura_compra.cantidad,productos.articulo,detalle_factura_compra.precio_compra,detalle_factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");   
    $codigo.='<br/><table border=0><tr>';  
    $codigo.='<td style="width:100px;text-align:center;border:solid 1px;">Cantidad</td>
    <td style="width:400px;text-align:center;border:solid 1px;">Descripción</td>   
    <td style="width:100px;text-align:center;border:solid 1px;">V. Unitario</td>   
    <td style="width:100px;text-align:center;border:solid 1px;">V. Total</td>';
    while($row=pg_fetch_row($sql)){
        $codigo.='<tr>
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[0].'</td>   
        <td style="width:400px;text-align:left;border:solid 1px;">'.$row[1].'</td>   
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[2].'</td>   
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[3].'</td>   
        </tr>';
    }
    $codigo.='</table></tr>';
    $sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
    $codigo.='<table style="margin-left:385px;">';
    while($row=pg_fetch_row($sql)){
        $codigo.='
        <tr>
        <td style="width:100px;text-align:left;border:solid 1px;">Descuento</td>   
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[0].'</td>
        </tr>   
        <tr>
        <td style="width:100px;text-align:left;border:solid 1px;">Tarifa 0</td>  
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[1].'</td>
        </tr>   
        <tr>
        <td style="width:100px;text-align:left;border:solid 1px;">Tarifa 12</td>  
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[2].'</td>
        </tr>
        <tr>
        <td style="width:100px;text-align:left;border:solid 1px;">Iva 12%</td>  
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[3].'</td>
        </tr>   
        <tr>
        <td style="width:100px;text-align:left;border:solid 1px;">Total</td>  
        <td style="width:100px;text-align:left;border:solid 1px;">'.$row[4].'</td>
        </tr>';
    }
    $codigo.='</table>';  
    $sql=pg_query("select * from series_compra,factura_compra,productos where factura_compra.id_factura_compra=series_compra.id_factura_compra and productos.cod_productos=series_compra.cod_productos and series_compra.id_factura_compra='$_GET[id]'");
    if(pg_num_rows($sql)){
        $codigo.='<table style="page-break-before:always;width:760px">        
        <tr> 
        <td style="text-align:center;font-size:14px;" colspan=4 >
        <br/>
        <br/>
        NÚMEROS DE SERIE
        </td>
        </tr> 
        <br/>        
        <tr>        
        <td style="width:100px;text-align:center;border:solid 1px;">Cod Producto</td>
        <td style="width:300px;text-align:center;border:solid 1px;">Descripción</td>   
        <td style="width:150px;text-align:center;border:solid 1px;">Nro Serie</td>   
        <td style="width:150px;text-align:center;border:solid 1px;">Nro Factura</td>
        </tr>';
        while($row=pg_fetch_row($sql)){
            $codigo.='<tr>
                <td style="width:100px;text-align:center;border:solid 1px;">'.$row[28].'</td>
                <td style="width:300px;text-align:center;border:solid 1px;">'.$row[30].'</td>   
                <td style="width:150px;text-align:center;border:solid 1px;">'.$row[3].'</td>   
                <td style="width:150px;text-align:center;border:solid 1px;">'.$row[17].'</td>
            </tr>';
        }
        $codigo.='</table> '; 
    }
      
   
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('factura_compra.pdf',array('Attachment'=>0));
    
?>