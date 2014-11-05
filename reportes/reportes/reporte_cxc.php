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
        <h3>RECIBO DE COBRO </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $desc=0;
    $ivaT=0;
    $repetido=0;    
    if ($_GET['tipo_pago'] == "EXTERNA") {        
        $sql=pg_query("select * from c_cobrarexternas,clientes,empresa where c_cobrarexternas.id_cliente=clientes.id_cliente and c_cobrarexternas.id_empresa=empresa.id_empresa and c_cobrarexternas.num_factura='$_GET[id]'");        
        while($row=pg_fetch_row($sql)){
            if($repetido==0){
                $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">RUC/CI: '.$row[14].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[15].'</h2>
                <h2 style="color:#1B8D72;font-size:14px;font-weight: bold;">Sección: '.$row[27].'</h2> ';
                $codigo.='<table>';                      
                $codigo.='<tr>                
                <td style="width:100px;text-align:center;">Comprobante</td>    
                <td style="width:100px;text-align:center;">Tipo Documento</td>
                <td style="width:150px;text-align:center;">Nro Factura</td>    
                <td style="width:100px;text-align:center;">Total</td>
                <td style="width:100px;text-align:center;">Valor Pago</td>
                <td style="width:100px;text-align:center;">Saldo</td>
                <td style="width:100px;text-align:center;">Fecha Pago</td></tr><hr>';
                $repetido=1;   
                $codigo.='</table>';         
            }
            $codigo.='<table>';                                                           
            $sql1=pg_query("select * from pagos_cobrar where num_factura='$_GET[id]' and id_cuentas_cobrar='$_GET[comprobante]'");
            while($row1=pg_fetch_row($sql1)){
                $codigo.='<tr>                
                <td style="width:100px;text-align:center;">'.$row1[0].'</td>
                <td style="width:100px;text-align:center;">'.$row[8].'</td>
                <td style="width:150px;text-align:center;">'.$row[7].'</td>';

                $codigo.=' <td style="width:100px;text-align:center;">'.($row1[12]+$row1[13]).'</td>
                <td style="width:100px;text-align:center;">'.$row1[12].'</td>
                <td style="width:100px;text-align:center;">'.$row1[13].'</td>
                <td style="width:100px;text-align:center;">'.$row1[4].'</td>';     
            }
           
            $codigo.='</tr></table>'; 

            $codigo.='<hr>';
            $codigo.='<br/>';
            $codigo.='<table>';                                                
            $codigo.='<tr>
            <td style="width:500px;text-align:left;font-weight:bold">'."Total Saldo".'</td>
            <td style="width:200px;text-align:right;font-weight:bold">'.(number_format($row[10],2,',','.')).'</td>';
            $codigo.='</tr>';                           
            $codigo.='</table>'; 
        }
    }
    else{
        $saldo_t=0;
        $id_f=0;
        $sql=pg_query("select * from factura_venta,clientes,empresa where factura_venta.id_cliente=clientes.id_cliente and factura_venta.id_empresa=empresa.id_empresa and num_factura='$_GET[id]';");        
        while($row=pg_fetch_row($sql)){
            $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">RUC/CI: '.$row[19].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[20].'</h2>
            <h2 style="color:#1B8D72;font-size:14px;font-weight: bold;">Sección: '.$row[33].'</h2> ';
            $codigo.='<table border=0>';                      
            $codigo.='<tr>                
            <td style="width:70px;text-align:center;">Comprobante</td>    
            <td style="width:90px;text-align:center;">Tipo Documento</td>
            <td style="width:120px;text-align:center;">Nro Factura</td>    
            <td style="width:70px;text-align:center;">Nro Meses</td>    
            <td style="width:70px;text-align:center;">Total</td>
            <td style="width:70px;text-align:center;">Adelanto</td>
            <td style="width:70px;text-align:center;">Valor Pago</td>
            <td style="width:70px;text-align:center;">Saldo</td>
            <td style="width:70px;text-align:center;">Fecha Pago</td></tr><hr>';
            $codigo.='</table>';    
            $id_f=$row[0];       
        }
        //////////////////////
        $fec="";
        $sql=pg_query("select fecha_actual from pagos_cobrar where comprobante='$_GET[comprobante]'");
        while($row=pg_fetch_row($sql)){
            $fec=$row[0];
        }
        /////////////////////
        $sql=pg_query("select * from pagos_venta where id_factura_venta='$id_f'");
        $meses=0;
        $id_pv=0;
        while($row=pg_fetch_row($sql)){
            $meses=$row[6];
            $id_pv=$row[0];
            $codigo.='<table border=0><tr>
            <td style="width:70px;text-align:center;">'.$row[2].'</td>
            <td style="width:90px;text-align:center;">'.$row[7].'</td>
            <td style="width:120px;text-align:center;">'.substr($_GET['id'],8,30).'</td>
            <td style="width:70px;text-align:center;">'.$row[6].'</td>
            <td style="width:70px;text-align:center;">'.$row[8].'</td>
            <td style="width:70px;text-align:center;">'.$row[5].'</td>
            <td style="width:70px;text-align:center;">'.($_GET['temp2']).'</td>
            <td style="width:70px;text-align:center;">'.($_GET['temp3']).'</td>
            <td style="width:70px;text-align:center;">'.$fec.'</td>';
            $codigo.='</table></tr>';            
        }

        $sql=pg_query("select * from detalles_pagos_internos where id_cuentas_cobrar='$_GET[comprobante]' order by id_detalles_pagos_interna asc;");
        $valor_mes=0;
        while($row=pg_fetch_row($sql)){
            $sql1=pg_query("select * from detalle_pagos_venta where id_pagos_venta='$id_pv' and fecha_pago='$row[2]';");
            while($row1=pg_fetch_row($sql1)){                
                $codigo.='<table border=0><tr>
                    <td style="width:70px;text-align:center;">'.' '.'</td>
                    <td style="width:90px;text-align:center;">'.' '.'</td>
                    <td style="width:120px;text-align:center;">'.' '.'</td>
                    <td style="width:70px;text-align:center;">'.$row1[2].'</td>
                    <td style="width:70px;text-align:center;">'.($row[3]+$row[4]).'</td>
                    <td style="width:70px;text-align:center;">'.' '.'</td>
                    <td style="width:70px;text-align:center;">'.($row[3]).'</td>
                    <td style="width:70px;text-align:center;">'.($row[4]).'</td>
                    <td style="width:70px;text-align:center;">'.' '.'</td>';
                    $codigo.='</table></tr>';
            }
        }
        $codigo.='<hr>';
        $codigo.='<br/>';
        $codigo.='<table>';                                                
        $codigo.='<tr>
        <td style="width:500px;text-align:left;font-weight:bold">'."Total Saldo".'</td>
        <td style="width:200px;text-align:right;font-weight:bold">'.(number_format($_GET['temp3'],2,',','.')).'</td>';
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
    $dompdf->stream('reporte_cxc.pdf',array('Attachment'=>0));
?>