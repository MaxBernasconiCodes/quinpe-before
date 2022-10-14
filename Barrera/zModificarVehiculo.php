<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("Includes/zFuncionesCheck.php");include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);


//modificar propios y terceros vehiculo

if (isset($_POST['CmdAceptar'])){
	//unidad no es requerido porque registran a los que vienen en bici/caminando
	$requeridos=0;
	if ( empty($_POST['TxtFechaA']) or empty($_POST['TxtHora'])){$requeridos=1;}
	if ( $_POST['CbTipo']==1 and (empty($_POST['CbPersonal'])) ){$requeridos=2;}
	if ( $_POST['CbTipo']==2 and empty($_POST['CbProv']) and empty($_POST['CbCliente'])){$requeridos=3;	}
	//
	if ( $requeridos!=0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);
		if ( $requeridos==3){$_SESSION['GLO_msgE']="Por favor complete Cliente o Proveedor propietario del camion";}
		header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero']));
	}else{
		//tercrros
		if ( $_POST['CbTipo']==2 and intval($_POST['CbProv'])!=0 and intval($_POST['CbCliente'])!=0 ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
			$_SESSION['GLO_msgE']='Transportista puede ser Proveedor o Cliente, por favor seleccione uno solo';
			header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero']));
		}else{	
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$tipocambio=2;//update
			include ("Includes/zDatosVehiculo.php");
			mysql_close($conn); 
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
		}
	}
}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	$ori=intval($_SESSION['TxtOriOPEBar']);//de dde viene
	$_SESSION['TxtOriOPEBar']='';//limpio
	//
	if($ori==0){header("Location:Consulta.php");}//barrera consulta
	if($ori==1){header("Location:ModificarPD.php?id=".intval($_POST['TxtNroPedido'])."&Flag1=True");}//barrera pedido
	if($ori==2){header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	}//solicitud
}


