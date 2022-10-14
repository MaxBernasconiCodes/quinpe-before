<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$idsoli=intval($_POST['TxtIdSoli']);
		$estorden=intval($_POST['TxtIdEstadoO']);
		$perspl=intval($_POST['CbPersonalPL']);
		$obspl=mysql_real_escape_string($_POST['TxtObsPL']);	
		$listo=intval($_POST['ChkListoPL']); 
		//
		if (empty($_POST['TxtFecha6'])){$fecha6="0000-00-00";}else{$fecha6=FechaMySql($_POST['TxtFecha6']);}
		$km=intval($_POST['TxtKm']); 
		$hs=floatval($_POST['TxtHs']); 
		//		
		$wq='';
		for ($i=1; $i < 19; $i= $i +1) {$opt='OptI'.$i;${'a'.$i}=intval($_POST[$opt]);}		
		for ($i=1; $i < 19; $i= $i +1) {$wq=$wq.",I".$i."=".${'a'.$i}."";}
		$id=intval($_POST['TxtNumero']);
		if($idsoli!=0 and $estorden!=7 and $estorden!=8 and $estorden!=9){//valido que tenga soli y no sea finalizada
			//actualizo
			$query="UPDATE pedidosrepord set FechaIT='$fecha6',Km=$km,Hs=$hs,IdPersonalPL=$perspl,ObsPL='$obspl',ListoPL=$listo".$wq." Where Id=$id";
			$rs=mysql_query($query,$conn);
			if ($rs){REP_updateestadoorden($conn,intval($_POST['TxtNroEntidad']),0);}
			else{GLO_feedback(2);} 
		}else{GLO_feedback(2);}//hack-orden sin solicitud, o finalizada sin accion
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:ModificarControl.php?Flag1=True&id=".intval($_POST['TxtNroEntidad']));
}



elseif (isset($_POST['CmdImprimir'])){
	include("../FPDF/fpdf.php");
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//imprime
	$idpadre=intval($_POST['TxtNroEntidad']);
	$query="SELECT r.*,u.Dominio,u.Modelo,m.Nombre as Marca,rt.Nombre as TipoS,p.Apellido as Ap,p.Nombre as Nom From pedidosrepord r,unidades u,pedidosrep pr,unidadesmarcas m,pedidosrep_tipo rt,personal p where r.Id<>0 and r.IdUnidad=u.Id and r.IdSoli=pr.Id and u.IdMarca=m.Id and pr.IdTipo=rt.Id and pr.IdPersonal=p.Id and r.Id=$idpadre";	
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$nro=str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha=GLO_FormatoFecha($row['Fecha']);
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
	$titulo="PLANILLA DE CONTROL ORDEN ".$nro;
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

	//checklist
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetFont('Arial','B',8);$pdf->SetX(10);$pdf->Cell(15,5,'Lista de control',0,0,'L');
	$pdf->SetFont('Arial','',8);$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
	//items	
	$pdf->Ln(2);$y=$pdf->GetY();

	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Motor',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Sistema: Direccion',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Admision',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Sistema: Hidraulico',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Tren delantero',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Sistema: Combustible',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Diferencia',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Chapa y pintura',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Enfriamiento',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Elementos de seguridad',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Frenos',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Interior',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Transmision',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Cubiertas',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Electrico',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Llantas',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln(5);$y=$pdf->GetY();
	$pdf->SetXY(10,$y);$pdf->Cell(0,4,'Sistema: Suspension',0,0,'L');$pdf->Rect(50,$y+1,3,3);
	$pdf->SetXY(145,$y);$pdf->Cell(0,4,'Auxilio',0,0,'L');$pdf->Rect(185,$y+1,3,3);
	$pdf->Ln();$y=$pdf->GetY();
	
	//tareas
	$pdf->Ln(8);$y=$pdf->GetY();$pdf->SetFont('Arial','B',8);
	$pdf->SetX(10);$pdf->Cell(0,5,'Hora Inicio',0,0,'L');
	$pdf->SetX(30);$pdf->Cell(0,5,'Hora Fin',0,0,'L');
	$pdf->SetX(50);$pdf->Cell(0,5,'Tareas',0,0,'L');
	$pdf->SetFont('Arial','',8);$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
	//renglones	
	$pdf->SetDrawColor(128,128,128);//rgb gris
	$pdf->Ln(8);$y=$pdf->GetY();$pdf->Line(10,$y,25,$y);$pdf->Line(30,$y,45,$y);$pdf->Line(50,$y,200,$y);
	$pdf->Ln(8);$y=$pdf->GetY();$pdf->Line(10,$y,25,$y);$pdf->Line(30,$y,45,$y);$pdf->Line(50,$y,200,$y);
	$pdf->Ln(8);$y=$pdf->GetY();$pdf->Line(10,$y,25,$y);$pdf->Line(30,$y,45,$y);$pdf->Line(50,$y,200,$y);
	$pdf->Ln(8);$y=$pdf->GetY();$pdf->Line(10,$y,25,$y);$pdf->Line(30,$y,45,$y);$pdf->Line(50,$y,200,$y);
	$pdf->Ln(8);$y=$pdf->GetY();$pdf->Line(10,$y,25,$y);$pdf->Line(30,$y,45,$y);$pdf->Line(50,$y,200,$y);
	
	
	//desconecto y termino
	mysql_close($conn); 
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
}


elseif ( isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:ModificarOrden.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


?>


