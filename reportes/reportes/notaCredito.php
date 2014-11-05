4<?php
require('../dompdf/dompdf_config.inc.php');
session_start();
	$codigo='<html>
     <head> 
        
    </head>
    <style>
    @page {
        margin-top: 2em;
        margin-left: 3em;
        margin-bottom: 1em;
        margin-right: 2em;
    }
    </style> 
    <body>';    
    include '../../procesos/base.php';
    conectarse();  
    $subtotal12=0;
    $subtotal0=0;
    $subtotal=0;
    $iva12=0;
    $total=0;  
    $consulta=pg_query("select id_devolucion_venta,fecha_actual,num_serie,tarifa0,tarifa12,iva_venta,descuento_venta,total_venta,observaciones,identificacion,nombres_cli,telefono,direccion_cli from devolucion_venta,clientes where devolucion_venta.id_cliente=clientes.id_cliente and devolucion_venta.id_devolucion_venta='$_GET[id]'");
    while($row=pg_fetch_row($consulta)){
        $subtotal0=$row[3];
        $subtotal12=$row[4];
        $subtotal=$subtotal12+$subtotal0;
        $iva12=$row[5];
        $total=$row[7];
        $codigo.='<div style="height:93px;border:solid 0px;">
        </div>
        <div style="border:solid 0px;font-size:11px">
            <div style="width:40px;height:15px;border:solid 0px;display:inline-block;"></div>
            <div style="width:370px;height:15px;border:solid 0px;display:inline-block;">'.'&nbsp;&nbsp;&nbsp;'.$row[10].'</div>
            <div style="width:100px;height:15px;border:solid 0px;display:inline-block;"></div>
            <div style="width:180px;height:15px;border:solid 0px;display:inline-block;">'.$row[1].'</div>
            <div style="width:40px;height:15px;border:solid 0px;display:inline-block;"></div>
            <div style="width:180px;height:15px;border:solid 0px;display:inline-block;">&nbsp;&nbsp;&nbsp;'.$row[9].'</div>
            <div style="width:80px;height:15px;border:solid 0px;display:inline-block;"></div>
            <div style="width:100px;height:15px;border:solid 0px;display:inline-block;">'.$row[11].'</div>
            <div style="width:165px;height:15px;border:solid 0px;display:inline-block;"></div>
            <div style="width:110px;height:15px;border:solid 0px;display:inline-block;">'.$row[2].'</div>
            <div style="width:65px;height:15px;border:solid 0px;display:inline-block;"></div>
            <div style="width:340px;height:15px;border:solid 0px;display:inline-block;">&nbsp;&nbsp;&nbsp;'.$row[12].'</div>
            <div style="width:125px;height:15px;border:solid 0px;display:inline-block;"></div>
            <div style="width:155px;height:15px;border:solid 0px;display:inline-block;">'.$row[8].'</div>
        </div>';

        $codigo.='<div style="height:20px;border:solid 0px;display:inline-block;"></div>';
        $sql=pg_query("select id_detalle_deventa,id_devolucion_venta,productos.cod_productos,cantidad,precio_venta,descuento_producto,total_venta,articulo from detalle_devolucion_venta,productos where detalle_devolucion_venta.cod_productos=productos.cod_productos and id_devolucion_venta='$row[0]'");
        while($row1=pg_fetch_row($sql)){            
            $codigo.='<div style="height:240px;border:solid 0px;font-size:11px;text-align:center;">
                <div style="width:95px;height:15px;border:solid 0px;display:inline-block;">'.$row1[3].'</div>
                <div style="width:415px;height:15px;border:solid 0px;display:inline-block;">'.$row1[7].'</div>
                <div style="width:75px;height:15px;border:solid 0px;display:inline-block;">'.$row1[4].'</div>
                <div style="width:105px;height:15px;border:solid 0px;display:inline-block;">'.$row1[6].'</div>
            </div>';   
        }        
        $codigo.='<div style="border:solid 0px;">
        <div style="width:105px;height:15px;border:solid 0px;display:inline-block;"></div>
        <div style="width:370px;height:40px;border:solid 0px;display:inline-block;font-size:11px;overflow:hidden">'.$row[8].'</div>
            <div style="width:110px;height:80px;border:solid 0px;display:inline-block;">
                <div style="width:100px;height:17px;border:solid 0px;"></div>
                <div style="width:100px;height:17px;border:solid 0px;"></div>
                <div style="width:100px;height:17px;border:solid 0px;"></div>
                <div style="width:100px;height:17px;border:solid 0px;"></div>
                <div style="width:100px;height:17px;border:solid 0px;"></div>
            </div>
            <div style="width:110px;height:80px;border:solid 0px;display:inline-block;font-size:11px;text-align:center;">
                <div style="width:120px;height:17px;border:solid 0px;">'.$subtotal12.'</div>
                <div style="width:120px;height:17px;border:solid 0px;">'.$subtotal0.'</div>
                <div style="width:120px;height:17px;border:solid 0px;">'.$subtotal.'</div>
                <div style="width:120px;height:17px;border:solid 0px;">'.$iva12.'</div>
                <div style="width:120px;height:17px;border:solid 0px;">'.$total.'</div>
            </div>
        </div>';
            
    }
 
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
   ini_set("memory_limit","100M");
    $dompdf->set_paper("A5","landscape");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('notaCredito.pdf',array('Attachment'=>0));
?>