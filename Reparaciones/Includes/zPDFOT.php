<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//imprime
	$idpadre=intval($_POST['TxtNumero']);
	$query="SELECT r.*,u.Dominio,u.Modelo,m.Nombre as Marca,rt.Nombre as TipoS,p.Apellido as Ap,p.Nombre as Nom From pedidosrepord r,unidades u,pedidosrep pr,unidadesmarcas m,pedidosrep_tipo rt,personal p where r.Id<>0 and r.IdUnidad=u.Id and r.IdSoli=pr.Id and u.IdMarca=m.Id and pr.IdTipo=rt.Id and pr.IdPersonal=p.Id and r.Id=$idpadre";	
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$nro=str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha=GLO_FormatoFecha($row['Fecha']);
		$obs=GLO_textoFPDF($row['Obs']);
		//solicitud
		$soli=GLO_SinCeroSTRPAD($row['IdSoli'],6);
		$tipo=GLO_textoFPDF(substr($row['TipoS'],0,35));
		$soliper=GLO_textoFPDF(substr($row['Ap'].' '.$row['Nom'],0,35));
		//vehiculo
		$domi=GLO_textoFPDF($row['Dominio']);
		$modelo=GLO_textoFPDF(substr($row['Marca'].' '.$row['Modelo'],0,30));
	}mysql_free_result($rs);
	//pdf
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	$titulo="ORDEN DE TRABAJO";
	include("../IncludesPDF/banner.php");
	//datos cuadro 
	$pdf->Rect(10,36,190,18);
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(10,38);$pdf->Cell(0,3,"Solicitud: ",0,0,'L');
	$pdf->SetXY(10,43);$pdf->Cell(0,3,"Tipo: ",0,0,'L');
	$pdf->SetXY(10,48);$pdf->Cell(0,3,"Solicitante: ",0,0,'L');
	//
	$pdf->SetXY(120,38);$pdf->Cell(0,3,"Dominio: ",0,0,'L');
	$pdf->SetXY(120,43);$pdf->Cell(0,3,"Modelo: ",0,0,'L');
	$pdf->SetXY(120,48);$pdf->Cell(0,3," ",0,0,'L');
	//
	$pdf->SetFont('Arial','',9);
	$pdf->SetXY(30,38);$pdf->Cell(0,3,$soli,0,0,'L');
	$pdf->SetXY(30,43);$pdf->Cell(0,3,$tipo,0,0,'L');
	$pdf->SetXY(30,48);$pdf->Cell(0,3,$soliper,0,0,'L');
	//
	$pdf->SetXY(135,38);$pdf->Cell(0,3,$domi,0,0,'L');
	$pdf->SetXY(135,43);$pdf->Cell(0,3,$modelo,0,0,'L');
	$pdf->SetXY(135,48);$pdf->Cell(0,3,'',0,0,'L');
	$pdf->Ln(5);
	
	//requerimientos
	$query="SELECT rr.* From pedidosrepreqsoli rr,pedidosrep pr where rr.Id<>0 and rr.IdPR=pr.Id and pr.IdOrden=$idpadre Order by rr.Fecha,rr.Obs";$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){
		$pdf->Ln(5);$y=$pdf->GetY();$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',8);$pdf->SetX(10);$pdf->Cell(15,5,'Requerimientos',0,0,'L');
		$pdf->SetFont('Arial','',8);$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
		while($row=mysql_fetch_array($rs)){		
			$estado='Pdte';if($row['Estado']==1){$estado='Visto';} 
			$pdf->SetX(185);$pdf->Cell(0,4,GLO_textoFPDF($estado),0,0,'L');
			$pdf->SetX(10);$pdf->MultiCell(170,4,GLO_textoFPDF($row['Obs']),0,'L',0,4);
			$pdf->Ln(1);
		}
	}mysql_free_result($rs);
	//acciones
	$query="SELECT rr.*,c.Nombre as Cat,e.Nombre as Estado,l.Nombre as ClaseN,t.Nombre as TipoN From pedidosrepreq rr,pedidosrepreq_cat c,pedidosrepreq_est e,pedidosrepreq_clase l,pedidosrepreq_tipo t  where rr.Id<>0 and rr.IdCat=c.Id and rr.IdEstado=e.Id and rr.Clase=l.Id and rr.Tipo=t.Id and rr.IdPR=$idpadre Order by l.Nombre,c.Nombre";$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){
		$pdf->Ln(5);$y=$pdf->GetY();$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',8);$pdf->SetX(10);$pdf->Cell(15,5,'Acciones',0,0,'L');
		$pdf->SetFont('Arial','',8);$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
		while($row=mysql_fetch_array($rs)){		
			$pdf->SetX(160);$pdf->Cell(0,4,GLO_textoFPDF(substr($row['Estado'],0,22)),0,0,'L');
			$pdf->SetX(10);$pdf->MultiCell(150,4,GLO_textoFPDF($row['Obs']),0,'L',0,4);
			$pdf->Ln(1);
		}
	}mysql_free_result($rs);
	//tareas
	$query="SELECT r.*,p.Apellido,p.Nombre From pedidosrepreq_act r,personal p,pedidosrepreq a where r.Id<>0 and r.IdPersonal=p.Id and r.IdPRR=a.Id and a.IdPR=$idpadre Order by r.Fecha,r.Hora1";$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){
		$pdf->Ln(5);$y=$pdf->GetY();$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',8);$pdf->SetX(10);$pdf->Cell(15,5,'Tareas',0,0,'L');
		$pdf->SetFont('Arial','',8);$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
		while($row=mysql_fetch_array($rs)){		
			$pdf->SetX(160);$pdf->Cell(0,4,GLO_textoFPDF(substr($row['Apellido'].' '.$row['Nombre'],0,22)),0,0,'L');
			$pdf->SetX(10);$pdf->MultiCell(150,4,GLO_textoFPDF($row['Obs']),0,'L',0,4);
			$pdf->Ln(1);
		}
	}mysql_free_result($rs);
	//observaciones
	if($obs!=''){
		$pdf->Ln(5);$y=$pdf->GetY();$pdf->SetFont('Arial','B',8);$pdf->SetX(10);$pdf->Cell(15,5,'Comentarios',0,0,'L');
		$pdf->SetFont('Arial','',8);$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
		$pdf->SetX(10);$pdf->MultiCell(190,5,GLO_textoFPDF($obs),0,'J',0,5);
	}
	//desconecto y termino
	mysql_close($conn); 
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
	
?>