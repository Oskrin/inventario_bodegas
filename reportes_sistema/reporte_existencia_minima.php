<?php
require('../reportes/dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../images/logo_empresa.jpg" />
            <div id="me">
                <<h2 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['empresa'].'</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['slogan'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['propietario'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['direccion'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: '.$_SESSION['telefono'].' Cel:  '.$_SESSION['celular'].' '.$_SESSION['pais_ciudad'].'</h4>
            </div>        
    </header>        
    <hr>
    <div id="linea">
        <h3>LISTA DE PRODUCTOS EN EXISTENCIA MÍNIMA</h3>
    </div>';
    include '../procesos/base.php';
    conectarse();    
    $total=0;
    $repetido=0;    
    $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,stock_minimo from productos where stock::integer  < stock_minimo::integer  order by cod_productos");
    $codigo.='<table border=0>';
    $codigo.='<tr style="font-weight:bold;">                
    <td style="width:150px;text-align:center;">Código</td>
    <td style="width:230px;text-align:center;">Producto</td>
    <td style="width:100px;text-align:center;">Precio Minorista</td>
    <td style="width:100px;text-align:center;">Precio Mayorista</td>
    <td style="width:60px;text-align:center;">Stock</td>
    <td style="width:80px;text-align:center;">Stock Mínimo</td>
    </tr>
    <tr><td colspan=6><hr></td></tr>';
    while($row=pg_fetch_row($sql)){          
        $codigo.='<tr style="font-size:10px;">                
        <td style="width:150px;text-align:left;">'.$row[0].'</td>
        <td style="width:230px;text-align:left;">'.$row[2].'</td>
        <td style="width:100px;text-align:center;">'.$row[3].'</td>
        <td style="width:100px;text-align:center;">'.$row[4].'</td>
        <td style="width:60px;text-align:center;">'.$row[5].'</td>
        <td style="width:80px;text-align:center;">'.$row[6].'</td>
        </tr>';
    }
    $codigo.='</table>';
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporte_agrupados_prov.pdf',array('Attachment'=>0));
?>