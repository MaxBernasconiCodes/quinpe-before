<? include("../Codigo/Seguridad.php");

//encabezado
$pdf->Image($imagen,13,15,35);
$pdf->Rect(10,10,190,22);$pdf->Line(50,10,50,32);$pdf->Line(160,10,160,32);
$pdf->SetFont('Arial','B',10);$pdf->SetXY(50,21);$pdf->Cell(110,4,$titulo,0,0,'C');
$pdf->SetFont('Arial','B',10);	
$pdf->SetXY(162,17);$pdf->Cell(0,3,'Nro.: '.$nro,0,0,'L');
$pdf->SetXY(162,22);$pdf->Cell(0,3,'Fecha: '.$fecha,0,0,'L');	

?>