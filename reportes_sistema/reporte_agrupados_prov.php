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
        <h3>PRODUCTOS AGRUPADOS POR PROVEEDOR </h3>
    </div>';
    include '../procesos/base.php';
    conectarse();    
    $total=0;
    $repetido=0;    
    $sql=pg_query("select proveedores.id_proveedor, identificacion_pro,empresa_pro from proveedores,factura_compra where proveedores.id_proveedor='$_GET[id]' LIMIT 1");
    while($row=pg_fetch_row($sql)){          
        $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">RUC/CI: '.$row[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[2].'</h2><br />';                    
    }
    $sql=pg_query("select proveedores.id_proveedor, identificacion_pro,factura_compra.id_factura_compra,num_serie from proveedores,factura_compra where proveedores.id_proveedor='$_GET[id]' and factura_compra.id_proveedor=proveedores.id_proveedor");
    while($row=pg_fetch_row($sql)){
        $sql1=pg_query("select detalle_factura_compra.id_detalle_compra,productos.codigo,productos.articulo,productos.iva_minorista,productos.iva_mayorista,productos.stock,detalle_factura_compra.precio_compra,total_compra,cantidad from detalle_factura_compra,productos where detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$row[2]' order by id_detalle_compra asc");
        $codigo.='<div id="cuerpo">';
        $codigo.='<table border=0>';                      
        while($row1=pg_fetch_row($sql1)){
            if($repetido==0){     
                $codigo.='<tr>                
                <td style="width:150px;text-align:center;">Nro Factura</td>    
                <td style="width:100px;text-align:center;">Código</td>
                <td style="width:150px;text-align:center;">Producto</td>
                <td style="width:100px;text-align:center;">Precio Compra</td>
                <td style="width:100px;text-align:center;">Total Compra</td>
                <td style="width:100px;text-align:center;">Cantidad</td>
                </tr>
                <tr><td colspan=6><hr></td></tr>';
                $repetido=1;   
            }
            $codigo.='<tr>
                <td style="width:150px;text-align:center;">'.$row[3].'</td>    
                <td style="width:100px;text-align:center;">'.$row1[1].'</td>
                <td style="width:150px;text-align:center;">'.$row1[2].'</td>
                <td style="width:100px;text-align:center;">'.$row1[6].'</td>
                <td style="width:100px;text-align:center;">'.$row1[7].'</td>
                <td style="width:100px;text-align:center;">'.$row1[8].'</td>
            ';      
            $total=$total+$row1[7];          
        }
        $codigo.='</table>';    
        $codigo.='<hr>';
         $codigo.='<table>';                                                
        $codigo.='<tr>
        <td style="width:200px;text-align:left;font-weight:bold">'."Totales".'</td>
        <td style="width:80px;text-align:center;font-weight:bold">'.(number_format($total,2,',','.')).'</td>';
        $codigo.='</tr>';                           
        $codigo.='</table>';      
    }
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