//ver solicitud
elseif (isset($_POST['CmdVerSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}	
	$_SESSION['TxtIdOriOPESoli']=intval($_POST['TxtNumero']);//id barrera para volver
	$_SESSION['TxtOriOPESoli']=1;//id etapa para volver
	header("Location:../Procesos/Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}
//alta solicitud
elseif (isset($_POST['CmdAltaSoli'])){
	if ( intval($_POST['CbCliente2'])==0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
		$_SESSION['GLO_msgE']='Por favor complete el Cliente de la Solicitud';
		$_SESSION['GLO_Focus']='CbCliente2';
		header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero']));
}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$id=intval($_POST['TxtNumero']);//id procesosop_e1
		$fa=GLO_FechaMySql($_POST['TxtFechaA']);			
		$cli=intval($_POST['CbCliente2']);
		//inserto (estado 0 abierto)
		$nroId=GLO_generoID('procesosop',$conn);
		$query="INSERT INTO procesosop (Id,Fecha,IdCliente,Estado) VALUES ($nroId,'$fa',$cli,0)";
		$rs=mysql_query($query,$conn);
		if ($rs){
			GLO_feedback(1);
			//asocio proceso creado 
			$query="update procesosop_e1 set IdPadre=$nroId Where Id=$id";$rs=mysql_query($query,$conn);		
		}else{GLO_feedback(2);} 
		mysql_close($conn); 			
		header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
	}
}
elseif (isset($_POST['CmdBorrarSoli'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);//id procesosop_e1
	//desvinculo proceso creado 
	$query="update procesosop_e1 set IdPadre=0 Where Id=$id";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}



//buscar datos barrera
elseif (isset($_POST['CmdBuscarCH'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	$id=intval($_POST['TxtNumero']);//id		
	$doc=trim($_POST['TxtDoc']);
	//limpio
	$_SESSION['TxtChofer'] ='';
	$_SESSION['TxtSedronar'] = '';
	$_SESSION['ChkC1'] = '';$_SESSION['ChkC2'] = '';
	$_SESSION['TxtFechaC1'] ='';$_SESSION['TxtFechaC2'] ='';
	//
	if($doc!=''){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//traigo el ultimo registro de ese dni
		$query="SELECT * FROM procesosop_e1 Where DNI='$doc' and DNI<>'' and Id<>$id Order by Id desc LIMIT 1";$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
			$_SESSION['TxtChofer'] = $row['Chofer'];
			$_SESSION['TxtSedronar'] = $row['Sedro'];
			$_SESSION['ChkC1'] = $row['ChkC1'];$_SESSION['ChkC2'] = $row['ChkC2'];
			$_SESSION['TxtFechaC1'] =GLO_FormatoFecha($row['FC1']);$_SESSION['TxtFechaC2'] =GLO_FormatoFecha($row['FC2']);
		}else{GLO_feedback(27);}mysql_free_result($rs);
		mysql_close($conn); 
	}else{$_SESSION['GLO_msgE']='Ingrese un DNI a buscar';}
	header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdBuscarD1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	$dom=trim($_POST['TxtDominio']);
	//limpio
	$_SESSION['CbMarca'] = '';
	$_SESSION['CbCateg'] = '';
	$_SESSION['TxtModelo'] = '';
	$_SESSION['ChkU1'] = '';$_SESSION['ChkU2'] = '';$_SESSION['ChkU3'] = '';
	$_SESSION['TxtFechaU1'] ='';$_SESSION['TxtFechaU2'] ='';
	$_SESSION['TxtFechaU3'] ='';
	//
	if($dom!=''){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//traigo el ultimo registro de ese dominio
		$query="SELECT * FROM procesosop_e1 Where Dominio='$dom' and Dominio<>'' Order by Id desc LIMIT 1";
		$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
			$_SESSION['CbMarca'] = $row['IdMarca'];
			$_SESSION['CbCateg'] = $row['IdCateg'];
			$_SESSION['TxtModelo'] = $row['Modelo'];
			$_SESSION['ChkU1'] = $row['ChkU1'];$_SESSION['ChkU2'] = $row['ChkU2'];$_SESSION['ChkU3'] = $row['ChkU3'];
			$_SESSION['TxtFechaU1'] =GLO_FormatoFecha($row['FU1']);$_SESSION['TxtFechaU2'] =GLO_FormatoFecha($row['FU2']);
			$_SESSION['TxtFechaU3'] =GLO_FormatoFecha($row['FU3']);
		}else{GLO_feedback(27);	}mysql_free_result($rs);
		mysql_close($conn); 
	}else{$_SESSION['GLO_msgE']='Ingrese un Dominio a buscar';}
	header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdBuscarD2'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
	$dom2=trim($_POST['TxtDominio2']);
	//limpio
	$_SESSION['CbMarca2'] ='';
	$_SESSION['CbCateg2'] ='';
	$_SESSION['TxtModelo2'] = '';
	$_SESSION['ChkS1'] = '';$_SESSION['ChkS2'] = '';$_SESSION['ChkS3'] = '';
	$_SESSION['TxtFechaS1'] ='';$_SESSION['TxtFechaS2'] ='';$_SESSION['TxtFechaS3'] ='';
	//
	if($dom2!=''){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		//traigo el ultimo registro de ese dominio
		$query="SELECT * FROM procesosop_e1 Where Dominio2='$dom2' and Dominio2<>'' Order by Id desc LIMIT 1";$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){
			$_SESSION['CbMarca2'] = $row['IdMarca2'];
			$_SESSION['CbCateg2'] = $row['IdCateg2'];
			$_SESSION['TxtModelo2'] = $row['Modelo2'];
			$_SESSION['ChkS1'] = $row['ChkS1'];$_SESSION['ChkS2'] = $row['ChkS2'];$_SESSION['ChkS3'] = $row['ChkS3'];
			$_SESSION['TxtFechaS1'] =GLO_FormatoFecha($row['FS1']);$_SESSION['TxtFechaS2'] =GLO_FormatoFecha($row['FS2']);
			$_SESSION['TxtFechaS3'] =GLO_FormatoFecha($row['FS3']);
		}else{GLO_feedback(27);	}mysql_free_result($rs);
		mysql_close($conn);
	}else{$_SESSION['GLO_msgE']='Ingrese un Dominio a buscar';}
	header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero']));
}




//checklist
elseif (isset($_POST['CmdControlP'])){//propios
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarControlP.php?id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdControlT'])){//terceros
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarControlT.php?id=".intval($_POST['TxtNumero']));
}


//items 
elseif (isset($_POST['CmdAdd'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaItem.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFila'])){
	$query="Delete From procesosop_e1_it Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(31);} 
	mysql_close($conn); 
	header("Location:ModificarVehiculo.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');	
}


elseif ( isset($_POST['CmdAltaEgreso'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	$tipo=intval($_POST['CbTipo']);//1:propio, 2:terceros
	//paso session
	$_SESSION['CbTipo']=$_POST['CbTipo'];
	$_SESSION['CbEtapa']=2;//0:ingreso,1:salida (combo muestra+1)
	$_SESSION['CbTipo2']=2;//1:persona,2:vehiculo
	//propio
	if($tipo==1){
		$_SESSION['CbPersonal']=$_POST['CbPersonal'];
		header("Location:AltaVehiculoP.php");
	}else{//terceros
		$_SESSION['CbCliente']=$_POST['CbCliente'];
		$_SESSION['CbProv']=$_POST['CbProv'];
		$_SESSION['TxtDoc']=$_POST['TxtDoc'];
		header("Location:AltaVehiculoT.php");
	}
}




elseif (isset($_POST['CmdImprimirT'])){
	include("../FPDF/fpdf.php");
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//datos
	$query="SELECT a1.*,um1.Nombre as Marca1,um2.Nombre as Marca2,ca1.Nombre as Cat1,ca2.Nombre as Cat2 From procesosop_e1 a1,unidadesmarcas um1,unidadesmarcas um2,unidadescateg ca1,unidadescateg ca2 where a1.Id<>0 and a1.IdMarca=um1.Id and a1.IdMarca2=um2.Id and a1.IdCateg=ca1.Id and a1.IdCateg2=ca2.Id and a1.Id=".intval($_POST['TxtNumero']);		
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){		
		$nro=str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha=GLO_FormatoFecha($row['Fecha']);
		$hora=GLO_FormatoHora($row['Hora']);
		$remito=GLO_textoFPDF($row['Rto']);
		$motivo=GLO_textoFPDF(substr($row['Mot'],0,40));	
		if($row['Etapa']==0){$ingresa='X';$egresa='';}else{$ingresa='';$egresa='X';}//0:ingreso,1:salida		
		$sedirige='';
		$transporte='';
		//
		if($row['Chk1']==0){$certifsi='';$certifno='X';}else{$certifsi='X';$certifno='';}//Certificado de analisis
		if($row['Chk1']==0){$hojassi='';$hojasno='X';}else{$hojassi='X';$hojasno='';}//Hojas de seguridad de los productos
		//
		$marca1=GLO_textoFPDF(substr($row['Marca1'],0,10));
		$tipo1=GLO_textoFPDF(substr($row['Cat1'],0,10));
		$modelo1=GLO_textoFPDF(substr($row['Modelo'],0,10));
		$patente1=GLO_textoFPDF(substr($row['Dominio'],0,20));
		$marca2=GLO_textoFPDF(substr($row['Marca2'],0,10));
		$tipo2=GLO_textoFPDF(substr($row['Cat2'],0,10));
		$modelo2=GLO_textoFPDF(substr($row['Modelo2'],0,10));
		$patente2=GLO_textoFPDF(substr($row['Dominio2'],0,20));
		//Verif.Tecnica camion
		if($row['ChkU1']==0){$verif1si='';$verif1no='X';}else{$verif1si='X';$verif1no='';}
		$verif1vto=GLO_FormatoFecha($row['FU1']);
		//Verif.Tecnica semi
		if($row['ChkS1']==0){$verif2si='';$verif2no='X';}else{$verif2si='X';$verif2no='';}
		$verif2vto=GLO_FormatoFecha($row['FS1']);
		//seguro camion
		if($row['ChkU2']==0){$seguro1si='';$seguro1no='X';}else{$seguro1si='X';$seguro1no='';}
		$seguro1vto=GLO_FormatoFecha($row['FU2']);
		//seguro semi
		if($row['ChkS2']==0){$seguro2si='';$seguro2no='X';}else{$seguro2si='X';$seguro2no='';}
		$seguro2vto=GLO_FormatoFecha($row['FS2']);
		//ruta camion
		if($row['ChkU3']==0){$ruta1si='';$ruta1no='X';}else{$ruta1si='X';$ruta1no='';}
		$ruta1vto=GLO_FormatoFecha($row['FU3']);
		//ruta semi
		if($row['ChkS3']==0){$ruta2si='';$ruta2no='X';}else{$ruta2si='X';$ruta2no='';}
		$ruta2vto=GLO_FormatoFecha($row['FS3']);
		//
		$nombre=GLO_textoFPDF(substr($row['Chofer'],0,40));
		//Habilitacion Nacional de Transporte de Cargas Peligrosas
		if($row['ChkC1']==0){$hnt='';}else{$hnt='X';}
		$hntvto=GLO_FormatoFecha($row['FC1']);
		//Carnet Municipal Categoria
		if($row['ChkC2']==0){$cnc='';}else{$cnc='X';}
		$cncvto=GLO_FormatoFecha($row['FC2']);
		//sedronar
		$sedronar=GLO_textoFPDF(substr($row['Sedro'],0,40));
		$obs=GLO_textoFPDF(substr($row['Obs'],0,45));

		//planilla control
		//inicializo
		for ($i=1; $i < 7; $i= $i +1) {
			${'itemsi'.$i}='';${'itemno'.$i}='';${'itemnc'.$i}='';${'itemobs'.$i}='';
		}
		//completo
		$query="SELECT * From procesosop_e1_ct  where IdPadre=".intval($row['Id']); $rs2=mysql_query($query,$conn);
		while($row2=mysql_fetch_array($rs2)){
			if($row2['Valor']==1){${'itemsi'.$row2['Item']}='X';}
			if($row2['Valor']==2){${'itemno'.$row2['Item']}='X';}
			if($row2['Valor']==3){${'itemnc'.$row2['Item']}='X';}
			${'itemobs'.$row2['Item']}=GLO_textoFPDF(substr($row2['Obs'],0,40));					
		}mysql_free_result($rs2);		
	}mysql_free_result($rs);	


	//pdf
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	//encabezado
	$pdf->Image($imagen,13,15,35);$pdf->Rect(10,10,190,22);
	$pdf->Line(50,10,50,32);$pdf->Line(160,10,160,32);$pdf->Line(50,22,200,22);$pdf->Line(105,22,105,32);
	$pdf->SetFont('Arial','B',10);$pdf->SetXY(50,15);$pdf->Cell(110,4,"PERMISO DE ENTRADA DE CAMIONES DE TERCEROS",0,0,'C');
	$pdf->SetFont('Arial','',9);	
	//centro
	$pdf->SetXY(50,26);$pdf->Cell(55,4,'Revision: 1',0,0,'C');
	$pdf->SetXY(105,26);$pdf->Cell(55,4,'Fecha: 16-07-12',0,0,'C');
	//derecha
	$pdf->SetXY(160,15);$pdf->Cell(40,4,'RIT _01_05',0,0,'C');
	$pdf->Image('../CSS/Imagenes/cam.jpg',169,23,23);


	//cuadro1
	$x1=10;$x2=50;$x3=70;$x4=160;	
	$filas=3;$y1=37;$y2=43;$y3=49;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y1-1,$x2,$y3-1);$pdf->Line($x3,$y1-1,$x3,$y3-1);$pdf->Line($x4,$y1-1,$x4,$y3-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);$pdf->Line($x1,$y3-1,200,$y3-1);
	//datos
	$pdf->SetXY($x1,$y1);$pdf->Cell(0,4,"Fecha: ".$fecha,0,0,'L');
	$pdf->SetXY($x1,$y2);$pdf->Cell(0,4,"Hora: ".$hora,0,0,'L');
	$pdf->SetXY($x1,$y3);$pdf->Cell(0,4,"Motivo: ".$motivo,0,0,'L');
	//
	$pdf->SetXY($x2,$y1);$pdf->Cell(0,4,"Ingresa  ".$ingresa,0,0,'L');
	$pdf->SetXY($x2,$y2);$pdf->Cell(0,4,"Egresa  ".$egresa,0,0,'L');
	//
	$pdf->SetXY($x3,$y1);$pdf->Cell(0,4,"Se dirige a: ".$sedirige,0,0,'L');
	$pdf->SetXY($x3,$y2);$pdf->Cell(0,4,"Transporte: ".$transporte,0,0,'L');
	//
	$pdf->SetXY($x4,$y1);$pdf->Cell(0,4,"Nro: ".$nro,0,0,'L');
	$pdf->SetXY($x4,$y2);$pdf->Cell(0,4,"Remito: ".$remito,0,0,'L');


	//cuadro2
	$x1=10;$x2=65;$x3=85;$x4=105;$x5=160;$x6=180;
	$filas=1;$y1=58;$y2=64;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y1-1,$x2,$y2-1);$pdf->Line($x3,$y1-1,$x3,$y2-1);
	$pdf->Line($x4,$y1-1,$x4,$y2-1);$pdf->Line($x5,$y1-1,$x5,$y2-1);$pdf->Line($x6,$y1-1,$x6,$y2-1);
	//datos
	$pdf->SetXY($x1,$y1);$pdf->Cell(0,4,"Certificado de analisis",0,0,'L');
	$pdf->SetXY($x2,$y1);$pdf->Cell(0,4,"Si  ".$certifsi,0,0,'L');
	$pdf->SetXY($x3,$y1);$pdf->Cell(0,4,"No  ".$certifno,0,0,'L');
	$pdf->SetXY($x4,$y1);$pdf->Cell(0,4,"Hojas de seguridad de los productos",0,0,'L');
	$pdf->SetXY($x5,$y1);$pdf->Cell(0,4,"Si  ".$hojassi,0,0,'L');
	$pdf->SetXY($x6,$y1);$pdf->Cell(0,4,"No  ".$hojasno,0,0,'L');

	//cuadro3
	$x1=10;$x2=33;$x3=56;$x4=79;$x5=105;$x6=128;$x7=151;$x8=174;	
	$filas=3;$y1=67;$y2=73;$y3=79;$y4=85;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y2-1,$x2,$y4-1);$pdf->Line($x3,$y2-1,$x3,$y4-1);$pdf->Line($x4,$y2-1,$x4,$y4-1);
	$pdf->Line($x5,$y1-1,$x5,$y4-1);$pdf->Line($x6,$y2-1,$x6,$y4-1);$pdf->Line($x7,$y2-1,$x7,$y4-1);
	$pdf->Line($x8,$y2-1,$x8,$y4-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);$pdf->Line($x1,$y3-1,200,$y3-1);
	//
	$pdf->SetXY($x1,$y1);$pdf->Cell(90,4,"Datos del camion",0,0,'C');
	$pdf->SetXY($x5,$y1);$pdf->Cell(90,4,"Datos del semirremolque",0,0,'C');
	//
	$pdf->SetXY($x1,$y2);$pdf->Cell(23,4,"Marca",0,0,'C');
	$pdf->SetXY($x2,$y2);$pdf->Cell(23,4,"Tipo ",0,0,'C');
	$pdf->SetXY($x3,$y2);$pdf->Cell(23,4,GLO_textoFPDF("Modelo/año"),0,0,'C');
	$pdf->SetXY($x4,$y2);$pdf->Cell(23,4,"Patente ",0,0,'C');
	//
	$pdf->SetXY($x5,$y2);$pdf->Cell(23,4,"Marca ",0,0,'C');
	$pdf->SetXY($x6,$y2);$pdf->Cell(23,4,"Tipo ",0,0,'C');
	$pdf->SetXY($x7,$y2);$pdf->Cell(23,4,GLO_textoFPDF("Modelo/año"),0,0,'C');
	$pdf->SetXY($x8,$y2);$pdf->Cell(23,4,"Patente ",0,0,'C');
	//
	$pdf->SetXY($x1,$y3);$pdf->Cell(0,4,$marca1,0,0,'L');
	$pdf->SetXY($x2,$y3);$pdf->Cell(0,4,$tipo1,0,0,'L');
	$pdf->SetXY($x3,$y3);$pdf->Cell(0,4,$modelo1,0,0,'L');
	$pdf->SetXY($x4,$y3);$pdf->Cell(0,4,$patente1,0,0,'L');
	//
	$pdf->SetXY($x5,$y3);$pdf->Cell(0,4,$marca2,0,0,'L');
	$pdf->SetXY($x6,$y3);$pdf->Cell(0,4,$tipo2,0,0,'L');
	$pdf->SetXY($x7,$y3);$pdf->Cell(0,4,$modelo2,0,0,'L');
	$pdf->SetXY($x8,$y3);$pdf->Cell(0,4,$patente2,0,0,'L');



	//cuadro5
	$x1=10;$x2=60;$x3=80;$x4=100;$x5=130;$x6=150;$x7=170;	
	$filas=5;$y1=88;$y2=94;$y3=100;$y4=106;$y5=112;$y6=118;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y1-1,$x2,$y6-1);$pdf->Line($x3,$y2-1,$x3,$y6-1);$pdf->Line($x4,$y1-1,$x4,$y6-1);
	$pdf->Line($x5,$y1-1,$x5,$y6-1);$pdf->Line($x6,$y2-1,$x6,$y6-1);$pdf->Line($x7,$y1-1,$x7,$y6-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);$pdf->Line($x1,$y3-1,200,$y3-1);
	$pdf->Line($x1,$y4-1,200,$y4-1);$pdf->Line($x1,$y5-1,200,$y5-1);
	//
	$pdf->SetXY($x1,$y2);$pdf->Cell(0,4,"Detalle",0,0,'L');
	$pdf->SetXY($x1,$y3);$pdf->Cell(0,4,"Verificacion tecnica",0,0,'L');
	$pdf->SetXY($x1,$y4);$pdf->Cell(0,4,"Seguro",0,0,'L');
	$pdf->SetXY($x1,$y5);$pdf->Cell(0,4,"R.U.T.A.",0,0,'L');
	//
	$pdf->SetXY($x2,$y1);$pdf->Cell(40,4,"Camion/Tractor",0,0,'C');
	$pdf->SetXY($x4,$y1);$pdf->Cell(30,4,"Vence el",0,0,'C');
	$pdf->SetXY($x5,$y1);$pdf->Cell(40,4,"Semirremolque",0,0,'C');
	$pdf->SetXY($x7,$y1);$pdf->Cell(30,4,"Vence el",0,0,'C');
	//
	$pdf->SetXY($x2,$y2);$pdf->Cell(20,4,"Si",0,0,'C');
	$pdf->SetXY($x3,$y2);$pdf->Cell(20,4,"No",0,0,'C');
	$pdf->SetXY($x5,$y2);$pdf->Cell(20,4,"Si",0,0,'C');
	$pdf->SetXY($x6,$y2);$pdf->Cell(20,4,"No",0,0,'C');
	//
	$pdf->SetXY($x2,$y3);$pdf->Cell(20,4,$verif1si,0,0,'C');
	$pdf->SetXY($x3,$y3);$pdf->Cell(20,4,$verif1no,0,0,'C');
	$pdf->SetXY($x4,$y3);$pdf->Cell(30,4,$verif1vto,0,0,'C');
	$pdf->SetXY($x5,$y3);$pdf->Cell(20,4,$verif2si,0,0,'C');
	$pdf->SetXY($x6,$y3);$pdf->Cell(20,4,$verif2no,0,0,'C');
	$pdf->SetXY($x7,$y3);$pdf->Cell(30,4,$verif2vto,0,0,'C');
	//
	$pdf->SetXY($x2,$y4);$pdf->Cell(20,4,$seguro1si,0,0,'C');
	$pdf->SetXY($x3,$y4);$pdf->Cell(20,4,$seguro1no,0,0,'C');
	$pdf->SetXY($x4,$y4);$pdf->Cell(30,4,$seguro1vto,0,0,'C');
	$pdf->SetXY($x5,$y4);$pdf->Cell(20,4,$seguro2si,0,0,'C');
	$pdf->SetXY($x6,$y4);$pdf->Cell(20,4,$seguro2no,0,0,'C');
	$pdf->SetXY($x7,$y4);$pdf->Cell(30,4,$seguro2vto,0,0,'C');
	//
	$pdf->SetXY($x2,$y5);$pdf->Cell(20,4,$ruta1si,0,0,'C');
	$pdf->SetXY($x3,$y5);$pdf->Cell(20,4,$ruta1no,0,0,'C');
	$pdf->SetXY($x4,$y5);$pdf->Cell(30,4,$ruta1vto,0,0,'C');
	$pdf->SetXY($x5,$y5);$pdf->Cell(20,4,$ruta2si,0,0,'C');
	$pdf->SetXY($x6,$y5);$pdf->Cell(20,4,$ruta2no,0,0,'C');
	$pdf->SetXY($x7,$y5);$pdf->Cell(30,4,$ruta2vto,0,0,'C');



	//cuadro6
	$x1=10;$x2=65;$x3=110;$x4=140;$x5=170;
	$filas=5;$y1=121;$y2=127;$y3=137;$y4=143;$y5=149;$y6=155;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,($filas*6)+4);
	//lineas verticales
	$pdf->Line($x2,$y2-1,$x2,$y4-1);$pdf->Line($x3,$y2-1,$x3,$y4-1);$pdf->Line($x4,$y2-1,$x4,$y4-1);
	$pdf->Line($x5,$y2-1,$x5,$y4-1);
	$pdf->Line($x3,$y4-1,$x3,$y6-1);//$pdf->Line($x2,$y5-1,$x2,$y6-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);$pdf->Line($x1,$y3-1,200,$y3-1);
	$pdf->Line($x1,$y4-1,200,$y4-1);$pdf->Line($x1,$y5-1,200,$y5-1);
	//
	$pdf->SetXY($x1,$y1);$pdf->Cell(200,4,"Datos del conductor",0,0,'C');
	//
	$pdf->SetXY($x1,$y2);$pdf->Cell(55,4,"Apellido y nombre",0,0,'C');
	$pdf->SetXY($x2,$y2);$pdf->Cell(45,4,"Habilitacion nacional",0,0,'C');
	$pdf->SetXY($x2,$y2+4);$pdf->Cell(45,4,"transporte cargas peligrosas",0,0,'C');
	$pdf->SetXY($x3,$y2);$pdf->Cell(30,4,"Vence el",0,0,'C');
	$pdf->SetXY($x4,$y2);$pdf->Cell(30,4,"Carnet municipal",0,0,'C');
	$pdf->SetXY($x4,$y2+4);$pdf->Cell(30,4,"categoria",0,0,'C');
	$pdf->SetXY($x5,$y2);$pdf->Cell(30,4,"Vence el",0,0,'C');
	//
	$pdf->SetXY($x1,$y4);$pdf->Cell(95,4,"Sedronar",0,0,'C');
	$pdf->SetXY($x3,$y4);$pdf->Cell(95,4,"Observaciones",0,0,'C');
	//
	$pdf->SetXY($x1,$y3);$pdf->Cell(0,4,$nombre,0,0,'L');
	$pdf->SetXY($x2,$y3);$pdf->Cell(45,4,$hnt,0,0,'C');
	$pdf->SetXY($x3,$y3);$pdf->Cell(30,4,$hntvto,0,0,'C');
	$pdf->SetXY($x4,$y3);$pdf->Cell(30,4,$cnc,0,0,'C');
	$pdf->SetXY($x5,$y3);$pdf->Cell(30,4,$cncvto,0,0,'C');
	//
	$pdf->SetXY($x1,$y5);$pdf->Cell(0,4,$sedronar,0,0,'L');
	//$pdf->SetXY($x2,$y5);$pdf->Cell(0,4,$sedronar2,0,0,'L');
	$pdf->SetXY($x3,$y5);$pdf->Cell(0,4,$obs,0,0,'L');

	
	//cuadro7 
	$x1=10;$x2=18;$x3=98;$x4=110;$x5=122;$x6=134;	
	$filas=8;$y1=158;$y2=164;$y3=170;$y4=176;$y5=182;$y6=190;$y7=196;$y8=202;$y9=210;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,($filas*6)+4);
	//lineas verticales
	$pdf->Line($x2,$y2-1,$x2,$y9-1);$pdf->Line($x3,$y1-1,$x3,$y9-1);$pdf->Line($x4,$y2-1,$x4,$y9-1);
	$pdf->Line($x5,$y2-1,$x5,$y9-1);$pdf->Line($x6,$y2-1,$x6,$y9-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);$pdf->Line($x1,$y3-1,200,$y3-1);$pdf->Line($x1,$y4-1,200,$y4-1);
	$pdf->Line($x1,$y5-1,200,$y5-1);$pdf->Line($x1,$y6-1,200,$y6-1);$pdf->Line($x1,$y7-1,200,$y7-1);
	$pdf->Line($x1,$y8-1,200,$y8-1);
	//
	$pdf->SetXY($x2,$y1);$pdf->Cell(75,4,"Entrega del producto",0,0,'C');
	$pdf->SetXY($x3,$y1);$pdf->Cell(95,4,"Inspeccion basica de la unidad",0,0,'C');
	//
	$pdf->SetXY($x1,$y2);$pdf->Cell(8,4,"Item",0,0,'C');
	$pdf->SetXY($x2,$y2);$pdf->Cell(70,4,"Detalle ",0,0,'C');
	$pdf->SetXY($x3,$y2);$pdf->Cell(12,4,"Bien/Si",0,0,'C');
	$pdf->SetXY($x4,$y2);$pdf->Cell(12,4,"Mal/No",0,0,'C');
	$pdf->SetXY($x5,$y2);$pdf->Cell(12,4,"N/C",0,0,'C');
	$pdf->SetXY($x6,$y2);$pdf->Cell(61,4,"Observaciones",0,0,'C');
	//
	$pdf->SetXY($x1,$y3);$pdf->Cell(8,4,"1",0,0,'C');
	$pdf->SetXY($x1,$y4);$pdf->Cell(8,4,"2",0,0,'C');
	$pdf->SetXY($x1,$y5);$pdf->Cell(8,4,"3",0,0,'C');
	$pdf->SetXY($x1,$y6);$pdf->Cell(8,4,"4",0,0,'C');
	$pdf->SetXY($x1,$y7);$pdf->Cell(8,4,"5",0,0,'C');
	$pdf->SetXY($x1,$y8);$pdf->Cell(8,4,"6",0,0,'C');
	//
	$pdf->SetXY($x2,$y3);$pdf->Cell(0,4,"Estado general de la carga",0,0,'L');
	$pdf->SetXY($x2,$y4);$pdf->Cell(0,4,GLO_textoFPDF("La señalizacion corresponde con la carga"),0,0,'L');
	$pdf->SetXY($x2,$y5);$pdf->Cell(0,4,"La carga esta bien protegida, tapas y/o valvulas",0,0,'L');
	$pdf->SetXY($x2,$y5+3);$pdf->Cell(0,4,"precintadas",0,0,'L');
	$pdf->SetXY($x2,$y6);$pdf->Cell(0,4,"La carga palletizada esta asegurada con fajas",0,0,'L');
	$pdf->SetXY($x2,$y7);$pdf->Cell(0,4,GLO_textoFPDF("La carga y la señalizacion coincide con el remito"),0,0,'L');
	$pdf->SetXY($x2,$y8);$pdf->Cell(0,4,"Estan los elementos de seguridad para actuar en caso",0,0,'L');
	$pdf->SetXY($x2,$y8+3);$pdf->Cell(0,4,"de un incidente",0,0,'L');
	//
	$pdf->SetXY($x3,$y3);$pdf->Cell(12,4,$itemsi1,0,0,'C');
	$pdf->SetXY($x3,$y4);$pdf->Cell(12,4,$itemsi2,0,0,'C');
	$pdf->SetXY($x3,$y5);$pdf->Cell(12,4,$itemsi3,0,0,'C');
	$pdf->SetXY($x3,$y6);$pdf->Cell(12,4,$itemsi4,0,0,'C');
	$pdf->SetXY($x3,$y7);$pdf->Cell(12,4,$itemsi5,0,0,'C');
	$pdf->SetXY($x3,$y8);$pdf->Cell(12,4,$itemsi6,0,0,'C');
	//
	$pdf->SetXY($x4,$y3);$pdf->Cell(12,4,$itemno1,0,0,'C');
	$pdf->SetXY($x4,$y4);$pdf->Cell(12,4,$itemno2,0,0,'C');
	$pdf->SetXY($x4,$y5);$pdf->Cell(12,4,$itemno3,0,0,'C');
	$pdf->SetXY($x4,$y6);$pdf->Cell(12,4,$itemno4,0,0,'C');
	$pdf->SetXY($x4,$y7);$pdf->Cell(12,4,$itemno5,0,0,'C');
	$pdf->SetXY($x4,$y8);$pdf->Cell(12,4,$itemno6,0,0,'C');
	//
	$pdf->SetXY($x5,$y3);$pdf->Cell(12,4,$itemnc1,0,0,'C');
	$pdf->SetXY($x5,$y4);$pdf->Cell(12,4,$itemnc2,0,0,'C');
	$pdf->SetXY($x5,$y5);$pdf->Cell(12,4,$itemnc3,0,0,'C');
	$pdf->SetXY($x5,$y6);$pdf->Cell(12,4,$itemnc4,0,0,'C');
	$pdf->SetXY($x5,$y7);$pdf->Cell(12,4,$itemnc5,0,0,'C');
	$pdf->SetXY($x5,$y8);$pdf->Cell(12,4,$itemnc6,0,0,'C');
	//
	$pdf->SetXY($x6,$y3);$pdf->Cell(0,4,$itemobs1,0,0,'L');
	$pdf->SetXY($x6,$y4);$pdf->Cell(0,4,$itemobs2,0,0,'L');
	$pdf->SetXY($x6,$y5);$pdf->Cell(0,4,$itemobs3,0,0,'L');
	$pdf->SetXY($x6,$y6);$pdf->Cell(0,4,$itemobs4,0,0,'L');
	$pdf->SetXY($x6,$y7);$pdf->Cell(0,4,$itemobs5,0,0,'L');
	$pdf->SetXY($x6,$y8);$pdf->Cell(0,4,$itemobs6,0,0,'L');


	//cuadro8
	$x1=10;$x2=73;$x3=137;	
	$filas=2;$y1=230;$y2=256;$y3=262;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,($filas*6)+20);
	//lineas verticales
	$pdf->Line($x2,$y1-1,$x2,$y3-1);$pdf->Line($x3,$y1-1,$x3,$y3-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);
	//
	$pdf->SetXY($x1,$y2);$pdf->Cell(63,4,"Firma del chofer",0,0,'C');
	$pdf->SetXY($x2,$y2);$pdf->Cell(65,4,"Firma asist gcia tec y admin",0,0,'C');
	$pdf->SetXY($x3,$y2);$pdf->Cell(63,4,"Firma gerencia",0,0,'C');


	//cierro conx
	mysql_close($conn); 
	//fin	
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
}


