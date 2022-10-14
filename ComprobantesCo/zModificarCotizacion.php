<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("../FPDF/fpdf.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}




if (isset($_POST['CmdAceptar'])){ //prov o sugerido deben estar registrados, pero solo uno
	if ( empty($_POST['TxtFechaA']) or (empty($_POST['CbProv']) and empty($_POST['TxtObs2'])) or (!(empty($_POST['CbProv'])) and !(empty($_POST['TxtObs2'])))  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);
		if(empty($_POST['CbProv']) and empty($_POST['TxtObs2'])){$_SESSION['GLO_msgE']='Por favor registre Proveedor existente o sugerido';}
		if(!(empty($_POST['CbProv'])) and !(empty($_POST['TxtObs2']))){$_SESSION['GLO_msgE']='Por favor registre un solo Proveedor';}
		header("Location:ModificarCotizacion.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fa="0000-00-00";}else{$fa=FechaMySql($_POST['TxtFechaA']);}
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$est=intval($_POST['CbEstado']);		
		$id=intval($_POST['TxtNumero']);
		$query="UPDATE co_pcotiz set Fecha='$fa',IdEstado=$est,Obs='$obs' Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:ModificarCotizacion.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}

}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	if(intval($_SESSION['TxtOriCOCOT'])==0){header("Location:Cotizaciones.php");}else{header("Location:CotizacionesD.php");}
}


elseif (isset($_POST['CmdAddI'])){
	header("Location:AltaItemPC.php?Id=".intval($_POST['TxtNumero']));
}


elseif (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$iditem=intval($_POST['TxtId']);
	//eliminar item
	$query="Delete From co_pcotiz_it Where Id=$iditem";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarCotizacion.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}







elseif (isset($_POST['CmdImprimir'])){
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//datos
	$query="Select co.*,p.Apellido as Prov,e.Nombre as Estado From co_pcotiz co,proveedores p,co_pcotiz_est e Where co.IdProv=p.Id and  co.IdEstado=e.Id and co.Id=".intval($_POST['TxtNumero']);		
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$idpadre=$row['Id'];
		$nro=str_pad($row['Id'], 8, "0", STR_PAD_LEFT);
		$fecha =GLO_FormatoFecha($row['Fecha']);
		if($row['IdProv']==0){$prov=substr($row['Obs2'],0,50);}else{$prov=substr($row['Prov'],0,50);}
		$obs=$row['Obs'];		
	}mysql_free_result($rs);	
	//pdf
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	//encabezado
	$titulo="PEDIDO DE COTIZACION";
	include("../IncludesPDF/banner.php");
	//datos cotiz
	$pdf->SetFont('Arial','',9);
	$pdf->Rect(10,40,190,8);
	$pdf->SetFont('Arial','B',9);$pdf->SetXY(10,42);$pdf->Cell(0,4,"Comercio: ",0,0,'L');	
	$pdf->SetFont('Arial','',9);$pdf->SetXY(30,42);$pdf->Cell(0,4,GLO_textoFPDF($prov),0,0,'L');	
	//pedidos
	$pdf->SetXY(10,53);	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,'Nro.Pedido',0,0,'R');$pdf->Cell(20,5,'Cantidad',0,0,'R');
	$pdf->Cell(10,5,'',0,0,'L');$pdf->Cell(145,5,'Detalle',0,0,'L');
	$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);
	$pdf->SetFont('Arial','',7);
	$query="SELECT i.Id,np.Fecha,np.Id as IdNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,e.Nombre as Estado,a.Id as IdArticuloItem,a.Nombre as Articulo,um.Abr,u.Dominio as Unidad,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_pcotiz_it i,co_npedido_est e,epparticulos a,unidadesmedida um,unidades u,items il,unidadesmedida u2 Where i.IdItemNP=npi.Id and np.Id=npi.IdNP and e.Id=np.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and  np.IdUnidad=u.Id and npi.IdItem=il.Id and il.IdUnidad=u2.Id and i.IdPCotiz=$idpadre Order by a.Nombre,il.Nombre"; 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		//articulo,producto 
		$textoart='';$abr='';
		if($row['IdArticuloItem']>0){
			$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
		}else{
			if($row['IdProd']>0){$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];}
		}
		$pdf->Cell(15,5,str_pad($row['IdNP'], 6, "0", STR_PAD_LEFT),0,0,'R');
		$pdf->Cell(20,5,$row['CantAutoItem'],0,0,'R');
		$pdf->Cell(10,5,substr($abr,0,5),0,0,'L');
		$pdf->Cell(145,5,GLO_textoFPDF(substr($textoart,0,50)),0,0,'L');$pdf->Ln();	
	}mysql_free_result($rs);	
	$pdf->Ln(7);


	//observaciones
	if($obs!=''){
		$pdf->SetFont('Arial','BU',8);$pdf->Cell(0,5,'Observaciones:',0,0,'L');$pdf->Ln();
		$pdf->SetFont('Arial','',8);$pdf->SetX(10);$pdf->MultiCell(190,3,GLO_textoFPDF($obs),0,'J',0,5);
	}
	//cierro conx
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

?>


