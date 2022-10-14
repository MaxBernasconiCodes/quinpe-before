<? include("../Codigo/Seguridad.php");

//encabezado
$pdf->Image($imagen,13,15,35);
$pdf->Rect(10,10,270,22);$pdf->Line(50,10,50,32);$pdf->Line(240,10,240,32);
$pdf->SetFont('Arial','B',10);$pdf->SetXY(50,21);$pdf->Cell(190,4,$titulo,0,0,'C');
$pdf->SetFont('Arial','B',10);	
$pdf->SetXY(242,17);$pdf->Cell(0,3,'Nro.: '.$nro,0,0,'L');
$pdf->SetXY(242,22);$pdf->Cell(0,3,'Fecha: '.$fecha,0,0,'L');	

?>

