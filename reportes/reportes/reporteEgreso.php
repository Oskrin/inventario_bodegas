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
        <h3>EGRESOS </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $sql=pg_query("select * from egresos,usuario,empresa where egresos.id_usuario=usuario.id_usuario and egresos.id_empresa=empresa.id_empresa and comprobante='$_GET[comprobante]';");        
    while($row=pg_fetch_row($sql)){        
        $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">RUC/CI: '.$row[18].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[17].' '.$row[16].'</h2>
        <h2 style="color:#1B8D72;font-size:14px;font-weight: bold;">Origen: '.$row[6].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destino: '.$row[7].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Ingreso: '.$row[4].'</h2>';
        $codigo.='<table>';                      
        $codigo.='<tr>                
        <td style="width:100px;text-align:center;">Comprobante</td>    
        <td style="width:100px;text-align:center;">Código</td>
        <td style="width:150px;text-align:center;">Producto</td>    
        <td style="width:100px;text-align:center;">Cantidad</td>
        <td style="width:100px;text-align:center;">Precio Costo</td>
        <td style="width:100px;text-align:center;">Precio Venta</td>
        <td style="width:100px;text-align:center;">Total</td></tr><hr>';
        $codigo.='</table>';   
        $temp1=$row[8];
        $temp2=$row[9];
        $temp3=$row[10];
        $temp4=$row[11];
        $temp5=$row[12];                          
    }
    $sql=pg_query("select *from detalle_egreso,productos where detalle_egreso.cod_productos=productos.cod_productos and id_egresos='$_GET[comprobante]'");
    $codigo.='<table>';            
    while($row=pg_fetch_row($sql)){              
            $codigo.='<tr>                
            <td style="width:100px;text-align:center;">'.$row[1].'</td>    
            <td style="width:100px;text-align:center;">'.$row[9].'</td>
            <td style="width:150px;text-align:center;">'.$row[11].'</td>    
            <td style="width:100px;text-align:center;">'.$row[3].'</td>
            <td style="width:100px;text-align:center;">'.$row[4].'</td>
            <td style="width:100px;text-align:center;">'.$row[17].'</td>
            <td style="width:100px;text-align:center;">'.$row[6].'</td></tr>';                
    }
    $codigo.='</table><hr>';    
    $codigo.='</table>';
    $codigo.='<table border=0 style="margin-left:440px;"><tr>
    <td style="width:80px;text-align:left;border:solid 1px;height:20px">Tarifa 0:</td>    
    <td style="width:80px;text-align:center;border:solid 1px;height:20px">'.$temp1.'</td>    
    </tr><tr>
    <td style="width:80px;text-align:left;border:solid 1px;height:20px">Tarifa 12:</td>    
    <td style="width:80px;text-align:center;border:solid 1px;height:20px">'.$temp2.'</td>    
    </tr><tr>
    <td style="width:80px;text-align:left;border:solid 1px;height:20px">12% Iva:</td>    
    <td style="width:80px;text-align:center;border:solid 1px;height:20px">'.$temp3.'</td>    
    </tr><tr>
    <td style="width:80px;text-align:left;border:solid 1px;height:20px">Descuento:</td>    
    <td style="width:80px;text-align:center;border:solid 1px;height:20px">'.$temp4.'</td>    
    </tr><tr>
    <td style="width:80px;text-align:left;border:solid 1px;height:20px">Total:</td>    
    <td style="width:80px;text-align:center;border:solid 1px;height:20px">'.$temp5.'</td>    
    </tr>
    </table>';                        

    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporteEgreso.pdf',array('Attachment'=>0));
    
?>