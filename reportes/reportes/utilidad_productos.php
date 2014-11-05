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
        <h3>UTILIDAD POR PRODUCTO </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $repetido=0;   
    $contador=0; 
    $consulta=pg_query("select id_cliente,identificacion,nombres_cli from clientes");
    while($row=pg_fetch_row($consulta)){
        $repetido=0;   
        $contador=0; 
        $total=0;
        $sql1=pg_query("select * from factura_venta where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and id_cliente='$row[0]' and estado='Activo'");
        if(pg_num_rows($sql1)){
            if($repetido==0){
                $total=0;
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">RUC/CI: '.$row[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[2].'</h2>';
                $repetido=1;
            }
            while($row1=pg_fetch_row($sql1)){
                $contador=0;
                $sub=0;
                $codigo.='<br/><table style="border:solid 1px;font-weight:bold;"><tr>                
                <td style="width:100px;text-align:center;">Nro. Factura:</td>    
                <td style="width:330px;text-align:center;">'.$row1[5].'</td>    
                <td style="width:100px;text-align:center;">Total Factura:</td>    
                <td style="width:200px;text-align:center;">'.$row1[15].'</td>    
                </table><br/>';
                $codigo.='<table><tr>                
                <td style="width:100px;text-align:left;">Cod. Prodcuto</td>    
                <td style="width:150px;text-align:left;">Descripción</td>
                <td style="width:50px;text-align:left;">Cantidad</td>    
                <td style="width:70px;text-align:left;">P. Venta</td>
                <td style="width:80px;text-align:left;">T. P. Venta</td>
                <td style="width:100px;text-align:left;">P. Compra</td>
                <td style="width:80px;text-align:left;">T. P. Compra</td>
                <td style="width:70px;text-align:left;">Utilidad</td></tr>
                <tr><td colspan=8><hr></td></tr>';
                      
                $sql2=pg_query("select * from detalle_factura_venta,productos where detalle_factura_venta.cod_productos=productos.cod_productos and id_factura_venta='$row1[0]'");
                   
                while($row2=pg_fetch_row($sql2)){
                    $codigo.='<tr>
                    <td style="width:100px;text-align:left;">'.$row2[9].'</td>    
                    <td style="width:150px;text-align:left;">'.$row2[11].'</td>
                    <td style="width:50px;text-align:left;">'.$row2[3].'</td>    
                    <td style="width:70px;text-align:left;">'.$row2[4].'</td>
                    <td style="width:80px;text-align:left;">'.($row2[3]*$row2[4]).'</td>
                    <td style="width:100px;text-align:left;">'.$row2[14].'</td>
                    <td style="width:80px;text-align:left;">'.($row2[3]*$row2[14]).'</td>
                    <td style="width:70px;text-align:left;">'.(($row2[3]*$row2[4])-($row2[3]*$row2[14])).'</td></tr>';
                    $sub=($sub+(($row2[3]*$row2[4])-($row2[3]*$row2[14])));
                }                
                $codigo.='</table>'; 
                $contador=1;
                if($contador>0){
                    $codigo.='<hr>';
                    $codigo.='<table>';                                                
                    $codigo.='<tr>
                    <td style="width:600px;text-align:left;font-weight:bold">'."Total de Utilidad por factura".'</td>
                    <td style="width:150px;text-align:center;font-weight:bold">'.(number_format($sub,2,',','.')).'</td>';
                    $codigo.='</tr>';                           
                    $codigo.='</table>'; 
                    $total=$total+$sub;
                    $sub=0;
                    
                }   
            } 
            $codigo.='<table>';                                                
            $codigo.='<tr>
            <td style="width:600px;text-align:left;font-weight:bold">'."Total de Utilidad por cliente".'</td>
            <td style="width:150px;text-align:center;font-weight:bold">'.(number_format($total,2,',','.')).'</td>';
            $codigo.='</tr>';                           
            $codigo.='</table><hr>'; 
            $codigo.='<br/>';    
            $total=0;    
        }
    }
   

    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('utilidad_productos.pdf',array('Attachment'=>0));
?>