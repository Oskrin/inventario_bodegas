<?php
require('../reportes/dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../images/icono.jpg" />
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
        <h3>LISTA DE PRODUCTOS BODEGA</h3>
    </div>';
    include '../procesos/base.php';
    conectarse();    
    $total=0;
    $repetido=0;   
    $sql2 = pg_query("select cod_productos,stock_bodega from bodega_productos where id_bodega='$_SESSION[id_bodega]'");
    $codigo.='<table border=0>';
            $codigo.='<tr style="font-weight:bold;">                
            <td style="width:90px;text-align:left;">Imagén</td>
            <td style="width:180px;text-align:left;">Código</td>
            <td style="width:300px;text-align:left;">Producto</td>
            <td style="width:100px;text-align:left;">Precio Unitario</td>
            <td style="width:60px;text-align:left;">Stock</td>
            </tr>
            <tr><td colspan=6><hr></td></tr>';
        while($row2 = pg_fetch_row($sql2))
        {
            $sql=pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock,imagen from productos where cod_productos = '$row2[0]'");
            while($row=pg_fetch_row($sql)){          
                $codigo.='<tr style="font-size:10px;">                
                <td style="width:90px;text-align:left;"><img src="../fotos_productos/'.$row[6].'" style="width:70px;height:90px;" /></td>
                <td style="width:180px;text-align:left;">'.$row[0].'</td>
                <td style="width:300px;text-align:left;">'.$row[2].'</td>
                <td style="width:100px;text-align:center;">'.$row[3].'</td>
                <td style="width:60px;text-align:center;">'.$row2[1].'</td>
                </tr>';
            }
            $codigo.='<tr><td colspan=6><hr></td></tr>';
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