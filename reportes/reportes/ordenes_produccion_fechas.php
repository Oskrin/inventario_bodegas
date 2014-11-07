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
            <img src="../../images/icono.jpg" />
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
        <h3>ORDENES DE PRODUCCION POR FECHAS</h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $total=0;
    $sub=0;
    $repetido=0;   
    $contador=0; 
    $consulta=pg_query("select id_usuario,ci_usuario,nombre_usuario,apellido_usuario,telefono_usuario,direccion_usuario from usuario;");
    while($row=pg_fetch_row($consulta)){
        $repetido=0;
        $total=0;
        $sql1=pg_query("select comprobante,fecha_actual,codigo,articulo,cantidad,precio_compra,sub_total from ordenes_produccion,usuario,productos where  ordenes_produccion.id_usuario = usuario.id_usuario and ordenes_produccion.cod_productos = productos.cod_productos and fecha_actual between '".$_GET['inicio']."' and '".$_GET['fin']."' and usuario.id_usuario='$row[0]'");
        if(pg_num_rows($sql1)){
            if($repetido==0){
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">RUC/CI: '.$row[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[2].' '.$row[3].'</h2>';
                $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">TELF: '.$row[4].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DIRECCIÓN '.$row[5].'</h2>';

                $codigo.='<table>';                      
                $codigo.='<tr>                
                <td style="width:70px;text-align:center;">Comprobante</td>    
                <td style="width:70px;text-align:center;">Fecha</td>
                <td style="width:150px;text-align:center;">Código</td>
                <td style="width:250px;text-align:center;">Artículo</td>
                <td style="width:50px;text-align:center;">Cantidad</td>
                <td style="width:70px;text-align:center;">P. Costo</td>
                <td style="width:80px;text-align:center;">T. Costo</td>
                </tr><hr>';
                $codigo.='</table>';         
                $repetido=1;
            }
            $codigo.='<table style="font-size:11px;">';
            while($row1=pg_fetch_row($sql1)){
                $codigo.='<tr>
                <td style="width:70px;text-align:center;">'.' '.$row1[0].'</td>    
                <td style="width:70px;text-align:center;">'.' '.$row1[1].'</td>
                <td style="width:150px;text-align:center;">'.' '.$row1[2].'</td>
                <td style="width:250px;text-align:center;">'.' '.$row1[3].'</td>
                <td style="width:50px;text-align:center;">'.' '.$row1[4].'</td>
                <td style="width:70px;text-align:center;">'.' '.$row1[5].'</td>
                <td style="width:80px;text-align:center;">'.' '.$row1[6].'</td>
                
                
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