elseif (isset($_POST['CmdImprimirPI'])){//propios ingreso
	include("../FPDF/fpdf.php");
	$nivelarbol=$_SESSION["NivelArbol"];
	ObtenerLogoEmpresa($imagen,$nombref,$dir,$web,$nivelarbol);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	
	//datos
	$query="SELECT a1.*,p.Nombre as NCH,p.Apellido as ACH,p.Documento,u1.Dominio,u2.Dominio as Dominio2 From procesosop_e1 a1,personal p,unidades u1,unidades u2 where a1.Id<>0 and a1.IdChofer=p.Id and a1.IdUnidad=u1.Id and a1.IdSemi=u2.Id and a1.Id=".intval($_POST['TxtNumero']);		
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){		
		$nro=str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha=GLO_FormatoFecha($row['Fecha']);
		$hora=GLO_FormatoHora($row['Hora']);
		$remito=GLO_textoFPDF($row['Rto']);
		$motivo=GLO_textoFPDF(substr($row['Mot'],0,40));	
		//
		$estado1='';
		$estado2='';
		//
		$apellido=GLO_textoFPDF(substr($row['ACH'],0,45));
		$nombre=GLO_textoFPDF(substr($row['NCH'],0,45));
		//
		$dominio=GLO_textoFPDF(substr($row['Dominio'],0,30));
		$dominio2=GLO_textoFPDF(substr($row['Dominio2'],0,30));
		$km=$row['Km'];if ($km==0){$km="";}
		//
		$interno='';
		$interno2='';
		//
		$obs=GLO_textoFPDF(substr($row['Obs'],0,80));

		//planilla control
		//inicializo
		for ($i=1; $i < 70; $i= $i +1) {
			${'itemsi'.$i}='';${'itemno'.$i}='';${'itemnc'.$i}='';${'itemobs'.$i}='';
		}
		//completo
		$query="SELECT * From procesosop_e1_cp where IdPadre=".intval($row['Id']); $rs2=mysql_query($query,$conn);
		while($row2=mysql_fetch_array($rs2)){
			if($row2['Valor']==1){${'itemsi'.$row2['Item']}='X';}
			if($row2['Valor']==2){${'itemno'.$row2['Item']}='X';}
			if($row2['Valor']==3){${'itemnc'.$row2['Item']}='X';}
		}mysql_free_result($rs2);		

	}mysql_free_result($rs);	


	//pdf
	$pdf=new FPDF('P','mm','A4');
	$pdf->AddPage();
	//encabezado
	$pdf->Image($imagen,13,15,35);$pdf->Rect(10,10,190,22);
	$pdf->Line(50,10,50,32);$pdf->Line(160,10,160,32);$pdf->Line(50,22,200,22);$pdf->Line(105,22,105,32);
	$pdf->SetFont('Arial','B',10);$pdf->SetXY(50,15);$pdf->Cell(110,4,"PERMISO DE ENTRADA DE CAMIONES PROPIOS",0,0,'C');
	$pdf->SetFont('Arial','',9);	
	//centro
	$pdf->SetXY(50,26);$pdf->Cell(55,4,'Revision: 3',0,0,'C');
	$pdf->SetXY(105,26);$pdf->Cell(55,4,'Fecha: 27-05-19',0,0,'C');
	//derecha
	$pdf->SetXY(160,15);$pdf->Cell(40,4,'RIT _01_16',0,0,'C');
	$pdf->Image('../CSS/Imagenes/cam.jpg',169,23,23);


	//cuadro1
	$x1=10;$x2=50;$x3=70;$x4=160;	
	$filas=3;$y1=37;$y2=43;$y3=49;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y1-1,$x2,$y3-1);$pdf->Line($x4,$y1-1,$x4,$y3-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);$pdf->Line($x1,$y3-1,200,$y3-1);
	//datos
	$pdf->SetXY($x1,$y1);$pdf->Cell(0,4,"Fecha: ".$fecha,0,0,'L');
	$pdf->SetXY($x1,$y2);$pdf->Cell(0,4,"Hora: ".$hora,0,0,'L');
	$pdf->SetXY($x1,$y3);$pdf->Cell(0,4,"Estado de los bienes propiedad del cliente en locacion: ",0,0,'L');
	$pdf->SetXY($x1+100,$y3);$pdf->Cell(0,4,"Bien".$estado1,0,0,'L');
	$pdf->SetXY($x1+130,$y3);$pdf->Cell(0,4,"Mal/Observaciones".$estado2,0,0,'L');
	//
	$pdf->SetXY($x2,$y1);$pdf->Cell(0,4,"Motivo: ".$motivo,0,0,'L');
	$pdf->SetXY($x2,$y2);$pdf->Cell(0,4,"Destino: BASE QUINPE  ",0,0,'L');
	//
	$pdf->SetXY($x4,$y1);$pdf->Cell(0,4,"Nro: ".$nro,0,0,'L');
	$pdf->SetXY($x4,$y2);$pdf->Cell(0,4,"Remito: ".$remito,0,0,'L');


	//cuadro2
	$x1=10;$x2=105;
	$filas=2;$y1=58;$y2=64;$y3=70;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y2-1,$x2,$y3-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);
	//datos
	$pdf->SetXY($x1,$y1);$pdf->Cell(190,4,"Conductor",0,0,'C');
	$pdf->SetXY($x1,$y2);$pdf->Cell(0,4,"Apellido: ".$apellido,0,0,'L');
	$pdf->SetXY($x2,$y2);$pdf->Cell(0,4,"Nombre: ".$nombre,0,0,'L');


	//cuadro3
	$x1=10;$x2=75;$x3=140;
	$filas=2;$y1=73;$y2=79;$y3=85;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y2-1,$x2,$y3-1);$pdf->Line($x3,$y2-1,$x3,$y3-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);
	//datos
	$pdf->SetXY($x1,$y1);$pdf->Cell(190,4,"Camion",0,0,'C');
	$pdf->SetXY($x1,$y2);$pdf->Cell(0,4,"Dominio: ".$dominio,0,0,'L');
	$pdf->SetXY($x2,$y2);$pdf->Cell(0,4,"Interno: ".$interno,0,0,'L');
	$pdf->SetXY($x3,$y2);$pdf->Cell(0,4,"Km actual: ".$km,0,0,'L');


	//cuadro4
	$x1=10;$x2=75;$x3=140;
	$filas=2;$y1=88;$y2=94;$y3=100;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas verticales
	$pdf->Line($x2,$y2-1,$x2,$y3-1);$pdf->Line($x3,$y2-1,$x3,$y3-1);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);
	//datos
	$pdf->SetXY($x1,$y1);$pdf->Cell(190,4,"Semirremolque",0,0,'C');
	$pdf->SetXY($x1,$y2);$pdf->Cell(0,4,"Dominio: ".$dominio2,0,0,'L');
	$pdf->SetXY($x2,$y2);$pdf->Cell(0,4,"Interno: ".$interno2,0,0,'L');


	//cuadro5
	$x1=10;$x2=105;
	$filas=2;$y1=103;$y2=109;$y3=115;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas horizontales
	$pdf->Line($x1,$y2-1,200,$y2-1);
	//datos
	$pdf->SetXY($x1,$y1);$pdf->Cell(190,4,"Observaciones",0,0,'C');
	$pdf->SetXY($x1,$y2);$pdf->Cell(0,4,$obs,0,0,'L');
	
	
	//cuadro6
	$x1=10;$x2=15;$x3=58;$x4=63;$x5=68;	
	$x6=73;$x7=78;$x8=121;$x9=126;$x10=131;	
	$x11=136;$x12=141;$x13=185;$x14=190;$x15=195;
	$filas=24;$y1=118;
	//cuadro
	$pdf->Rect($x1,$y1-1,190,$filas*6);
	//lineas horizontales
	$y=$y1;
	for ($i=2; $i < 26; $i= $i +1) { 
		$y=$y+6; ${'y'.$i}=$y;	
		if($i<25){$pdf->Line($x1,$y-1,200,$y-1);}
	}	
	//lineas verticales
	$x=$x1;
	for ($i=2; $i < 16; $i= $i +1) { $x=${'x'.$i}; $pdf->Line($x,$y1-1,$x,$y25-1);}
	//titulos
	$pdf->SetXY($x3,$y1);$pdf->Cell(5,4,"Si",0,0,'C');
	$pdf->SetXY($x4,$y1);$pdf->Cell(5,4,"No",0,0,'C');
	$pdf->SetXY($x5,$y1);$pdf->Cell(5,4,"FR",0,0,'C');
	$pdf->SetXY($x8,$y1);$pdf->Cell(5,4,"Si",0,0,'C');
	$pdf->SetXY($x9,$y1);$pdf->Cell(5,4,"No",0,0,'C');
	$pdf->SetXY($x10,$y1);$pdf->Cell(5,4,"FR",0,0,'C');
	$pdf->SetXY($x13,$y1);$pdf->Cell(5,4,"Si",0,0,'C');
	$pdf->SetXY($x14,$y1);$pdf->Cell(5,4,"No",0,0,'C');
	$pdf->SetXY($x15,$y1);$pdf->Cell(5,4,"FR",0,0,'C');
	//datos
	for ($i=2; $i < 25; $i= $i +1) {		
		$y=${'y'.$i};
		//primer columna
		$i1=$i-1;
		$si=${'itemsi'.$i1};$no=${'itemno'.$i1};$nc=${'itemnc'.$i1};
		$pdf->SetXY($x1,$y);$pdf->Cell(0,4,$i1,0,0,'L');
		$pdf->SetXY($x2,$y);$pdf->Cell(0,4,GLO_textoFPDF(substr(BAR_checkpropios($i1),0,45)),0,0,'L');
		$pdf->SetXY($x3,$y);$pdf->Cell(5,4,$si,0,0,'C');
		$pdf->SetXY($x4,$y);$pdf->Cell(5,4,$no,0,0,'C');
		$pdf->SetXY($x5,$y);$pdf->Cell(5,4,$nc,0,0,'C');
		//segunda columna
		$i2=$i1+23;
		$si=${'itemsi'.$i2};$no=${'itemno'.$i2};$nc=${'itemnc'.$i2};
		$pdf->SetXY($x6,$y);$pdf->Cell(0,4,$i2,0,0,'L');
		$pdf->SetXY($x7,$y);$pdf->Cell(0,4,GLO_textoFPDF(substr(BAR_checkpropios($i2),0,45)),0,0,'L');
		$pdf->SetXY($x8,$y);$pdf->Cell(5,4,$si,0,0,'C');
		$pdf->SetXY($x9,$y);$pdf->Cell(5,4,$no,0,0,'C');
		$pdf->SetXY($x10,$y);$pdf->Cell(5,4,$nc,0,0,'C');
		//tercer columna
		$i3=$i1+46;
		$si=${'itemsi'.$i3};$no=${'itemno'.$i3};$nc=${'itemnc'.$i3};
		$pdf->SetXY($x11,$y);$pdf->Cell(0,4,$i3,0,0,'L');
		$pdf->SetXY($x12,$y);$pdf->Cell(0,4,GLO_textoFPDF(substr(BAR_checkpropios($i3),0,45)),0,0,'L');
		$pdf->SetXY($x13,$y);$pdf->Cell(5,4,$si,0,0,'C');
		$pdf->SetXY($x14,$y);$pdf->Cell(5,4,$no,0,0,'C');
		$pdf->SetXY($x15,$y);$pdf->Cell(5,4,$nc,0,0,'C');
	}

	

	//cierro conx
	mysql_close($conn); 
	//fin	
	$pdf->SetY(0);$pdf->SetDisplayMode('real');$pdf->Output();
}

?>