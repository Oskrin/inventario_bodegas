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
            <h3>KARDEX DE CLIENTES</h3>
        </div>';
		include '../../procesos/base.php';
		conectarse();    
        $total=0;
        $saldo=0;
        $repetido=0;
        $consulta=pg_query("select * from clientes where id_cliente='$_GET[id]' order by id_cliente asc");
        while($row=pg_fetch_row($consulta)){
            $consulta1=pg_query("select * from c_cobrarexternas where id_cliente='$_GET[id]' and fecha_actual between '$_GET[inicio]' and '$_GET[fin]' order by id_c_cobrarexternas asc");
            $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">RUC/CI: '.$row[2].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[3].'</h2>';
            while($row1=pg_fetch_row($consulta1)){
                if($row1[10]>0){
                    $total=0;
                    $codigo.='<div id="cuerpo">';                    
                        $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:10px;color:red;background:#fff">Factura #: '.substr($row1[7],8,15).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Serie: '.substr($row1[7],0,7).'</h2>';
                        $codigo.='<table style="color:blue;font-weight:bold;text-decoration:underline;" border=0>';                     
                            $codigo.='<tr>                
                            <td style="width:70px">Comprobante</td>
                            <td style="width:70px">Tipo Doc</td>
                            <td style="width:70px">Fecha Mov</td>
                            <td style="width:70px">Valor</td>
                            <td style="width:70px">Saldo</td></tr>';
                            $repetido=1;   
                        $codigo.='</table>';                    
                    
                        $codigo.='<table border=0>';                                                
                            $codigo.='<tr>                
                            <td style="width:70px">1'.$row1[4].'</td>
                            <td style="width:70px">'.'CxC'.'</td>                    
                            <td style="width:70px">'.$row1[5].'</td>
                            <td style="width:70px">'.$row1[9].'</td>';
                            $total=$total+$row1[10];  
                            $saldo=$saldo+$row1[10];              
                            $codigo.='<td style="width:70px">'.$row1[10].'</td></tr>';          
                        $codigo.='</table>'; 
                        $codigo.='<table style="color:blue;font-weight:bold;font-size:14px;margin-top:20px;">';        
                    $codigo.='<tr>                
                        <td style="width:70px">Saldo Pendiente</td>
                        <td style="width:70px">'.'&nbsp;'.'</td>                   
                        <td style="width:70px">'.'&nbsp;'.'</td>
                        <td style="width:70px">'.'&nbsp;'.'</td>
                        <td style="width:70px">'.$total.'</td></tr>';
                    $codigo.='</table><hr>';   
                }      
            }
            $consulta2=pg_query("select * from factura_venta where id_cliente='$_GET[id]' and forma_pago='Credito'");
            while($row2=pg_fetch_row($consulta2)){
                $total=0;
                $codigo.='<div id="cuerpo">';                    
                $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:10px;color:red;background:#fff">Factura #: '.substr($row2[5],8,15).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Serie: '.substr($row2[5],0,7).'</h2>';
                $codigo.='<table style="color:blue;font-weight:bold;text-decoration:underline;" border=0>';                     
                $codigo.='<tr>                
                    <td style="width:70px">Comprobante</td>
                    <td style="width:70px">Tipo Doc</td>
                    <td style="width:70px">Fecha Mov</td>
                    <td style="width:70px">Valor</td>
                    <td style="width:70px">Saldo</td></tr>';
                    $repetido=1;   
                $codigo.='</table>';
                $consulta3=pg_query("select * from pagos_venta where id_factura_venta='$row2[0]'");                       
                while($row3=pg_fetch_row($consulta3)){
                    $codigo.='<table border=0>';                                                
                    $codigo.='<tr>                
                    <td style="width:70px">'.'&nbsp;'.$row3[2].'</td>
                    <td style="width:70px">'.'&nbsp;FV'.'</td>                    
                    <td style="width:70px">'.'&nbsp;'.$row3[4].'</td>
                    <td style="width:70px">'.'&nbsp;'.($row3[8]-$row3[9]).'</td>';                                   
                    $codigo.='<td style="width:70px">'.($row3[8]-(($row3[8]-$row3[9]))).'</td></tr>'; 
                    $total=($row3[8]-($row3[8]-$row3[9]));         
                    $codigo.='</table>'; 
                    if($row3[5]!=""){
                        $codigo.='<table border=0>';                                                
                        $codigo.='<tr>                
                        <td style="width:70px">'.'&nbsp;'.$row3[2].'</td>
                        <td style="width:70px">'.'&nbsp;Abono'.'</td>                    
                        <td style="width:70px">'.'&nbsp;'.$row3[4].'</td>
                        <td style="width:70px">'.'&nbsp;'.'-'.($row3[5]).'</td>';                                   
                        $total=$total-$row3[5];
                        $codigo.='<td style="width:70px">'.($total).'</td></tr>';          
                        $codigo.='</table>'; 
                    }
                    $saldo=$saldo+$total;
                    $consulta4=pg_query("select * from detalle_pagos_venta where id_pagos_venta='$row3[0]'");
                    while($row4=pg_fetch_row($consulta4)){
                        
                    }
                    
                }
                $codigo.='<table style="color:blue;font-weight:bold;font-size:14px;margin-top:20px;">';        
                $codigo.='<tr>                
                <td style="width:70px">Saldo Pendiente</td>
                <td style="width:70px">'.'&nbsp;'.'</td>                   
                <td style="width:70px">'.'&nbsp;'.'</td>
                <td style="width:70px">'.'&nbsp;'.'</td>
                <td style="width:70px">'.$total.'</td></tr>';
                $codigo.='</table><hr>';       
            }
            ////total final///   
            $codigo.='<table style="color:blue;font-weight:bold;font-size:14px;margin-top:20px;"><tr>                
                <td style="width:70px">Gran Total</td>
                <td style="width:70px">'.'&nbsp;'.'</td>                   
                <td style="width:70px">'.'&nbsp;'.'</td>
                <td style="width:70px">'.'&nbsp;'.'</td>
                <td style="width:70px">'.$saldo.'</td></tr>';
            $codigo.='</table>';
        }
        ///cxc externas
        ///////////////
       
             
	$codigo.='</body></html>';           				 
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('estadoCuentaClientes.pdf',array('Attachment'=>0));
?>