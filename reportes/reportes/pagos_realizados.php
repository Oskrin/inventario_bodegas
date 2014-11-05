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
        <h3>PAGOS REALIZADOS EXTERNOS POR LA EMPRESA </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $desc=0;
    $ivaT=0;
    $repetido=0;   
    $contador=0; 
    $consulta=pg_query('select * FROM proveedores order by id_proveedor asc');
    while($row=pg_fetch_row($consulta)){
        $total=0;
        $sub=0;
        $saldo=0;
        $repetido=0; 
        $contador=0;   
        $num_fact=0;
        ///////////externas
        $sql1=pg_query("select * from c_pagarexternas where id_proveedor='$row[0]' order by id_proveedor asc;");
         while($row1=pg_fetch_row($sql1)){
            $sql2=pg_query("select * FROM pagos_pagar where num_factura='$row1[7]' order by id_cuentas_pagar asc");

            if(pg_num_rows($sql2)>0){
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
                    $codigo.='</table>';         
                    $repetido=1;
                    $contador=1;
                }
                $codigo.='<table>';   
                while($row2=pg_fetch_row($sql2)){
                    $codigo.='<tr>
                    <td style="width:100px;text-align:center;">'.$row2[1].'</td>
                    <td style="width:100px;text-align:center;">'.$row2[9].'</td>
                    <td style="width:150px;text-align:center;">'.substr($row2[8],8,30).'</td>
                    <td style="width:100px;text-align:center;">'.($row2[12]+$row2[13]).'</td>
                    <td style="width:100px;text-align:center;">'.$row2[12].'</td>
                    <td style="width:100px;text-align:center;">'.$row2[13].'</td>
                    <td style="width:100px;text-align:center;">'.$row2[10].'</td>
                    </tr>';              
                    $sub=$sub+$row2[12];
                }
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
        //////////////////
    }

    $codigo=utf8_decode($codigo);
    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('pagos_realizados.pdf',array('Attachment'=>0));
?>