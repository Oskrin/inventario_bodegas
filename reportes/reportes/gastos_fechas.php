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
                <h4 style="text-align: center;width:50%;display: inline-block;">Desde el : '.$_GET['inicio'].'</h4>
                <h4 style="text-align: center;width:45%;display: inline-block;">Hasta el : '.$_GET['fin'].'</h4>
            </div>    
    </header>        
    <hr>
    <div id="linea">
        <h3>GASTO INTERNO </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sql=pg_query("select * from gastos_internos,usuario,proveedores where gastos_internos.id_usuario=usuario.id_usuario and gastos_internos.id_proveedor=proveedores.id_proveedor and fecha_actual between '$_GET[inicio]' and '$_GET[fin]'");
    $codigo.='<table border=0 style="font-size:11px;">'; 
    if(pg_num_rows($sql)){
        $codigo.='<tr style="font-weight:bold">                
        <td style="width:50px;text-align:center;">Comprobante</td>    
        <td style="width:100px;text-align:center;"># Factura</td>
        <td style="width:90px;text-align:center;">Documento</td>
        <td style="width:150px;text-align:center;">Proveedor</td>
        <td style="width:70px;text-align:center;">Fecha</td>
        <td style="width:190px;text-align:center;">Descripción</td>   
        <td style="width:40px;text-align:center;">Total</td></tr><tr><td colspan=7><hr></td></tr>';  
    }
    while($row=pg_fetch_row($sql)){              
        $codigo.='<tr>                
        <td style="width:50px;text-align:center;">'.$row[3].'</td>    
        <td style="width:100px;text-align:center;">'.$row[6].'</td>
        <td style="width:90px;text-align:center;">'.$row[23].'</td>
        <td style="width:150px;text-align:center;">'.$row[24].'</td>
        <td style="width:70px;text-align:center;">'.$row[4].'</td>   
        <td style="width:190px;text-align:center;">'.$row[7].'</td>   
        <td style="width:40px;text-align:center;">'.$row[8].'</td></tr>';                
        $total=$total+$row[8];
    }
    $codigo.='<tr><td colspan=7><hr></td></tr>';
    $codigo.='<tr>
    <td colspan=4 style="text-align:left;font-weight:bold">'."Total".'</td>
    <td colspan=3 style="text-align:right;font-weight:bold">'.(number_format($total,2,',','.')).'</td>';
    $codigo.='</tr>';              
    $codigo.='</table>';
    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('gasto_fechas.pdf',array('Attachment'=>0));
?>