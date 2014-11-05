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
        <h3>CONSULTA DE LA SERIE ';
        $codigo.=$_GET['id'].'</h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $id_serie=0;
    $id_producto=0;
    $id_factura_venta=0;
    $id_factura_compra=0;
    $ci_cliente=0;
    $nombre_cliente="";
    $fecha_venta=0;
    $num_fac_venta=0;
    $ci_proveedor=0;
    $proveedor="";
    $fecha_compra=0;
    $num_fac_compra=0;
    $codigo_prod=0;
    $descripcion=0;
    $precio_venta=0;
    $precio_compra=0;
    $sql=pg_query("select * from serie_venta where serie='$_GET[id]'");
    while($row=pg_fetch_row($sql)){
        $id_serie=$row[0];
        $id_producto=$row[1];
        $id_factura_venta=$row[2];
    }
    $sql=pg_query("select * from series_compra where serie='$_GET[id]'");
    while($row=pg_fetch_row($sql)){
        $id_factura_compra=$row[2];
    }
    $sql=pg_query("select * from factura_venta,clientes where factura_venta.id_cliente=clientes.id_cliente and id_factura_venta='$id_factura_venta'");
    while($row=pg_fetch_row($sql)){
        $ci_cliente=$row[23];
        $nombre_cliente=$row[24];
        $fecha_venta=$row[6];
        $num_fac_venta=$row[5];
    }
    $sql=pg_query("select * from detalle_factura_venta,productos where  detalle_factura_venta.cod_productos=productos.cod_productos and id_factura_venta='$id_factura_venta' and productos.cod_productos='$id_producto'");
    while($row=pg_fetch_row($sql)){
        $codigo_prod=$row[10];
        $descripcion=$row[12];
        $precio_venta=$row[4];
    }

    $sql=pg_query("select * from factura_compra,proveedores where factura_compra.id_proveedor=proveedores.id_proveedor and id_factura_compra='$id_factura_compra'");
    while($row=pg_fetch_row($sql)){
        $ci_proveedor=$row[23];
        $proveedor=$row[24];
        $fecha_compra=$row[5];
        $num_fac_compra=$row[11];
    }
    $sql=pg_query("select * from detalle_factura_compra,productos where detalle_factura_compra.cod_productos=productos.cod_productos and id_factura_compra='$id_factura_compra' and productos.cod_productos='$id_producto'");
    while($row=pg_fetch_row($sql)){
        $precio_compra=$row[4];
    }
    $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:12px;">RUC/CI: '.$ci_cliente.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nombre_cliente.'</h2>';
    $codigo.='<table border=0 style="font-size:11px;">';                      
    $codigo.='<tr style="font-weight:bold;">                
    <td style="width:60px;text-aling:center;"># Factura</td>
    <td style="width:60px";text-align:center;>F. Venta</td>
    <td style="width:40px";text-align:center;>P. Venta</td>                       
    <td style="width:190px;text-align:center;">Producto</td>
    <td style="width:60px";text-align:center;>N. Compra</td>
    <td style="width:60px";text-align:center;>F. Compra</td>
    <td style="width:170px;text-align:center;">Proveedor</td>
    <td style="width:60px";text-align:center;>P. Compra</td>
    </tr><tr><td colspan=9><hr></td></tr>';
    
    $codigo.='<tr>                
    <td style="width:60px">'.substr($num_fac_venta,8,30).'</td>
    <td style="width:60px">'.$fecha_venta.'</td>
    <td style="width:40px">'.$precio_venta.'</td>                       
    <td style="width:190px">'.$descripcion.'</td>
    <td style="width:60px">'.substr($num_fac_compra,8,30).'</td>
    <td style="width:60px">'.$fecha_compra.'</td>
    <td style="width:170px">'.$proveedor.'</td>
    <td style="width:60px">'.$precio_compra.'</td>
    </tr>';

    $codigo.='</table>';        
    


      
   
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporte_seire.pdf',array('Attachment'=>0));

    
?>