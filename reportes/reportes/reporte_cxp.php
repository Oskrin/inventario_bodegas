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
        <h3>RECIBO DE PAGO </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $saldo=0;
    $repetido=0;    
    if ($_GET['tipo_pago'] == "EXTERNA") {        
        $sql=pg_query("select * from c_pagarexternas,proveedores,usuario,empresa where c_pagarexternas.id_proveedor=proveedores.id_proveedor and c_pagarexternas.id_usuario=usuario.id_usuario and empresa.id_empresa=c_pagarexternas.id_empresa and num_factura='$_GET[id]'");        
        while($row=pg_fetch_row($sql)){
            if($repetido==0){
                $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">RUC/CI: '.$row[14].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[15].'</h2>
                <h2 style="color:#1B8D72;font-size:14px;font-weight: bold;">Sección: '.$row[41].'</h2> ';
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
            $sql1=pg_query("select * from pagos_pagar where num_factura='$_GET[id]' and id_cuentas_pagar='$_GET[comprobante]'");
            while($row1=pg_fetch_row($sql1)){
                $codigo.='<tr>                
                <td style="width:100px;text-align:center;">'.$row1[0].'</td>
                <td style="width:100px;text-align:center;">'.$row[9].'</td>
                <td style="width:150px;text-align:center;">'.$row[8].'</td>';

                $codigo.=' <td style="width:100px;text-align:center;">'.($row1[12]+$row1[13]).'</td>
                <td style="width:100px;text-align:center;">'.$row1[12].'</td>
                <td style="width:100px;text-align:center;">'.$row1[13].'</td>
                <td style="width:100px;text-align:center;">'.$row1[4].'</td>';     
                $saldo=$row1[13];
            }
           
            $codigo.='</tr></table>'; 

            $codigo.='<hr>';
            $codigo.='<br/>';
            $codigo.='<table>';                                                
            $codigo.='<tr>
            <td style="width:500px;text-align:left;font-weight:bold">'."Total Saldo".'</td>
            <td style="width:200px;text-align:right;font-weight:bold">'.(number_format($saldo,2,',','.')).'</td>';
            $codigo.='</tr>';                           
            $codigo.='</table>'; 
        }
    }
    else{        
        $sql=pg_query("select * from factura_compra,proveedores,usuario,empresa where factura_compra.id_proveedor=proveedores.id_proveedor and factura_compra.id_usuario=usuario.id_usuario and factura_compra.id_empresa=empresa.id_empresa and num_serie='$_GET[id]' and proveedores.id_proveedor='$_GET[proveedor]'");        
        while($row=pg_fetch_row($sql)){
            $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">RUC/CI: '.$row[23].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[24].'</h2>
            <h2 style="color:#1B8D72;font-size:14px;font-weight: bold;">Sección: '.$row[50].'</h2> ';
            $codigo.='<table border=0>';                      
            $codigo.='<tr>                
            <td style="width:100px;text-align:center;">Comprobante</td>    
            <td style="width:100px;text-align:center;">Tipo Documento</td>
            <td style="width:150px;text-align:center;">Nro Factura</td>                
            <td style="width:100px;text-align:center;">Total</td>            
            <td style="width:100px;text-align:center;">Valor Pago</td>
            <td style="width:100px;text-align:center;">Saldo</td>
            <td style="width:10px;text-align:center;">Fecha Pago</td></tr><hr>';
            $codigo.='</table>';                         
        }        
        $sql=pg_query("select * from pagos_pagar where num_factura='$_GET[id]' and comprobante='$_GET[comprobante]'");
        $meses=0;
        $id_pv=0;
        while($row=pg_fetch_row($sql)){                        
            $codigo.='<table border=0><tr>
            <td style="width:100px;text-align:center;">'.$row[3].'</td>
            <td style="width:100px;text-align:center;">'.$row[9].'</td>
            <td style="width:150px;text-align:center;">'.$_GET['id'].'</td>
            <td style="width:100px;text-align:center;">'.($row[12]+$row[13]).'</td>
            <td style="width:100px;text-align:center;">'.$row[12].'</td>
            <td style="width:100px;text-align:center;">'.$row[13].'</td>            
            <td style="width:100px;text-align:center;">'.$row[4].'</td>';
            $saldo=$row[13];
            $codigo.='</table></tr>';            
        }
       
        $codigo.='<hr>';
        $codigo.='<br/>';
        $codigo.='<table>';                                                
        $codigo.='<tr>
        <td style="width:500px;text-align:left;font-weight:bold">'."Total Saldo".'</td>
        <td style="width:200px;text-align:right;font-weight:bold">'.(number_format($saldo,2,',','.')).'</td>';
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
    $dompdf->stream('reporte_cxp.pdf',array('Attachment'=>0));
?>