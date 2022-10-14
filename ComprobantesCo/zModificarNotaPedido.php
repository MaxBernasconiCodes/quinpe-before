<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");include("../FPDF/fpdf.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}




if (isset($_POST['CmdAceptar'])){
	if (  empty($_POST['TxtNombre']) or empty($_POST['CbSoli']) or empty($_POST['TxtFechaA']) or empty($_POST['CbAuto'])  or empty($_POST['CbPAuto']) or empty($_POST['CbSector']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fa="0000-00-00";}else{$fa=FechaMySql($_POST['TxtFechaA']);}
		$prio=intval($_POST['OptTipoP']);
		$soli=intval($_POST['CbSoli']); 
		$pauto=intval($_POST['CbPAuto']); 
		$auto=intval($_POST['CbAuto']); 
		$sec=intval($_POST['CbSector']); 		
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$pped=intval($_POST['CbPPED']); 
		$ctro=intval($_POST['CbCentro']); 
		$uni=intval($_POST['CbUnidad']); 		
		$p1=intval($_POST['CbPersonal']); 
		$eq=intval($_POST['CbInstrumento']); 
		$secm=intval($_POST['CbSector2']); 
		$id=intval($_POST['TxtNumero']);
		$query="UPDATE co_npedido set Fecha='$fa',Obs='$obs',IdPerSoli=$soli,IdPerPAuto=$pauto,IdPerAuto=$auto,IdSector=$sec,Prioridad=$prio,IdPuntoP=$pped,IdCentro=$ctro,IdUnidad=$uni,IdPersonal=$p1,Titulo='$nom',IdInstr=$eq,IdSectorM=$secm Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}

}


//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoNP.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From co_npedido_archivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From co_npedido_archivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Comprobantes/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("co_npedido_archivos",intval($_POST['TxtId']),"Comprobantes/","Ruta");
}


