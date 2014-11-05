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
            <h3>RESUMEN GENERAL DE FACTURAS VENTAS </h3>
        </div>';
		include '../../procesos/base.php';
		conectarse();    
        $total=0;
        $sub=0;
        $desc=0;
        $ivaT=0;
         $repetido=0;
        
            $consulta1=pg_query("select num_factura,fecha_actual,hora_actual,fecha_cancelacion,tipo_precio,forma_pago,tarifa0,tarifa12,iva_venta,descuento_venta,total_venta,identificacion,nombres_cli,nombre_empresa,id_factura_venta from factura_venta, clientes,empresa,usuario where factura_venta.id_cliente=clientes.id_cliente and factura_venta.id_empresa=empresa.id_empresa and usuario.id_usuario=factura_venta.id_usuario  order by factura_venta.id_factura_venta asc");
            $contador=pg_num_rows($consulta1);
            if($contador > 0){
               
                while($row1=pg_fetch_row($consulta1)){                     
                    $codigo.='<div id="cuerpo">';
                    if($repetido==0){                        
                        
                        $codigo.='<table>';                      
                        $codigo.='<tr>                
                        <td style="width:70px">Comprobante</td>
                        <td style="width:60px">Fecha</td>
                        <td style="width:70px">Nro Factura</td>
                        <td style="width:60px">Subtotal</td>
                        <td style="width:60px">Descuento</td>                       
                        <td style="width:70px">Tarifa 0%</td>
                        <td style="width:70px">Tarifa 12%</td>
                         <td style="width:60px">Iva 12%</td>
                        <td style="width:70px">Total</td>
                        <td style="width:70px">Fecha Pago</td>
                        <td style="width:70px">Tipo Pago</td></tr><hr>';
                        $repetido=1;   
                        $codigo.='</table>';                    
                    } 
                    $codigo.='<table>';                               
                        $codigo.='<tr>                
                        <td style="width:70px">'.$row1[14].'</td>
                        <td style="width:60px">'.$row1[1].'</td>
                        <td style="width:70px">'.substr($row1[0],8).'</td>';
                        $sub=$sub+($row1[10]-$row1[8]-$row1[9]);
                        $codigo.='<td style="width:60px">'.($row1[10]-$row1[8]-$row1[9]).'</td>';
                        $desc=$desc+$row1[9];
                        $codigo.='<td style="width:60px">'.$row1[9].'</td>                       
                        <td style="width:70px">'.$row1[6].'</td>
                        <td style="width:70px">'.$row1[7].'</td>';
                        $ivaT=$ivaT+$row1[8];
                        $codigo.='<td style="width:60px">'.$row1[8].'</td>';
                        $total=$total+$row1[10];
                        $codigo.='<td style="width:70px">'.$row1[10].'</td>
                        <td style="width:70px">'.$row1[3].'</td>
                        <td style="width:70px">'.$row1[5].'</td></tr>';                         
                    $codigo.='</table>'; 
                   
                    
                   
                    $codigo.='</div>';
                }
                       
           
        }
        $codigo.='<hr>';
         $codigo.='<table>';                                                
                $codigo.='<tr>
                <td style="width:200px;text-align:center;font-weight:bold">'."Totales".'</td>
                <td style="width:80px;text-align:center;font-weight:bold">'.(number_format($sub,2,',','.')).'</td>
                <td style="width:200px;font-weight:bold">'.(number_format($desc,2,',','.')).'</td>
                <td style="width:60px;text-align:center;font-weight:bold">'.(number_format($ivaT,2,',','.')).'</td>
                <td style="width:60px;text-align:center;font-weight:bold">'.(number_format($total,2,',','.')).'</td>';
                $codigo.='</tr>';                           
                $codigo.='</table>'; 
       
             
	$codigo.='</body></html>';           				 
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('general.pdf',array('Attachment'=>0));
?>