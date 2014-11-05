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
        <h3>DEVOLUCIÓN COMPRA </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $sql=pg_query("select * from devolucion_compra,proveedores,usuario,empresa where devolucion_compra.id_proveedor=proveedores.id_proveedor and devolucion_compra.id_usuario=usuario.id_usuario and devolucion_compra.id_empresa=empresa.id_empresa and id_devolucion_compra='$_GET[id]'");
    while($row=pg_fetch_row($sql)){
        $temp1=$row[10];
        $temp2=$row[11];
        $temp3=$row[12];
        $temp4=$row[13];
        $temp5=$row[14];
        $codigo.='<table border=0><tr>
        <td style="width:80px;text-align:left;">Proveedor:</td>
        <td style="width:470px;text-align:left;">'.$row[20].'</td>
        <td style="width:80px;text-align:left;">C.I.:</td>
        <td style="width:100px;text-align:left;">'.$row[19].'</td>';
        $codigo.='</tr></table>';
        $codigo.='<table border=0><tr>
        <td style="width:80px;text-align:left;">Representante:</td>
        <td style="width:200px;text-align:left;">'.$row[21].'</td>
        <td style="width:80px;text-align:left;">Dirección:</td>
        <td style="width:175px;text-align:left;">'.' '.$row[23].'</td>
        <td style="width:80px;text-align:left;">Celular:</td>
        <td style="width:102px;text-align:left;">'.' '.$row[25].'</td>
        </tr></table>';           

        $codigo.='<br><table border=0><tr>
        <td style="width:80px;text-align:left;">Responsable:</td>
        <td style="width:460px;text-align:left;">'.$row[35].' '.$row[36].'</td>
        <td style="width:80px;text-align:left;">Celular:</td>
        <td style="width:100px;text-align:left;">'.$row[39].'</td>
       </tr></table>';          
    }   
    $sql=pg_query("select * from detalle_devolucion_compra,productos where detalle_devolucion_compra.cod_productos=productos.cod_productos and id_devolucion_compra='$_GET[id]' order by id_devolucion_compra asc;");
    $codigo.='<br/><table border=0><tr>
    <td style="width:130px;text-align:center;border:solid 1px;">Código</td>
    <td style="width:260px;text-align:center;border:solid 1px;">Producto</td>
    <td style="width:80px;text-align:center;border:solid 1px;">Cantidad</td>
    <td style="width:80px;text-align:center;border:solid 1px;">PVP</td>
    <td style="width:80px;text-align:center;border:solid 1px;">Descuento</td>
    <td style="width:80px;text-align:center;border:solid 1px;">Total</td></tr>';
      
    while($row=pg_fetch_row($sql)){
        
        $codigo.='<tr><td style="width:130px;text-align:center;border:solid 1px;">'.$row[9].'</td>
        <td style="width:260px;text-align:center;border:solid 1px;">'.$row[11].'</td>
        <td style="width:80px;text-align:center;border:solid 1px;">'.$row[3].'</td>
        <td style="width:80px;text-align:center;border:solid 1px;">'.$row[4].'</td>
        <td style="width:80px;text-align:center;border:solid 1px;">'.$row[5].'</td>
        <td style="width:80px;text-align:center;border:solid 1px;">'.$row[6].'</td>
        </tr>';    
    }
    
    $codigo.='</table>';
    $codigo.='<table border=0 style="margin-left:430px;"><tr>
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
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('devolucion_compra.pdf',array('Attachment'=>0));
?>