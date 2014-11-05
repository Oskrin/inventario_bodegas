<?php
require('../dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <<img src="../../images/logo_empresa.jpg" />
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
        <h3>REPORTES DE GASTOS </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $id_fac=0;
    $fecha=0;
    $contador=0; 
    $num_fac=0;
    $valor_pagado=0;
    $sql=pg_query("SELECT DISTINCT(id_factura_venta) FROM gastos where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' order by id_factura_venta asc;");
    while($row=pg_fetch_row($sql)){
        $sql1=pg_query("select id_factura_venta,num_factura,nombres_cli,total_venta,fecha_actual from factura_venta,clientes where factura_venta.id_cliente=clientes.id_cliente and id_factura_venta='$row[0]'");
        while($row1=pg_fetch_row($sql1)){
            $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">NRO. FACTURA: '.$row1[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row1[2].'</h2>';
            $id_fac=$row1[0];
            $num_fac=$row1[1];
            $total=$row1[3];
            $fecha=$row1[4];
        }
        $sql2=pg_query("SELECT * FROM gastos where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and id_factura_venta='$id_fac' order by id_factura_venta asc");
            $codigo.='<table border=0>';                      
            $codigo.='<tr>                
            <td style="width:90px;text-align:center;">Num. Factura</td>    
            <td style="width:80px;text-align:center;">Fecha Factura</td>
            <td style="width:80px;text-align:center;">Total Venta</td>    
            <td style="width:200px;text-align:center;">Descripción</td>
            <td style="width:60px;text-align:center;">Fecha Pago</td>
            <td style="width:60px;text-align:center;">Valor Pago</td>
            <td style="width:60px;text-align:center;">Saldo</td>
            <td style="width:60px;text-align:center;">Acumulado</td></tr><tr><td colspan=8><hr></td></tr>';
            $valor_pagado=0;
            while($row2=pg_fetch_row($sql2)){
                $codigo.='<tr>                
                <td style="width:90px;text-align:center;">'.substr($num_fac,8,30).'</td>    
                <td style="width:80px;text-align:center;">'.$fecha.'</td>
                <td style="width:80px;text-align:center;">'.$total.'</td>    
                <td style="width:200px;text-align:center;">'.$row2[6].'</td>
                <td style="width:60px;text-align:center;">'.$row2[4].'</td>
                <td style="width:60px;text-align:center;">'.$row2[7].'</td> 
                <td style="width:60px;text-align:center;">'.$row2[8].'</td>
                <td style="width:60px;text-align:center;">'.$row2[9].'</td></tr>';
                $valor_pagado=$valor_pagado+$row2[7];
            }   
            $codigo.='<tr><td colspan=8><hr></td></tr>
            <tr style="font-weight:bold">                
                <td style="width:150px;text-align:left;" colspan=4>Utilidad por factura:</td>    
                <td style="width:80px;text-align:right;" colspan=4>'.($total-$valor_pagado).'</td><tr>
            </table><br />';      
    }
   

    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('gastos_realizados.pdf',array('Attachment'=>0));
?>