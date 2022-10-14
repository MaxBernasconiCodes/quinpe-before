<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbProducto']) or empty($_POST['CbCliente']) or empty($_POST['CbPersonal'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatos.php");
		//update
		$query="Update cam Set Fecha='$fa',FechaV='$fv',IdProducto=$prod,IdCliente=$cli,Lote='$lote',Rto='$rto',OC='$oc',Obs1='$obs1',Obs2='$obs2',IdE=$est,IdPer=$per,LoteVto='$fvl' Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
	}
}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	$ori=intval($_SESSION['TxtOriOPELab']);//de dde viene
	$_SESSION['TxtOriOPELab']='';//limpio
	//
	if($ori==0){header("Location:../CAM.php");}//barrera consulta
	if($ori==1){header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtIdPadre'])."&Flag1=True");}//solicitud
}


//ver solicitud
elseif (isset($_POST['CmdVerSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtIdOriOPESoli']=intval($_POST['TxtNumero']);//id barrera para volver	
	$_SESSION['TxtOriOPESoli']=2; //id etapa para volver
	header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtIdPadre'])."&Flag1=True");	
}


//items cam
elseif (isset($_POST['CmdAdd'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaItem.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFila'])){
	$query="Delete From cam_items Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}






elseif (isset($_POST['CmdImprimir'])){
	include("../FPDF/fpdf.php");
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//datos
	$query="Select a.*,cli.Nombre as Cliente,p.Nombre as Producto,pe.Nombre as NA,pe.Apellido as AA From cam a,clientes cli,items p,personal pe Where a.Id<>0 and a.IdCliente=cli.Id and a.IdProducto=p.Id and a.IdPer=pe.Id and a.Id=".intval($_POST['TxtNumero']);		
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$idpadre=$row['Id'];
		$nro=str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha=GLO_FormatoFecha($row['Fecha']);
		$fechav=GLO_FormatoFecha($row['FechaV']);
		$prod=GLO_textoFPDF(substr($row['Producto'],0,40));	
		$cli=GLO_textoFPDF(substr($row['Cliente'],0,45));
		$lote=GLO_textoFPDF($row['Lote']);
		$rto=GLO_textoFPDF($row['Rto']);
		$oc=GLO_textoFPDF($row['OC']);
		$obs1=GLO_textoFPDF($row['Obs1']);	
		$obs2=GLO_textoFPDF($row['Obs2']);	
		$anl=GLO_textoFPDF(substr($row['AA'].' '.$row['NA'],0,35));		
	}mysql_free_result($rs);	
	//pdf
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	//encabezado
	$pdf->Image($imagen,13,15,35);$pdf->Rect(10,10,190,22);
	$pdf->Line(50,10,50,32);$pdf->Line(160,10,160,32);$pdf->Line(50,22,200,22);$pdf->Line(105,22,105,32);
	$pdf->SetFont('Arial','B',10);$pdf->SetXY(50,15);$pdf->Cell(110,4,"CERTIFICADO DE ANALISIS",0,0,'C');
	$pdf->SetFont('Arial','',9);	
	//centro
	$pdf->SetXY(50,26);$pdf->Cell(55,4,'Revision: 4',0,0,'C');
	$pdf->SetXY(105,26);$pdf->Cell(55,4,'Fecha: 17-01-20',0,0,'C');
	//derecha
	$pdf->SetXY(160,15);$pdf->Cell(40,4,'RIT _17_01',0,0,'C');
	$pdf->Image('../CSS/Imagenes/cam.jpg',169,23,23);
	//nro 
	$pdf->Rect(10,36,190,32);$pdf->Line(10,41,200,41);
	$pdf->SetFont('Arial','B',9);$pdf->SetXY(10,37);$pdf->Cell(190,4,"Nro: ".$nro,0,0,'C');
	//datos
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY(10,43);$pdf->Cell(0,4,"Nombre del Producto: ".$prod,0,0,'L');	
	$pdf->SetXY(145,43);$pdf->Cell(0,4,"Fecha de Elaboracion: ".$fecha,0,0,'L');$pdf->Ln();
	$pdf->SetXY(10,48);$pdf->Cell(0,4,"Cliente: ".$cli,0,0,'L');
	$pdf->SetXY(145,48);$pdf->Cell(0,4,"Fecha de Vencimiento: ".$fechav,0,0,'L');$pdf->Ln();
	$pdf->SetXY(10,53);$pdf->Cell(0,4,"Analista de Laboratorio: ".$anl,0,0,'L');
	$pdf->SetXY(145,53);$pdf->Cell(0,4,"Lote: ".$lote,0,0,'L');$pdf->Ln();$pdf->Ln();	
	$pdf->SetXY(10,58);$pdf->Cell(0,4,"Remito: ".$rto,0,0,'L');$pdf->Ln();
	$pdf->SetXY(10,63);$pdf->Cell(0,4,"Orden de Compra: ".$oc,0,0,'L');
	/*	
	$pdf->SetXY(10,43);$pdf->Cell(0,4,"Fecha de Elaboracion: ".$fecha,0,0,'L');
	$pdf->SetXY(130,43);$pdf->Cell(0,4,"Fecha de Vencimiento: ".$fechav,0,0,'L');	$pdf->Ln();
	$pdf->SetXY(10,48);$pdf->Cell(0,4,"Nombre del Producto: ".$prod,0,0,'L');$pdf->Ln();
	$pdf->SetXY(10,53);$pdf->Cell(0,4,"Cliente: ".$cli,0,0,'L');$pdf->Ln();	
	$pdf->SetXY(10,58);$pdf->Cell(0,4,"Lote: ".$lote,0,0,'L');$pdf->Ln();
	$pdf->SetXY(10,63);$pdf->Cell(0,4,"Remito: ".$rto,0,0,'L');$pdf->Ln();
	$pdf->SetXY(10,68);$pdf->Cell(0,4,"Orden de Compra: ".$oc,0,0,'L');
	*/
	//items
	$pdf->SetXY(10,72);	$pdf->SetFont('Arial','',8);$y1=$pdf->GetY();$y1=$y1;
	$pdf->Cell(70,5,'Metodos de prueba',0,0,'L');$pdf->Cell(40,5,'Unidad',0,0,'L');$pdf->Cell(20,5,'Resultados',0,0,'R');
	$pdf->Cell(60,5,'Valor de Referencia',0,0,'L');
	$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);
	$pdf->SetFont('Arial','',7);
	$query="SELECT i.*,m.Nombre as Metodo, u.Nombre as Unidad From cam_items i,metodos m,metodosunidades u where i.IdMetodo=m.Id and i.IdUnidad=u.Id and i.IdPadre=$idpadre Order by m.Nombre"; 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$pdf->Cell(70,5,GLO_textoFPDF(substr($row['Metodo'],0,20)),0,0,'L');
		$pdf->Cell(40,5,GLO_textoFPDF(substr($row['Unidad'],0,20)),0,0,'L');
		$pdf->Cell(20,5,$row['Res'],0,0,'R');
		$pdf->Cell(60,5,GLO_textoFPDF(substr($row['Val'],0,20)),0,0,'L');$pdf->Ln();	
	}mysql_free_result($rs);
	$y2=$pdf->GetY();$y2=$y2-$y1;
	$pdf->Rect(10,$y1,190,$y2);	
	$pdf->Ln(7);
	//observaciones
	$pdf->SetFont('Arial','BU',8);$pdf->Cell(0,5,'Equipos y reactivos utilizados para la determinacion:',0,0,'L');$pdf->Ln();
	$pdf->SetFont('Arial','',8);$pdf->SetX(10);$pdf->MultiCell(190,3,$obs1,0,'J',0,5);$pdf->Ln(7);
	//observaciones
	$pdf->SetFont('Arial','BU',8);$pdf->Cell(0,5,'Observaciones:',0,0,'L');$pdf->Ln();
	$pdf->SetFont('Arial','',8);$pdf->SetX(10);$pdf->MultiCell(190,3,$obs2,0,'J',0,5);
	//cierro conx
	mysql_close($conn); 
	//fin	
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
}

?>