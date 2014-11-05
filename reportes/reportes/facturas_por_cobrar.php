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
        <h3>FACTURAS POR PAGAR POR CLIENTE </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $desc=0;
    $ivaT=0;
    $repetido=0;    
    
    $consulta=pg_query('select * from clientes order by id_cliente asc');
    while($row=pg_fetch_row($consulta)){
        $repetido=0;
        $sub=0;
        $contador=0;
        $sql1=pg_query("select * from factura_venta where estado='Activo' and id_cliente='$row[0]' and forma_pago='Credito' order by forma_pago asc;");
        if(pg_num_rows($sql1)){
            while($row1=pg_fetch_row($sql1)){                   
                if($repetido==0){                        
                    $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">RUC/CI: '.$row[2].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[3].'</h2>';
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
                    $repetido=1;
                    $contador=1;
                    $codigo.='</table>'; 
                }               

                $sql2=pg_query("select * from factura_venta,pagos_venta where factura_venta.id_factura_venta= pagos_venta.id_factura_venta and pagos_venta.estado='Activo' and pagos_venta.id_cliente='$row[0]' and factura_venta.id_factura_venta='$row1[0]'");
                while($row2=pg_fetch_row($sql2)){
                    $codigo.='<table>'; 
                    $codigo.='<tr>                
                    <td style="width:100px;text-align:center;">'.$row2[0].'</td>    
                    <td style="width:100px;text-align:center;">'.$row2[25].'</td>
                    <td style="width:150px;text-align:center;">'.substr($row2[5],8,30).'</td>    
                    <td style="width:100px;text-align:center;">'.$row2[26].'</td>
                    <td style="width:100px;text-align:center;">'.($row2[26]-$row2[27]).'</td>
                    <td style="width:100px;text-align:center;">'.$row2[27].'</td>
                    <td style="width:100px;text-align:center;">'.$row2[22].'</td></tr>';
                    $sub=$sub+($row2[26]-$row2[27]);
                    $codigo.='</table>'; 
                }        
            } 
        }        

        $sql3=pg_query("select * from c_cobrarexternas where id_cliente='$row[0]' and estado='Activo'");
        if(pg_num_rows($sql3)){
            while($row3=pg_fetch_row($sql3)){
                if($repetido==0){                        
                    $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">RUC/CI: '.$row[2].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[3].'</h2>';
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
                    $repetido=1;
                    $contador=1;
                    $codigo.='</table>'; 
                }
                $codigo.='<table>'; 
                $codigo.='<tr>                
                <td style="width:100px;text-align:center;">'.$row3[4].'</td>    
                <td style="width:100px;text-align:center;">'.$row3[8].'</td>
                <td style="width:150px;text-align:center;">'.substr($row3[7],8,30).'</td>    
                <td style="width:100px;text-align:center;">'.$row3[9].'</td>
                <td style="width:100px;text-align:center;">'.($row3[9]-$row3[10]).'</td>
                <td style="width:100px;text-align:center;">'.$row3[10].'</td>
                <td style="width:100px;text-align:center;">'.$row3[5].'</td></tr>';
                $sub=$sub+($row3[9]-$row3[10]);
                $codigo.='</table>'; 

            }
        }
        if($contador>0){
                $codigo.='<hr>';
                $codigo.='<table>';                                                
                $codigo.='<tr>
                <td style="width:200px;text-align:center;font-weight:bold">'."Totales".'</td>
                <td style="width:800px;text-align:center;font-weight:bold">'.(number_format($sub,2,',','.')).'</td>';
                $codigo.='</tr>';                           
                $codigo.='</table>'; 
                $codigo.='<br/>';
            }
        

    }
               
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('facturas_por_cobrar.pdf',array('Attachment'=>0));
?>