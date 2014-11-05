<?php
 $fecha=date('Y-m-d', time());   
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
                <h4 style="text-align: center;width:50%;display: inline-block;">Desde el : '.$fecha.'</h4>
                <h4 style="text-align: center;width:45%;display: inline-block;">Hasta el : '.$_GET['fin'].'</h4>
            </div>       
    </header>        
    <hr>
    <div id="linea">
        <h3>NÚMEROS DE AUTORIZACIÓN CERCANOS A CADUCAR</h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $repetido=0;   
    $contador=0; 
    $consulta=pg_query("select id_cliente,identificacion,nombres_cli,telefono,direccion_cli from clientes");
    while($row=pg_fetch_row($consulta)){
        $repetido=0;
        $total=0;
        $sql1=pg_query("select id_factura_venta,num_factura,num_autorizacion,fecha_autorizacion,fecha_caducidad FROM factura_venta where id_cliente='$row[0]' and estado='Activo' and fecha_caducidad between '$fecha' and '$_GET[fin]'");
        if(pg_num_rows($sql1)){
            if($repetido==0){
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">RUC/CI: '.$row[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[2].'</h2>';
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">TELF: '.$row[3].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DIRECCIÓN'.$row[4].'</h2>';

                $codigo.='<table>';                      
                $codigo.='<tr>                
                <td style="width:200px;text-align:center;">Nro Factura</td>    
                <td style="width:100px;text-align:center;">Tipo Documento</td>
                <td style="width:150px;text-align:center;">Nro. Autorización</td>
                <td style="width:150px;text-align:center;">Fecha Autorización</td>
                <td style="width:150px;text-align:center;">Fecha de caducidad</td>
                </tr><hr>';
                $codigo.='</table>';         
                $repetido=1;
            }
            $codigo.='<table>';
            while($row1=pg_fetch_row($sql1)){
                $codigo.='<tr>
                <td style="width:200px;text-align:center;">'.$row1[1].'</td>    
                <td style="width:100px;text-align:center;">'.'Factura'.'</td>
                <td style="width:150px;text-align:center;">'.' '.$row1[2].'</td>
                <td style="width:150px;text-align:center;">'.' '.$row1[3].'</td>
                <td style="width:150px;text-align:center;">'.' '.$row1[4].'</td>
                
                
                </tr>';
            }
            $codigo.='</table><br/>';    
           
        }
        
    }
    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporte_autorizacion_caducidad.pdf',array('Attachment'=>0));
?>