<?php
require('../dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../../images/icono.jpg" />
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
        <h3>FACTURAS CANCELADAS POR CLIENTE </h3>
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
        $sql1=pg_query("select * from factura_venta where estado='Activo' and id_cliente='$row[0]' and id_usuario='$_SESSION[id]' order by forma_pago asc;");
        if(pg_num_rows($sql1)){
            while($row1=pg_fetch_row($sql1)){
                if($row1[10]=='Contado'){
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
                        <td style="width:100px;text-align:center;">'.$row1[0].'</td>    
                        <td style="width:100px;text-align:center;">'.'Factura'.'</td>
                        <td style="width:150px;text-align:center;">'.substr($row1[5],8,30).'</td>    
                        <td style="width:100px;text-align:center;">'.$row1[15].'</td>
                        <td style="width:100px;text-align:center;">'.$row1[15].'</td>
                        <td style="width:100px;text-align:center;">'.'0.00'.'</td>
                        <td style="width:100px;text-align:center;">'.$row1[6].'</td></tr>';
                        $repetido=1;   
                        $sub=$sub+$row1[15];
                        $codigo.='</table>'; 
                    
                } 
                else{    
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
                    $sql2=pg_query("select * from factura_venta,pagos_venta where factura_venta.id_factura_venta= pagos_venta.id_factura_venta and pagos_venta.estado='Cancelado' and pagos_venta.id_cliente='$row[0]' and factura_venta.id_factura_venta='$row1[0]' and factura_venta.id_usuario='$_SESSION[id]'");
                    while($row2=pg_fetch_row($sql2)){
                        $codigo.='<table>'; 
                        $codigo.='<tr>                
                        <td style="width:100px;text-align:center;">'.$row2[0].'</td>    
                        <td style="width:100px;text-align:center;">'.$row2[25].'</td>
                        <td style="width:150px;text-align:center;">'.substr($row2[5],8,30).'</td>    
                        <td style="width:100px;text-align:center;">'.$row2[15].'</td>
                        <td style="width:100px;text-align:center;">'.$row2[15].'</td>
                        <td style="width:100px;text-align:center;">'.'0.00'.'</td>
                        <td style="width:100px;text-align:center;">'.$row2[22].'</td></tr>';
                        $sub=$sub+$row2[15];
                        $codigo.='</table>'; 
                    }
                   
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
        

    }
               
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('facturas_canceladas.pdf',array('Attachment'=>0));
?>