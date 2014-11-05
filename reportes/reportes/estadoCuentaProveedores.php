<?php
require('../dompdf/dompdf_config.inc.php');

	$codigo='<html> 
    <head> 
   		<link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
	</head> 
	<body>
		<header>
            <img src="../../images/logo_empresa.jpg" />
            <div id="me">
                <h2 style="text-align:center;border:solid 0px;width:100%;">GamasuD</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Fabricación de Prendas de Vestir</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">FARINANGO LEÓN MARÍA EUGENIA</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Matriz: Carlos Barahona 2-51 y Pasaje J / Sucursal: Sánchez y Cifuentes 15-37</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: 062 953 734 / 5 000 192 Cel:  0993 740 497 Ibarra - Ecuador</h4>
                <h4 style="text-align: center;width:50%;display: inline-block;">Desde el : '.$_GET['inicio'].'</h4>
                <h4 style="text-align: center;width:45%;display: inline-block;">Hasta el : '.$_GET['fin'].'</h4>
            </div>      
        </header>        
        <hr>
        <div id="linea">
            <h3>KARDEX DE PROVEEDORES</h3>
        </div>';
		include '../../procesos/base.php';
		conectarse();    
        $total=0;
        $saldo=0;
        $repetido=0;
        $consulta=pg_query("select * from proveedores where id_proveedor='$_GET[id]' order by id_cliente asc");
        while($row=pg_fetch_row($consulta)){
            $consulta1=pg_query("select * from c_pagarexternas where id_proveedor='$_GET[id]' and fecha_actual between '$_GET[inicio]' and '$_GET[fin]' order by id_c_cobrarexternas asc");
             $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">RUC/CI: '.$row[2].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[3].'</h2>';
            while($row1=pg_fetch_row($consulta1)){
                $total=0;
                $codigo.='<div id="cuerpo">';                    
                    $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:10px;color:red;background:#fff">Factura #: '.substr($row1[7],8,15).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Serie: '.substr($row1[7],0,7).'</h2>';
                    $codigo.='<table style="color:blue;font-weight:bold;text-decoration:underline;" border=0>';                     
                        $codigo.='<tr>                
                        <td style="width:70px">Comprobante</td>
                        <td style="width:70px">Tipo Doc</td>
                        <td style="width:70px">Fecha Mov</td>
                        <td style="width:70px">Valor</td>
                        <td style="width:70px">Saldo</td></tr>';
                        $repetido=1;   
                    $codigo.='</table>';                    
                
                    $codigo.='<table border=0>';                                                
                        $codigo.='<tr>                
                        <td style="width:70px">'.$row1[4].'</td>
                        <td style="width:70px">'.$row1[8].'</td>                    
                        <td style="width:70px">'.$row1[5].'</td>
                        <td style="width:70px">'.$row1[9].'</td>';
                        $total=$total+$row1[10];  
                        $saldo=$saldo+$row1[10];              
                        $codigo.='<td style="width:70px">'.$row1[10].'</td></tr>';          
                    $codigo.='</table>'; 
                    $codigo.='<table style="color:blue;font-weight:bold;font-size:14px;margin-top:20px;">';        
                $codigo.='<tr>                
                    <td style="width:70px">Saldo Pendiente</td>
                    <td style="width:70px">'.'&nbsp;'.'</td>                   
                    <td style="width:70px">'.'&nbsp;'.'</td>
                    <td style="width:70px">'.'&nbsp;'.'</td>
                    <td style="width:70px">'.$total.'</td></tr>';
                $codigo.='</table><hr>';         
            }
            ////total final///   
            $codigo.='<table style="color:blue;font-weight:bold;font-size:14px;margin-top:20px;"><tr>                
                <td style="width:70px">Gran Total</td>
                <td style="width:70px">'.'&nbsp;'.'</td>                   
                <td style="width:70px">'.'&nbsp;'.'</td>
                <td style="width:70px">'.'&nbsp;'.'</td>
                <td style="width:70px">'.$saldo.'</td></tr>';
            $codigo.='</table>';    
        }
        ///cxc externas
        ///////////////
       
             
	$codigo.='</body></html>';           				 
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('estadoCuentaProveedores.pdf',array('Attachment'=>0));
//exec('arp '.$_SERVER['REMOTE_ADDR'],$user_mac);
//echo substr($user_mac[1],strpos($user_mac[1],':')-2, '17');

?>

