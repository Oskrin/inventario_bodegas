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
        <h3>UTILIDAD POR FACTURA </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $repetido=0;   
    $contador=0; 
    $pv=0;
    $pc=0;
    $util=0;
    $consulta=pg_query("select id_cliente,identificacion,nombres_cli from clientes");
    while($row=pg_fetch_row($consulta)){
        $repetido=0;
        $sql1=pg_query("select * from factura_venta where fecha_actual between '$_GET[inicio]' and '$_GET[fin]' and id_cliente='$row[0]' and estado='Activo'");
        if(pg_num_rows($sql1)){
            if($repetido==0){
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">RUC/CI: '.$row[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[2].'</h2>';
                $codigo.='<table>';                      
                $codigo.='<tr>                
                <td style="width:150px;text-align:center;">Nro Factura</td>    
                <td style="width:100px;text-align:center;">Tipo Documento</td>
                <td style="width:100px;text-align:center;">Total P. Venta</td>
                <td style="width:100px;text-align:center;">Total P. Compra</td>
                <td style="width:100px;text-align:center;">Utilidad</td>
                <td style="width:100px;text-align:center;">Fecha Pago</td>
                <td style="width:100px;text-align:center;">Tipo Pago</td></tr><hr>';
                $codigo.='</table>';         
                $repetido=1;
            }
            $codigo.='<table>';
            while($row1=pg_fetch_row($sql1)){
                $pv=0;
                $pc=0;
                $util=0;
                $sql2=pg_query("select * from detalle_factura_venta,productos where detalle_factura_venta.cod_productos=productos.cod_productos and id_factura_venta='$row1[0]'");
                while($row2=pg_fetch_row($sql2)){
                    $pv=$pv+($row2[3]*$row2[4]);
                    $pc=$pc+($row2[3]*$row2[14]);
                    $util=$util+(($row2[3]*$row2[4])-($row2[3]*$row2[14]));
                }
                $codigo.='<tr>
                <td style="width:150px;text-align:center;">'.substr($row1[5],8,30).'</td>    
                <td style="width:100px;text-align:center;">'.'Factura'.'</td>
                <td style="width:100px;text-align:center;">'.$pv.'</td>
                <td style="width:100px;text-align:center;">'.$pc.'</td>
                <td style="width:100px;text-align:center;">'.$util.'</td>
                <td style="width:100px;text-align:center;">'.$row1[6].'</td>
                <td style="width:100px;text-align:center;">'.$row1[10].'</td>
                </tr>';
                $total=$total+$util;
            }
            $codigo.='</table>';    
             $codigo.='<hr><table>';                                                
            $codigo.='<tr>
            <td style="width:600px;text-align:left;font-weight:bold">'."Total de Utilidad por Factura".'</td>
            <td style="width:150px;text-align:center;font-weight:bold">'.(number_format($total,2,',','.')).'</td>';
            $codigo.='</tr>';                           
            $codigo.='</table>'; 
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
    $dompdf->stream('utilidad_factura.pdf',array('Attachment'=>0));
?>