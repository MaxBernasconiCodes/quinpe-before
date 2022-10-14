<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("../FPDF/fpdf.php");include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

/*
30/4/22
Un pedido esta asociado solo a un camion+semi
Y a un conductor y un acompañante
Pero dejo como esta porque en un principio requerian mas de un camion, por si volvieran a la necesidad anterior 
*/

if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbCliente']) or empty($_POST['TxtFechaA']) or empty($_POST['CbTipo']) or empty($_POST['TxtNroEntidad']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$tipocambio=2;//update
		include("Includes/zDatos.php");  
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}

elseif (isset($_POST['CmdLinkRow'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$_SESSION['TxtLocPage']=0;//despacho
	header("Location:ModificarItem.php?id=".intval($_POST['TxtId'])."&Flag1=True");
}



elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	$ori=intval($_SESSION['TxtOriOPEDes']);//de dde viene
	$_SESSION['TxtOriOPEDes']='';//limpio
	//
	if($ori==0){header("Location:Consulta.php");}//despacho consulta
	if($ori==1){header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	}//solicitud
}

//ver solicitud
elseif (isset($_POST['CmdVerSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtIdOriOPESoli']=intval($_POST['TxtNumero']);//id barrera para volver
	$_SESSION['TxtOriOPESoli']=4;//id etapa para volver
	header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}


//items 
elseif (isset($_POST['CmdAdd'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaItem.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFila'])){
	$query="Delete From despacho_it Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(31);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A2');	
}
elseif (isset($_POST['CmdAddIS'])){//tabla nueva items servicio
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaItemS.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaIS'])){//tabla nueva items servicio
	$query="Delete From despacho_it Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(31);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A3');	
}


//camiones propios 
elseif (isset($_POST['CmdAddVP'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);//id despacho
	//
	$nroId=GLO_generoID('despacho_p',$conn);
	$query="INSERT INTO despacho_p(Id,IdPadre,IdChofer,IdUnidad,IdSemi) VALUES ($nroId,$id,0,0,0)";
	$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}
elseif (isset($_POST['CmdBorrarFilaVP'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From despacho_p Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}
elseif (isset($_POST['CmdGrabaFilaVP'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$iditem=intval($_POST['TxtId']);
	$aLista=$_POST['CbPersonal'];$per=intval($aLista[$iditem]);//trae el valor de esa fila
	$aLista=$_POST['CbUnidad'];$uni=intval($aLista[$iditem]);
	$aLista=$_POST['CbUnidad2'];$uni2=intval($aLista[$iditem]);
	//dni requerido para controlar personas en interior base
	if($per==0){
		$_SESSION['GLO_msgE']='Por favor complete el CHOFER para grabar los datos';
	}else{
		//update
		$query="UPDATE despacho_p set IdChofer=$per,IdUnidad=$uni,IdSemi=$uni2 Where Id=$iditem";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	}
	//volver
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}


//camiones terceros 
elseif (isset($_POST['CmdAddVT'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);//id despacho
	//
	$nroId=GLO_generoID('despacho_t',$conn);
	$query="INSERT INTO despacho_t(Id,IdPadre,Chofer,DNI,Dominio,Dominio2) VALUES ($nroId,$id,'','','','')";
	$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}
elseif (isset($_POST['CmdBorrarFilaVT'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From despacho_t Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);	
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}
elseif (isset($_POST['CmdGrabaFilaVT'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$iditem=intval($_POST['TxtId']);
	$aLista=$_POST['TxtChofer'];$per=mysql_real_escape_string($aLista[$iditem]);//trae el valor de esa fila
	$aLista=$_POST['TxtDoc'];$dni=mysql_real_escape_string($aLista[$iditem]);
	$aLista=$_POST['TxtDominio'];$uni=mysql_real_escape_string($aLista[$iditem]);
	$aLista=$_POST['TxtDominio2'];$uni2=mysql_real_escape_string($aLista[$iditem]);	
	//dni requerido para controlar personas en interior base
	if(trim($dni)==''){
		$_SESSION['GLO_msgE']='Por favor complete el DNI para grabar los datos';
	}else{
		//traigo el ultimo registro de ese dni, busco datos chofer
		if($per==''){
			$query="SELECT * FROM procesosop_e1 Where DNI='$dni' and Chofer<>'' Order by Id desc LIMIT 1";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)!=0){$per= $row['Chofer'];}
		}
		//update
		$query="UPDATE despacho_t set Chofer='$per',DNI='$dni',Dominio='$uni',Dominio2='$uni2' Where Id=$iditem";
		$rs=mysql_query($query,$conn);if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	}
	//volver
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}


	

elseif (isset($_POST['CmdImprimir'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	imprimirpedido(intval($_POST['TxtNumero']),1,$conn);
}

elseif (isset($_POST['CmdImprimirB'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	imprimirpedido(intval($_POST['TxtNumero']),2,$conn);
}




function imprimirpedido($idpadre,$tipo,$conn){
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$_SESSION["NivelArbol"]);	
	//pdf
	$pdf=new FPDF('L','mm','A4');
	$pdf->AddPage();	
	//datos 
	$query="Select a.*,c.Nombre,t.Nombre as Tipo From despacho a,clientes c,despacho_tipo t  Where a.IdCliente=c.Id and t.Id=a.IdTipo and a.Id=$idpadre";
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$nro= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha=GLO_FormatoFecha($row['Fecha']);
		$loc=$row['Loc'];
		$obs=$row['Obs'];
		//encabezado
		if($tipo==1){$titulo="PEDIDO LOGISTICA";}else{$titulo="GUIA DE TRANSPORTE";}		
		include("../IncludesPDF/bannerL2.php");
		//cuadro
		$pdf->Rect(10,40,270,21);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(10,42);$pdf->Cell(0,3,"Cliente: ",0,0,'L');
		$pdf->SetXY(10,47);$pdf->Cell(0,3,"Solicitante: ",0,0,'L');
		$pdf->SetXY(10,52);$pdf->Cell(0,3,"Cliente final: ",0,0,'L');
		$pdf->SetXY(10,57);$pdf->Cell(0,3,"Accion: ",0,0,'L');
		//
		$pdf->SetXY(170,42);$pdf->Cell(0,3,"Medio: ",0,0,'L');
		$pdf->SetXY(170,47);$pdf->Cell(0,3,"Entrega: ",0,0,'L');
		$pdf->SetXY(170,52);$pdf->Cell(0,3,"Remito: ",0,0,'L');
		$pdf->SetXY(170,57);$pdf->Cell(0,3,"Solicitud: ",0,0,'L');
		//
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(35,42);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['Nombre'],0,30)),0,0,'L');
		$pdf->SetXY(35,47);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['Contacto'],0,30)),0,0,'L');
		$pdf->SetXY(35,52);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['CliFinal'],0,30)),0,0,'L');
		$pdf->SetXY(35,57);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['Tipo'],0,30)),0,0,'L');
		//
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY(195,42);$pdf->Cell(0,3,GLO_textoFPDF(substr(GLO_VerMedioRecepcion($row['Medio']),0,30)),0,0,'L');
		$pdf->SetXY(195,47);$pdf->Cell(0,3,GLO_FormatoFecha($row['FechaEP']).' '.GLO_FormatoHora($row['HoraEP'],0,0,'L'));
		$pdf->SetXY(195,52);$pdf->Cell(0,3,GLO_textoFPDF(substr($row['Rto'],0,30)),0,0,'L');
		$pdf->SetFont('Arial','B',12);$pdf->SetXY(195,57);$pdf->Cell(0,3,$row['IdPadre'],0,0,'L');$pdf->SetFont('Arial','',9);
	}mysql_free_result($rs);	


	//items
	$query="SELECT m.*,u.Abr as Uni ,i.Nombre as Item,e.Nombre as Env From despacho a,despacho_it m,items i,unidadesmedida u,envases e where a.Id=m.IdPadre and m.IdIC=i.Id and m.Id<>0 and m.IdU=u.Id and m.IdEnv=e.Id and m.IdPadre=$idpadre Order by i.Nombre";$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$y=$pdf->GetY();$y=$y+10;
		$pdf->SetXY(10,$y);	$pdf->SetFont('Arial','B',8);
		$pdf->Cell(110,5,'Producto Pedido',0,0,'L');$pdf->Cell(15,5,'Unidad',0,0,'L');$pdf->Cell(15,5,'Cantidad',0,0,'R');		
		$pdf->Cell(30,5,'Envase',0,0,'L');$pdf->Cell(25,5,'Lote',0,0,'L');$pdf->Cell(15,5,'Bultos',0,0,'R');
		$pdf->Cell(65,5,'Destino',0,0,'L');
		$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,280,$y);	
		$pdf->SetFont('Arial','',8);
		//
		while($row=mysql_fetch_array($rs)){
			$pdf->Cell(110,5,GLO_textoFPDF(substr($row['Item'],0,45)),0,0,'L');
			$pdf->Cell(15,5,GLO_textoFPDF(substr($row['Uni'],0,8)),0,0,'L');
			$pdf->Cell(15,5,$row['Cant'],0,0,'R');
			$pdf->Cell(30,5,GLO_textoFPDF(substr($row['Env'],0,10)),0,0,'L');
			$pdf->Cell(25,5,GLO_textoFPDF(substr($row['Lote'],0,10)),0,0,'L');	
			$pdf->Cell(15,5,$row['Bultos'],0,0,'R');	
			$pdf->Cell(65,5,GLO_textoFPDF(substr($row['Destino'],0,28)),0,0,'L');	
			$pdf->Ln();	
		}
	}mysql_free_result($rs);



	//camiones propios
	$query="SELECT d.* ,p.Documento,p.Nombre as N, p.Apellido as A,u1.Nombre as NU1,u1.Dominio as DU1,u2.Nombre as NU2,u2.Dominio as DU2 From despacho_p d,despacho a,personal p,unidades u1, unidades u2 where a.Id=d.IdPadre and d.IdChofer=p.Id and d.IdUnidad=u1.Id and d.IdSemi=u2.Id  and d.IdPadre=$idpadre Order by d.Id";$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$y=$pdf->GetY();$y=$y+5;
		$pdf->SetXY(10,$y);	$pdf->SetFont('Arial','B',8);
		$pdf->Cell(100,5,'Conductor camion Propio',0,0,'L');$pdf->Cell(20,5,'DNI',0,0,'L');
		$pdf->Cell(35,5,'Dominio Camion',0,0,'L');$pdf->Cell(35,5,'Dominio Semi',0,0,'L');
		$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
		$pdf->SetFont('Arial','',8);
		//
		while($row=mysql_fetch_array($rs)){
			$pdf->Cell(100,5,GLO_textoFPDF(substr($row['A'].' '.$row['N'],0,40)),0,0,'L');
			$pdf->Cell(20,5,GLO_textoFPDF(substr($row['Documento'],0,10)),0,0,'L');
			$pdf->Cell(35,5,GLO_textoFPDF(substr($row['NU1'].' '.$row['DU1'],0,12)),0,0,'L');
			$pdf->Cell(35,5,GLO_textoFPDF(substr($row['NU2'].' '.$row['DU2'],0,12)),0,0,'L');			
			$pdf->Ln();	
		}
	}mysql_free_result($rs);


	//camiones terceros
	$query="SELECT d.* From despacho_t d,despacho a where a.Id=d.IdPadre and d.IdPadre=$idpadre Order by d.Id";$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		$y=$pdf->GetY();$y=$y+5;
		$pdf->SetXY(10,$y);	$pdf->SetFont('Arial','B',8);
		$pdf->Cell(100,5,'Conductor camion Tercero',0,0,'L');$pdf->Cell(20,5,'DNI',0,0,'L');
		$pdf->Cell(35,5,'Dominio Camion',0,0,'L');$pdf->Cell(35,5,'Dominio Semi',0,0,'L');
		$pdf->Ln();$y=$pdf->GetY();$pdf->Line(10,$y,200,$y);	
		$pdf->SetFont('Arial','',8);
		//
		while($row=mysql_fetch_array($rs)){
			$pdf->Cell(100,5,GLO_textoFPDF(substr($row['Chofer'],0,40)),0,0,'L');
			$pdf->Cell(20,5,GLO_textoFPDF(substr($row['DNI'],0,10)),0,0,'L');
			$pdf->Cell(35,5,GLO_textoFPDF(substr($row['Dominio'],0,12)),0,0,'L');
			$pdf->Cell(35,5,GLO_textoFPDF(substr($row['Dominio2'],0,12)),0,0,'L');			
			$pdf->Ln();	
		}
	}mysql_free_result($rs);
	
	

	$pdf->Ln(10);

	//locaciones		
	if(trim($loc)!=''){
		$pdf->SetFont('Arial','BU',8);$pdf->Cell(0,5,'Locacion:',0,0,'L');$pdf->Ln();
		$pdf->SetFont('Arial','',8);$pdf->SetX(10);$pdf->MultiCell(270,3,GLO_textoFPDF($loc),0,'J',0,5);
		$pdf->Ln();	
	}

	//observaciones	
	if(trim($obs)!=''){
		$pdf->SetFont('Arial','BU',8);$pdf->Cell(0,5,'Observaciones:',0,0,'L');$pdf->Ln();
		$pdf->SetFont('Arial','',8);$pdf->SetX(10);$pdf->MultiCell(270,3,GLO_textoFPDF($obs),0,'J',0,5);
	}

	//cierro conx
	mysql_close($conn); 
	//pie
	$pdf->Ln(15);$y=$pdf->GetY();
	$pdf->Line(65,$y,110,$y);$pdf->Line(180,$y,225,$y);
	$pdf->SetFont('Arial','B',8);$pdf->Ln(1);$y=$pdf->GetY();	
	$pdf->SetXY(65,$y);$pdf->Cell(45,3,'Firma Solicitante',0,0,'C');
	$pdf->SetXY(180,$y);$pdf->Cell(45,3,'Firma Autorizante',0,0,'C');
	//fin	
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
}



?>


			