elseif (isset($_POST['CmdAddI'])){
	header("Location:AltaItemNP.php?Id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From co_npedido_it Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}



elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
if(intval($_SESSION['GLO_IdLocationCONP'])==2){header("Location:NotasPedidoD.php");}
else{header("Location:NotasPedido.php");}
}


elseif (isset($_POST['CmdImprimir'])){
	$idpadre=intval($_POST['TxtNumero']);
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//pdf
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();	
	//datos 
	$query="Select np.*,p1.Nombre as NomS,p1.Apellido as ApeS,p2.Nombre as NomA,p2.Apellido as ApeA,p3.Nombre as NomPA,p3.Apellido as ApePA,s.Nombre as Sector,s1.Nombre as Centro,pp.Nombre as PPED,u.Dominio as Unidad,p4.Nombre as NomD,p4.Apellido as ApeD,sm.Nombre as SectorM,itr.Nombre as Equipo From co_npedido np, personal p1,personal p2,personal p3,sector s,servicios c,serviciostipo1 s1,puntospedido pp,unidades u,personal p4,sectorm sm,epparticulos itr Where np.IdPerSoli=p1.Id and np.IdPerAuto=p2.Id and np.IdPerPAuto=p3.Id and np.IdSector=s.Id and np.IdCentro=c.Id and c.IdTipo=s1.Id and np.IdPuntoP=pp.Id and np.IdUnidad=u.Id and np.IdPersonal=p4.Id and np.IdSectorM=sm.Id and np.IdInstr=itr.Id and np.Id=$idpadre";
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$prio='';if($row['Prioridad']==1){$prio='Alta';} if($row['Prioridad']==2){$prio='Media';}if($row['Prioridad']==3){$prio='Baja';}
		$obs=$row['Obs'];
		$nro= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha=GLO_FormatoFecha($row['Fecha']);
		include("Includes/zDestinoNP.php");
		//encabezado
		$titulo="NOTA DE PEDIDO";
		include("../IncludesPDF/banner.php");
		//cuadro
		$pdf->Rect(10,40,190,21);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(10,42);$pdf->Cell(0,3,"Solicitante: ",0,0,'L');
		$pdf->SetXY(10,47);$pdf->Cell(0,3,"Preautorizante: ",0,0,'L');
		$pdf->SetXY(10,52);$pdf->Cell(0,3,"Autorizante: ",0,0,'L');
		$pdf->SetXY(10,57);$pdf->Cell(0,3,"Sector: ",0,0,'L');
		//
		$pdf->SetXY(120,42);$pdf->Cell(0,3,"Punto Pedido: ",0,0,'L');
		$pdf->SetXY(120,47);$pdf->Cell(0,3,"Servicio: ",0,0,'L');
		$pdf->SetXY(120,52);$pdf->Cell(0,3,"Destino: ",0,0,'L');
		$pdf->SetXY(120,57);$pdf->Cell(0,3,"Prioridad: ",0,0,'L');
		//
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(35,42);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['ApeS'].' '.$row['NomS'],0,30)),0,0,'L');
		$pdf->SetXY(35,47);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['ApePA'].' '.$row['NomPA'],0,30)),0,0,'L');
		$pdf->SetXY(35,52);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['ApeA'].' '.$row['NomA'],0,30)),0,0,'L');
		$pdf->SetXY(35,57);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['Sector'],0,30)),0,0,'L');
		//
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(145,42);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['PPED'],0,30)),0,0,'L');
		$pdf->SetXY(145,47);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['Centro'],0,30)),0,0,'L');
		$pdf->SetXY(145,52);$pdf->Cell(0,3,GLO_textoFPDF(substr($destino,0,30)),0,0,'L');
		$pdf->SetXY(145,57);$pdf->Cell(0,3,$prio,0,0,'L');
	}mysql_free_result($rs);	
	//items
	$y=$pdf->GetY();$y=$y+10;
	$pdf->SetXY(10,$y);	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,5,'Cant.Auto',0,0,'R');$pdf->Cell(100,5,'Detalle',0,0,'L');$pdf->Cell(10,5,'',0,0,'L');$pdf->Cell(20,5,'Marca',0,0,'L');$pdf->Cell(25,5,'Modelo',0,0,'L');$pdf->Cell(20,5,'Proveedor',0,0,'L');
	$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
	$pdf->SetFont('Arial','',8);
	$query="SELECT npi.*,a.Nombre as Articulo,a.Modelo, m.Nombre as Marca,um.Abr,p.Apellido as Prov,e.Nombre as Estado,il.Nombre as Prod,u2.Abr as Abr2 From co_npedido_it npi,epparticulos a,unidadesmedida um,proveedores p,marcas m,co_npedido_est e,items il,unidadesmedida u2 where npi.Id<>0 and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and npi.IdProv=p.Id and a.IdMarca=m.Id and npi.IdEstado=e.Id and npi.IdItem=il.Id and il.IdUnidad=u2.Id and npi.IdNP=$idpadre Order by a.Nombre,il.Nombre";
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		//articulo,producto u observaciones
		$textoart=$row['Obs'];$abr='';
		if($row['IdArticulo']>0){$textoart=$row['Articulo'];$abr=$row['Abr'];}
		if($row['IdItem']>0){$textoart=$row['Prod'];$abr=$row['Abr2'];}
		$pdf->Cell(15,5,$row['CantAuto'],0,0,'R');
		$pdf->Cell(100,5,GLO_textoFPDF(substr($textoart,0,45)),0,0,'L');
		$pdf->Cell(10,5,GLO_textoFPDF(substr($abr,0,20)),0,0,'L');
		$pdf->Cell(20,5,GLO_textoFPDF(substr($row['Marca'],0,8)),0,0,'L');
		$pdf->Cell(25,5,GLO_textoFPDF(substr($row['Modelo'],0,10)),0,0,'L');
		$pdf->Cell(20,5,GLO_textoFPDF(substr($row['Prov'],0,8)),0,0,'L');
		$pdf->Ln();	
	}mysql_free_result($rs);	
	$pdf->Ln(10);
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






else{ //Click en combo
foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
header("Location:ModificarNotaPedido.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
}


?>


