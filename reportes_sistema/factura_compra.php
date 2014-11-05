<?php
session_start();
include '../fdpf/fpdf.php';
include '../procesos/base.php';
conectarse();
//header("Content-Type: text/html; charset=iso-8859-1 ");
date_default_timezone_set('UTC');
$fecha= date("Y-m-d");
class PDF extends FPDF
{
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		if($_GET['hoja']=='Personalizar'){
			$h=2*$nb;
		}
		else{
			$h=6*$nb;
		}	
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			
			$this->Rect($x,$y,$w,$h);

			
			if($_GET['hoja']=='Personalizar'){
				$this->MultiCell( $w,2,$data[$i],0,$a,false);
			}
			else{
				$this->MultiCell( $w,6,$data[$i],0,$a,false);	
			}
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}

	function Header()
	{
	    $this->SetTextColor(70,119,159);             	
		if($_GET['hoja']=='A3'){
			$this->SetFont('Helvetica','B',20);
			$this->Text(170,25,utf8_decode('FACTURA COMPRA'),0,'C', 0);  			
			$this->Ln(15);
		}
		if($_GET['hoja']=='A4'){
			$this->SetFont('Helvetica','B',22);
			$this->Text(70,15,utf8_decode('FACTURA COMPRA'),0,'C', 0);	                
			
			$this->Ln(5);			           
		}
		if($_GET['hoja']=='A5'){
			$this->SetFont('Helvetica','B',15);
			$this->Text(85,17,utf8_decode('FACTURA COMPRA'),0,'C', 0);	                			
			$this->Ln(7);
		}
		if($_GET['hoja']=='Letter'){
			$this->SetFont('Helvetica','B',20);
			$this->Text(115,20,utf8_decode('FACTURA COMPRA'),0,'C', 0);	               
			$this->Ln(10);
		}
		if($_GET['hoja']=='Legal'){
			$this->SetFont('Helvetica','B',15);
			$this->Text(140,25,utf8_decode('FACTURA COMPRA'),0,'C', 0);	                
			$this->Ln(10);
		}
		if($_GET['hoja']=='Personalizar'){
			$this->SetFont('Helvetica','B',5);
			$this->Text(30,10,utf8_decode('FACTURA COMPRA'),0,'C', 0);
			$this->Ln(3);
		}			
	}
	function Footer()
	{	
		if($_GET['hoja']=='Personalizar'){
			$this->SetY(-15);
			$this->SetFont('Arial','B',3);
			$this->Cell(100,20,utf8_decode('FACTURA COMPRA'),0,0,'L');			
			$this->Cell(50,10,utf8_decode('Página ').$this->PageNo(),0,0,'L');			
			$this->Cell(50,10,utf8_decode('Página ').$this->PageNo(),0,0,'R');
		}
		else{
			$this->SetY(-15);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,10,utf8_decode('FACTURA COMPRA'),0,0,'L');			
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'R');	
		}
	}
}			
	if($_GET['hoja']=='Personalizar'){
		$pdf=new PDF('P','mm',array($_GET['w'],$_GET['h']));	
		$pdf->Open();
		$pdf->AddPage();
		$pdf->SetMargins(2,10,0);
		$pdf->Ln(1);
	}
	else{
		if($_GET['hoja']=='A4'){
			$pdf=new PDF('P','mm',$_GET['hoja']);					
			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetMargins(5,5,5);
			$pdf->Ln(10);
		}
		else{
			$pdf=new PDF('L','mm',$_GET['hoja']);					
			$pdf->Open();
			$pdf->AddPage();
			$pdf->SetMargins(10,10,10);
			$pdf->Ln(10);	
		}
		
	}
	
	///////////////
    $pdf->SetFont('Arial','',9);
    
    $sql=pg_query("select id_factura_compra,comprobante,fecha_actual,hora_actual,num_serie,num_autorizacion,fecha_cancelacion,empresa_pro,representante_legal,factura_compra.forma_pago from factura_compra,proveedores where factura_compra.id_proveedor=proveedores.id_proveedor and id_factura_compra='$_GET[id]'");    
    $fila = pg_fetch_row($sql);   
    if($_GET['hoja']=='A4'){    	    
		$pdf->Cell(30,6,'Comprobante Nro.:',1,0,'C');
	    $pdf->Cell(40,6,utf8_decode($fila[1]),1,0,'L');	
		$pdf->Cell(40,6,'Fecha:',1,0,'C');
	    $pdf->Cell(30,6,utf8_decode($fila[2]),1,0,'L');	
	    $pdf->Cell(30,6,'Hora:',1,0,'C');    	
	    $pdf->Cell(30,6,utf8_decode($fila[3]),1,1,'L');	

	    $pdf->Cell(30,6,'Nro. de serie:',1,0,'C');
	    $pdf->Cell(40,6,utf8_decode($fila[4]),1,0,'L');	
		$pdf->Cell(40,6,utf8_decode('Nro. de autorización:'),1,0,'C');
	    $pdf->Cell(30,6,utf8_decode($fila[5]),1,0,'L');	
	    $pdf->Cell(30,6,utf8_decode('F. Cancelación:'),1,0,'C');    	
	    $pdf->Cell(30,6,utf8_decode($fila[6]),1,1,'L');	
	    	
	    $pdf->Cell(30,6,'Empresa:',1,0,'C');
	    $pdf->Cell(110,6,utf8_decode($fila[7]),1,0,'L');			
	    $pdf->Cell(30,6,utf8_decode('Forma pago:'),1,0,'C');    	
	    $pdf->Cell(30,6,utf8_decode($fila[9]),1,1,'L');	
	    $pdf->Cell(30,6,utf8_decode('Representate:'),1,0,'C');
	    $pdf->Cell(170,6,utf8_decode($fila[8]),1,1,'L');	
	    $pdf->Ln(5);	
	    $pdf->SetWidths(array(30, 110,30,30));
		$pdf->SetFont('Arial','B',8);	    
	    $pdf->SetFillColor(85,107,47);
		for($i=0;$i<1;$i++)
		{
			$pdf->Row(array(utf8_decode('Cantidad'),utf8_decode('Descripción'),utf8_decode('V. Unitario'),utf8_decode('V. Total')));
		}	
		$sql=pg_query("select detalle_factura_compra.cantidad,productos.articulo,detalle_factura_compra.precio_compra,detalle_factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");		
		$numfilas = pg_num_rows($sql);
		for ($i=0; $i<$numfilas; $i++)
		{		
			$fila = pg_fetch_row($sql);			
			$pdf->SetFont('Arial','',8);				
			$pdf->SetFillColor(255,255,255);
	    	$pdf->SetTextColor(0);
			$pdf->Row(array(utf8_decode($fila[0]), utf8_decode($fila[1]), utf8_decode($fila[2]), utf8_decode($fila[3])));		
		}	
		$sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
	    $fila = pg_fetch_row($sql);       	        
	  	$pdf->SetFont('Arial','',8);	   
	  	$pdf->SetX(145);
		$pdf->Cell(30,6,'Descuento.:',1,0,'C');
	    $pdf->Cell(30,6,utf8_decode($fila[0]),1,1,'C');	
		$pdf->SetX(145);
		$pdf->Cell(30,6,'Tarifa 0:',1,0,'C');
	    $pdf->Cell(30,6,utf8_decode($fila[1]),1,1,'C');	
	    $pdf->SetX(145);
	    $pdf->Cell(30,6,'Tarifa 12:',1,0,'C');    	
	    $pdf->Cell(30,6,utf8_decode($fila[2]),1,1,'C');		
	    $pdf->SetX(145);
	    $pdf->Cell(30,6,'Iva Compra:',1,0,'C');    	
	    $pdf->Cell(30,6,utf8_decode($fila[3]),1,1,'C');		
	    $pdf->SetX(145);
	    $pdf->Cell(30,6,'Total:',1,0,'C');    	
	    $pdf->Cell(30,6,utf8_decode($fila[4]),1,1,'C');		
    }		
    if($_GET['hoja']=='A3'){    	    
		$pdf->Cell(70,8,'Comprobante Nro.:',1,0,'C');
	    $pdf->Cell(70,8,utf8_decode($fila[1]),1,0,'C');	
		$pdf->Cell(70,8,'Fecha:',1,0,'C');
	    $pdf->Cell(60,8,utf8_decode($fila[2]),1,0,'C');	
	    $pdf->Cell(60,8,'Hora:',1,0,'C');    	
	    $pdf->Cell(60,8,utf8_decode($fila[3]),1,1,'C');	

	    $pdf->Cell(70,8,'Nro. de serie:',1,0,'C');
	    $pdf->Cell(70,8,utf8_decode($fila[4]),1,0,'C');	
		$pdf->Cell(70,8,utf8_decode('Nro. de autorización:'),1,0,'C');
	    $pdf->Cell(60,8,utf8_decode($fila[5]),1,0,'C');	
	    $pdf->Cell(60,8,utf8_decode('F. Cancelación:'),1,0,'C');    	
	    $pdf->Cell(60,8,utf8_decode($fila[6]),1,1,'C');	
	    	
	    $pdf->Cell(70,8,'Empresa:',1,0,'C');
	    $pdf->Cell(70,8,utf8_decode($fila[7]),1,0,'C');	
		$pdf->Cell(70,8,utf8_decode('Representate:'),1,0,'C');
	    $pdf->Cell(60,8,utf8_decode($fila[8]),1,0,'C');	
	    $pdf->Cell(60,8,utf8_decode('Forma pago:'),1,0,'C');    	
	    $pdf->Cell(60,8,utf8_decode($fila[9]),1,1,'C');	
	    $pdf->Ln(5);
		$pdf->SetWidths(array(80, 150, 80, 80));
		$pdf->SetFont('Arial','B',12);	    
	    $pdf->SetFillColor(85,107,47);
		for($i=0;$i<1;$i++)
		{
			$pdf->Row(array(utf8_decode('Cantidad'),utf8_decode('Descripción'),utf8_decode('V. Unitario'),utf8_decode('V. Total')));
		}	
		$sql=pg_query("select detalle_factura_compra.cantidad,productos.articulo,detalle_factura_compra.precio_compra,detalle_factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");		
		$numfilas = pg_num_rows($sql);
		for ($i=0; $i<$numfilas; $i++)
		{		
			$fila = pg_fetch_row($sql);			
			$pdf->SetFont('Arial','',11);				
			$pdf->SetFillColor(255,255,255);
	    	$pdf->SetTextColor(0);
			$pdf->Row(array(utf8_decode($fila[0]), utf8_decode($fila[1]), utf8_decode($fila[2]), utf8_decode($fila[3])));		
		}	
		$sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
	    $fila = pg_fetch_row($sql);       	        
	  	$pdf->SetFont('Arial','',8);	   
	  	$pdf->SetX(320);
		$pdf->Cell(40,8,'Descuento.:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[0]),1,1,'C');	
		$pdf->SetX(320);
		$pdf->Cell(40,8,'Tarifa 0:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[1]),1,1,'C');	
	    $pdf->SetX(320);
	    $pdf->Cell(40,8,'Tarifa 12:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[2]),1,1,'C');		
	    $pdf->SetX(320);
	    $pdf->Cell(40,8,'Iva Compra:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[3]),1,1,'C');		
	    $pdf->SetX(320);
	    $pdf->Cell(40,8,'Total:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[4]),1,1,'C');			
    }	
    if($_GET['hoja']=='A5'){    
    	$pdf->SetFont('Arial','',8);		    
		$pdf->Cell(30,8,'Comprobante Nro.:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[1]),1,0,'C');	
		$pdf->Cell(30,8,'Fecha:',1,0,'C');
	    $pdf->Cell(30,8,utf8_decode($fila[2]),1,0,'C');	
	    $pdf->Cell(30,8,'Hora:',1,0,'C');    	
	    $pdf->Cell(30,8,utf8_decode($fila[3]),1,1,'C');	

	    $pdf->Cell(30,8,'Nro. de serie:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[4]),1,0,'C');	
		$pdf->Cell(30,8,utf8_decode('Nro. de autorización:'),1,0,'C');
	    $pdf->Cell(30,8,utf8_decode($fila[5]),1,0,'C');	
	    $pdf->Cell(30,8,utf8_decode('F. Cancelación:'),1,0,'C');    	
	    $pdf->Cell(30,8,utf8_decode($fila[6]),1,1,'C');	
	    	
	    $pdf->Cell(30,8,'Empresa:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[7]),1,0,'C');	
		$pdf->Cell(30,8,utf8_decode('Representate:'),1,0,'C');
	    $pdf->Cell(30,8,utf8_decode($fila[8]),1,0,'C');	
	    $pdf->Cell(30,8,utf8_decode('Forma pago:'),1,0,'C');    	
	    $pdf->Cell(30,8,utf8_decode($fila[9]),1,1,'C');	
	    $pdf->Ln(5);
	    $pdf->SetWidths(array(30, 80, 40, 40));
		$pdf->SetFont('Arial','B',8);	    
	    $pdf->SetFillColor(85,107,47);
		for($i=0;$i<1;$i++)
		{
			$pdf->Row(array(utf8_decode('Cantidad'),utf8_decode('Descripción'),utf8_decode('V. Unitario'),utf8_decode('V. Total')));
		}	
		$sql=pg_query("select detalle_factura_compra.cantidad,productos.articulo,detalle_factura_compra.precio_compra,detalle_factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");		
		$numfilas = pg_num_rows($sql);
		for ($i=0; $i<$numfilas; $i++)
		{		
			$fila = pg_fetch_row($sql);			
			$pdf->SetFont('Arial','',8);				
			$pdf->SetFillColor(255,255,255);
	    	$pdf->SetTextColor(0);
			$pdf->Row(array(utf8_decode($fila[0]), utf8_decode($fila[1]), utf8_decode($fila[2]), utf8_decode($fila[3])));		
		}	
		$sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
	    $fila = pg_fetch_row($sql);       	        
	  	$pdf->SetFont('Arial','',8);	   
	  	$pdf->SetX(120);
		$pdf->Cell(40,8,'Descuento.:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[0]),1,1,'C');	
		$pdf->SetX(120);
		$pdf->Cell(40,8,'Tarifa 0:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[1]),1,1,'C');	
	    $pdf->SetX(120);
	    $pdf->Cell(40,8,'Tarifa 12:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[2]),1,1,'C');		
	    $pdf->SetX(120);
	    $pdf->Cell(40,8,'Iva Compra:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[3]),1,1,'C');		
	    $pdf->SetX(120);
	    $pdf->Cell(40,8,'Total:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[4]),1,1,'C');			
    }			
    if($_GET['hoja']=='Letter'){    
    	$pdf->SetFont('Arial','',8);		    
		$pdf->Cell(50,8,'Comprobante Nro.:',1,0,'C');
	    $pdf->Cell(50,8,utf8_decode($fila[1]),1,0,'C');	
		$pdf->Cell(40,8,'Fecha:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[2]),1,0,'C');	
	    $pdf->Cell(40,8,'Hora:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[3]),1,1,'C');	

	    $pdf->Cell(50,8,'Nro. de serie:',1,0,'C');
	    $pdf->Cell(50,8,utf8_decode($fila[4]),1,0,'C');	
		$pdf->Cell(40,8,utf8_decode('Nro. de autorización:'),1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[5]),1,0,'C');	
	    $pdf->Cell(40,8,utf8_decode('F. Cancelación:'),1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[6]),1,1,'C');	
	    	
	    $pdf->Cell(50,8,'Empresa:',1,0,'C');
	    $pdf->Cell(50,8,utf8_decode($fila[7]),1,0,'C');	
		$pdf->Cell(40,8,utf8_decode('Representate:'),1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[8]),1,0,'C');	
	    $pdf->Cell(40,8,utf8_decode('Forma pago:'),1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[9]),1,1,'C');	
	    $pdf->Ln(5);
	    $pdf->SetWidths(array(40, 110, 55, 55));
		$pdf->SetFont('Arial','B',8);	    
	    $pdf->SetFillColor(85,107,47);
		for($i=0;$i<1;$i++)
		{
			$pdf->Row(array(utf8_decode('Cantidad'),utf8_decode('Descripción'),utf8_decode('V. Unitario'),utf8_decode('V. Total')));
		}	
		$sql=pg_query("select detalle_factura_compra.cantidad,productos.articulo,detalle_factura_compra.precio_compra,detalle_factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");		
		$numfilas = pg_num_rows($sql);
		for ($i=0; $i<$numfilas; $i++)
		{		
			$fila = pg_fetch_row($sql);			
			$pdf->SetFont('Arial','',8);				
			$pdf->SetFillColor(255,255,255);
	    	$pdf->SetTextColor(0);
			$pdf->Row(array(utf8_decode($fila[0]), utf8_decode($fila[1]), utf8_decode($fila[2]), utf8_decode($fila[3])));		
		}	
		$sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
	    $fila = pg_fetch_row($sql);       	        
	  	$pdf->SetFont('Arial','',8);	   
	  	$pdf->SetX(190);
		$pdf->Cell(40,8,'Descuento.:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[0]),1,1,'C');	
		$pdf->SetX(190);
		$pdf->Cell(40,8,'Tarifa 0:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[1]),1,1,'C');	
	    $pdf->SetX(190);
	    $pdf->Cell(40,8,'Tarifa 12:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[2]),1,1,'C');		
	    $pdf->SetX(190);
	    $pdf->Cell(40,8,'Iva Compra:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[3]),1,1,'C');		
	    $pdf->SetX(190);
	    $pdf->Cell(40,8,'Total:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[4]),1,1,'C');			
    }	
    if($_GET['hoja']=='Legal'){    	    
		$pdf->Cell(60,8,'Comprobante Nro.:',1,0,'C');
	    $pdf->Cell(60,8,utf8_decode($fila[1]),1,0,'C');	
		$pdf->Cell(55,8,'Fecha:',1,0,'C');
	    $pdf->Cell(55,8,utf8_decode($fila[2]),1,0,'C');	
	    $pdf->Cell(50,8,'Hora:',1,0,'C');    	
	    $pdf->Cell(50,8,utf8_decode($fila[3]),1,1,'C');	

	    $pdf->Cell(60,8,'Nro. de serie:',1,0,'C');
	    $pdf->Cell(60,8,utf8_decode($fila[4]),1,0,'C');	
		$pdf->Cell(55,8,utf8_decode('Nro. de autorización:'),1,0,'C');
	    $pdf->Cell(55,8,utf8_decode($fila[5]),1,0,'C');	
	    $pdf->Cell(50,8,utf8_decode('F. Cancelación:'),1,0,'C');    	
	    $pdf->Cell(50,8,utf8_decode($fila[6]),1,1,'C');	
	    	
	    $pdf->Cell(60,8,'Empresa:',1,0,'C');
	    $pdf->Cell(60,8,utf8_decode($fila[7]),1,0,'C');	
		$pdf->Cell(55,8,utf8_decode('Representate:'),1,0,'C');
	    $pdf->Cell(55,8,utf8_decode($fila[8]),1,0,'C');	
	    $pdf->Cell(50,8,utf8_decode('Forma pago:'),1,0,'C');    	
	    $pdf->Cell(50,8,utf8_decode($fila[9]),1,1,'C');	
	    $pdf->Ln(5);	
	    $pdf->SetWidths(array(50, 140, 70, 70));
		$pdf->SetFont('Arial','B',8);	    
	    $pdf->SetFillColor(85,107,47);
		for($i=0;$i<1;$i++)
		{
			$pdf->Row(array(utf8_decode('Cantidad'),utf8_decode('Descripción'),utf8_decode('V. Unitario'),utf8_decode('V. Total')));
		}	
		$sql=pg_query("select detalle_factura_compra.cantidad,productos.articulo,detalle_factura_compra.precio_compra,detalle_factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");		
		$numfilas = pg_num_rows($sql);
		for ($i=0; $i<$numfilas; $i++)
		{		
			$fila = pg_fetch_row($sql);			
			$pdf->SetFont('Arial','',8);				
			$pdf->SetFillColor(255,255,255);
	    	$pdf->SetTextColor(0);
			$pdf->Row(array(utf8_decode($fila[0]), utf8_decode($fila[1]), utf8_decode($fila[2]), utf8_decode($fila[3])));		
		}	
		$sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
	    $fila = pg_fetch_row($sql);       	        
	  	$pdf->SetFont('Arial','',8);	   
	  	$pdf->SetX(260);
		$pdf->Cell(40,8,'Descuento.:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[0]),1,1,'C');	
		$pdf->SetX(260);
		$pdf->Cell(40,8,'Tarifa 0:',1,0,'C');
	    $pdf->Cell(40,8,utf8_decode($fila[1]),1,1,'C');	
	    $pdf->SetX(260);
	    $pdf->Cell(40,8,'Tarifa 12:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[2]),1,1,'C');		
	    $pdf->SetX(260);
	    $pdf->Cell(40,8,'Iva Compra:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[3]),1,1,'C');		
	    $pdf->SetX(260);
	    $pdf->Cell(40,8,'Total:',1,0,'C');    	
	    $pdf->Cell(40,8,utf8_decode($fila[4]),1,1,'C');		
    }	
    if($_GET['hoja']=='Personalizar'){    
    	$pdf->SetFont('Arial','',3);		    
		$pdf->Cell(15,5,'Comprobante Nro.:',1,0,'C');
	    $pdf->Cell(15,5,utf8_decode($fila[1]),1,0,'C');	
		$pdf->Cell(10,5,'Fecha:',1,0,'C');
	    $pdf->Cell(10,5,utf8_decode($fila[2]),1,0,'C');	
	    $pdf->Cell(10,5,'Hora:',1,0,'C');    	
	    $pdf->Cell(10,5,utf8_decode($fila[3]),1,1,'C');	

	    $pdf->Cell(15,5,'Nro. de serie:',1,0,'C');
	    $pdf->Cell(15,5,utf8_decode($fila[4]),1,0,'C');	
		$pdf->Cell(10,5,utf8_decode('Nro. de autorización:'),1,0,'C');
	    $pdf->Cell(10,5,utf8_decode($fila[5]),1,0,'C');	
	    $pdf->Cell(10,5,utf8_decode('F. Cancelación:'),1,0,'C');    	
	    $pdf->Cell(10,5,utf8_decode($fila[6]),1,1,'C');	
	    	
	    $pdf->Cell(15,5,'Empresa:',1,0,'C');
	    $pdf->Cell(15,5,utf8_decode($fila[7]),1,0,'C');	
		$pdf->Cell(10,5,utf8_decode('Representate:'),1,0,'C');
	    $pdf->Cell(10,5,utf8_decode($fila[8]),1,0,'C');	
	    $pdf->Cell(10,5,utf8_decode('Forma pago:'),1,0,'C');    	
	    $pdf->Cell(10,5,utf8_decode($fila[9]),1,1,'C');	
	    $pdf->Ln(2);
	    $pdf->SetWidths(array(15, 21, 17, 17));
		$pdf->SetFont('Arial','B',6);	    
	    $pdf->SetFillColor(85,107,47);
		for($i=0;$i<1;$i++)
		{
			$pdf->Row(array(utf8_decode('Cantidad'),utf8_decode('Descripción'),utf8_decode('V. Unitario'),utf8_decode('V. Total')));
		}	
		$sql=pg_query("select detalle_factura_compra.cantidad,productos.articulo,detalle_factura_compra.precio_compra,detalle_factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");		
		$numfilas = pg_num_rows($sql);
		for ($i=0; $i<$numfilas; $i++)
		{		
			$fila = pg_fetch_row($sql);			
			$pdf->SetFont('Arial','',6);				
			$pdf->SetFillColor(255,255,255);
	    	$pdf->SetTextColor(0);
			$pdf->Row(array(utf8_decode($fila[0]), utf8_decode($fila[1]), utf8_decode($fila[2]), utf8_decode($fila[3])));		
		}	
		$sql=pg_query("select factura_compra.descuento_compra,factura_compra.tarifa0,factura_compra.tarifa12,factura_compra.iva_compra,factura_compra.total_compra from factura_compra,detalle_factura_compra,productos where factura_compra.id_factura_compra=detalle_factura_compra.id_factura_compra and detalle_factura_compra.cod_productos=productos.cod_productos and detalle_factura_compra.id_factura_compra='$_GET[id]'");    
	    $fila = pg_fetch_row($sql);       	        
	  	$pdf->SetFont('Arial','',6);	   
	  	$pdf->SetX(38);
		$pdf->Cell(17,5,'Descuento.:',1,0,'C');
	    $pdf->Cell(17,5,utf8_decode($fila[0]),1,1,'C');	
		$pdf->SetX(38);
		$pdf->Cell(17,5,'Tarifa 0:',1,0,'C');
	    $pdf->Cell(17,5,utf8_decode($fila[1]),1,1,'C');	
	    $pdf->SetX(38);
	    $pdf->Cell(17,5,'Tarifa 12:',1,0,'C');    	
	    $pdf->Cell(17,5,utf8_decode($fila[2]),1,1,'C');		
	    $pdf->SetX(38);
	    $pdf->Cell(17,5,'Iva Compra:',1,0,'C');    	
	    $pdf->Cell(17,5,utf8_decode($fila[3]),1,1,'C');		
	    $pdf->SetX(38);
	    $pdf->Cell(17,5,'Total:',1,0,'C');    	
	    $pdf->Cell(17,5,utf8_decode($fila[4]),1,1,'C');			
    }						
	$pdf->Output();
?>