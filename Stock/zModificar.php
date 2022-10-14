<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("../FPDF/fpdf.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){
	//grabar los datos en la tabla
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$fecha=FechaMySql($_POST['TxtFechaA']);
	$tipo=intval($_POST['CbTipo']);
	$tipo2=mysql_real_escape_string($_POST['TxtTipo']);
	$suc=intval($_POST['TxtSuc']);
	$nro=intval($_POST['TxtNro']);
	$obs=mysql_real_escape_string($_POST['TxtObs']);
	//remito egreso(4)
	if($tipo==4){
		$pers=intval($_POST['CbPersonal']);
		$uni=intval($_POST['CbUnidad']); 
		$eq=intval($_POST['CbInstrumento']); 
		$secm=intval($_POST['CbSector2']); 
		$nrooc=intval($_POST['TxtNroOC']);
	}else{$pers=0;$uni=0;$eq=0;$secm=0;$nrooc=0;}	
	//update
		$eq=intval($_POST['CbInstrumento']); 
	$query="UPDATE stockmov set Fecha='$fecha',Obs='$obs',Tipo='$tipo2',Suc=$suc,Nro=$nro,IdUnidad=$uni,IdPersonal=$pers,NroOC=$nrooc,IdInstr=$eq,IdSectorM=$secm Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	
}


elseif (isset($_POST['CmdAddD'])){
	header("Location:AltaItem.php?Id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST['CmdAddD2'])){//RI/AI
	header("Location:AltaItemRI.php?Id=".intval($_POST['TxtNumero']));
}


elseif (isset($_POST['CmdAddD4'])){//RE/AE
	header("Location:AltaItemRENP.php?Id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdBorrarFilaD'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtId']);
	$idtipo=intval($_POST['CbTipo']);
	$iddep=intval($_POST['CbDep']);
	$idcam=intval($_POST['TxtIdCAM']);
	$idcliprop=intval($_POST['CbCliente']);//propietario
	include("Includes/zBajaMovStock.php");
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdImprimir'])){
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//datos
	$query="SELECT s.*,d.Nombre as Deposito,t.Nombre as TipoM,p.Apellido as Proveedor,u.Dominio as Unidad,pe.Nombre as NomP,pe.Apellido as ApeP  From stockmov s,depositos d,stock_tipomov t,proveedores p,unidades u,personal pe  where s.IdDeposito=d.Id and s.IdTipoMov=t.Id and s.IdProveedor=p.Id  and s.IdUnidad=u.Id and s.IdPersonal=pe.Id  and s.Id=".intval($_POST['TxtNumero']);	
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$idpadre=$row['Id'];
		$nro="";if($row['Suc']>0 or $row['Nro']>0){$nro=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);}	
		if($row['Fecha']!='0000-00-00'){$fecha =FormatoFecha( $row['Fecha']);}else{$fecha='';}
		$pers=substr($row['ApeP'].' '.$row['NomP'],0,30);
		$dep=substr($row['Deposito'],0,20);
		$obs=$row['Obs'];		
	}mysql_free_result($rs);
	//pdf
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	//encabezado
	$titulo="REMITO EGRESO";
	include("../IncludesPDF/banner.php");
	//datos 
	$pdf->SetFont('Arial','',9);
	$pdf->Rect(10,40,190,8);
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(10,42);$pdf->Cell(0,4,"Retira: ",0,0,'L');	
	$pdf->SetXY(130,42);$pdf->Cell(0,4,"Deposito: ",0,0,'L');
	//
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY(25,42);$pdf->Cell(0,4,GLO_textoFPDF($pers),0,0,'L');	
	$pdf->SetXY(150,42);$pdf->Cell(0,4,GLO_textoFPDF($dep),0,0,'L');	
	//items
	$pdf->SetXY(10,53);	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,'Cantidad',0,0,'R');$pdf->Cell(105,5,'Detalle',0,0,'L');$pdf->Cell(30,5,'Marca',0,0,'L');$pdf->Cell(30,5,'Modelo',0,0,'L');
	$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);
	$pdf->SetFont('Arial','',7);
	//
	$query="SELECT s.*, a.Nombre,a.Modelo, m.Nombre as Marca,il.Nombre as Prod From stockmov_items s, epparticulos a,marcas m,items il where s.IdArticulo=a.Id and s.IdItem=il.Id and a.IdMarca=m.Id  and s.IdMov=$idpadre Order by a.Nombre";
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		//articulo,producto u observaciones
		if($row['IdArticulo']>0){$textoart=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Nombre'];}
		else{$textoart=str_pad($row['IdItem'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];}
		$pdf->Cell(15,5,$row['Cantidad'],0,0,'R');
		$pdf->Cell(105,5,GLO_textoFPDF(substr($textoart,0,55)),0,0,'L');
		$pdf->Cell(30,5,GLO_textoFPDF(substr($row['Marca'],0,15)),0,0,'L');
		$pdf->Cell(30,5,GLO_textoFPDF(substr($row['Modelo'],0,15)),0,0,'L');
		$pdf->Ln();	
	}mysql_free_result($rs);	
	$pdf->Ln(7);
	//observaciones
	if($obs!=''){
		$pdf->SetFont('Arial','BU',8);$pdf->Cell(0,5,'Observaciones:',0,0,'L');$pdf->Ln();
		$pdf->SetFont('Arial','',8);$pdf->SetX(10);$pdf->MultiCell(190,3,GLO_textoFPDF($obs),0,'J',0,5);
	}
	mysql_close($conn); 
	//pie
	$pdf->Ln(15);$y=$pdf->GetY();
	$pdf->Line(25,$y,70,$y);$pdf->Line(140,$y,185,$y);
	$pdf->SetFont('Arial','B',8);$pdf->Ln(1);$y=$pdf->GetY();
	$pdf->SetXY(25,$y);$pdf->Cell(45,3,'Firma Solicitante',0,0,'C');
	$pdf->SetXY(140,$y);$pdf->Cell(45,3,'Firma Autorizante',0,0,'C');
	//fin	
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
}


elseif ( isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	if(intval($_SESSION['TxtOriStock'])==0){header("Location:../Stock.php");}else{header("Location:../StockD.php");}
}




?>