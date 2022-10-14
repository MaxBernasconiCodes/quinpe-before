<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['CbSector']) or empty($_POST['TxtFechaA']) or empty($_POST['TxtHora']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;	}		
	    GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include ("Includes/zDatos.php");
		//update
		$query="Update incidentes Set IdPersonal=$per,Fecha='$fa',Hora='$hora',IdSector=$sec,IdYac=$yac,C1=$c1,C2=$c2,C3=$c3,C4=$c4,C5=$c5,Obs='$obs',Tipo1=$t1,Tipo2=$t2,Obs1='$obs1',Obs2='$obs2',Obs3='$obs3',Obs4='$obs4',IdE=$est Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
	}
}



//archivos
elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From incidentesarchivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From incidentesarchivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("incidentesarchivos",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}


//involucrados
elseif (isset($_POST['CmdAddP'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaP.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaP'])){
	$query="Delete From incidentes_per Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


//medidas
elseif (isset($_POST['CmdAddM'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaM.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaM'])){
	$query="Delete From incidentes_med Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}




elseif (isset($_POST['CmdI1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Modificar1.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");		
}
elseif (isset($_POST['CmdI2'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Modificar2.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");		
}


elseif (isset($_POST['CmdExcel'])){
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro29_NotifIncid.xls");
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$query="Select a.*,s.Nombre as Sector,p2.Nombre as Nom2,p2.Apellido as Ap2,f.Nombre as Funcion,y.Nombre as Yac From incidentes a,sector s,personal p2,funcion f,yacimientos y Where a.Id<>0 and a.IdSector=s.Id and a.IdPersonal=p2.Id and a.IdYac=y.Id and p2.IdFuncion=f.Id and a.Id=$id"; $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$fecha=$row['Fecha'];
		if($row['C1']==1){$c1='X';}else{$c1='';};
		if($row['C2']==1){$c2='X';}else{$c2='';};
		if($row['C3']==1){$c3='X';}else{$c3='';};
		if($row['C4']==1){$c4='X';}else{$c4='';};	
		if($row['C5']==1){$c5='X';}else{$c5='';};	
		if($row['Tipo1']==1){$t1='X';}else{$t1='';};
		if($row['Tipo2']==1){$t2='X';}else{$t2='';};
		//encab
		$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Nro de Acontecimiento: '.str_pad($row['Id'], 6, "0", STR_PAD_LEFT));
		$objPHPExcel->getActiveSheet()->setCellValue('I6', 'Fecha: '.GLO_FormatoFecha($row['Fecha']));
		$objPHPExcel->getActiveSheet()->setCellValue('K6', 'Hora: '.GLO_FormatoHora($row['Hora']));
		$objPHPExcel->getActiveSheet()->setCellValue('G9', $t1);
		$objPHPExcel->getActiveSheet()->setCellValue('G11', $t2);
		//clasificacion
		$objPHPExcel->getActiveSheet()->setCellValue('C15', $c2);
		$objPHPExcel->getActiveSheet()->setCellValue('C17', $c1);
		$objPHPExcel->getActiveSheet()->setCellValue('C19', $c4);
		$objPHPExcel->getActiveSheet()->setCellValue('C21', $c5);
		$objPHPExcel->getActiveSheet()->setCellValue('C23', $c3);
		//
		$objPHPExcel->getActiveSheet()->setCellValue('F35', GLO_textoPHPExcel($row['Yac']));	
		$objPHPExcel->getActiveSheet()->setCellValue('C38', GLO_textoPHPExcel($row['Obs']));
		$objPHPExcel->getActiveSheet()->setCellValue('C26', GLO_textoPHPExcel($row['Ap2'].' '.$row['Nom2']));
		$objPHPExcel->getActiveSheet()->setCellValue('I26', GLO_textoPHPExcel($row['Funcion']));
		//
		$objPHPExcel->getActiveSheet()->setCellValue('C49', GLO_textoPHPExcel($row['Obs1']));
		$objPHPExcel->getActiveSheet()->setCellValue('C52', GLO_textoPHPExcel($row['Obs2']));
		$objPHPExcel->getActiveSheet()->setCellValue('C55', GLO_textoPHPExcel($row['Obs3']));
		$objPHPExcel->getActiveSheet()->setCellValue('C58', GLO_textoPHPExcel($row['Obs4']));
	}mysql_free_result($rs);
	//dias desde el ultimo incidente	
	$fechaultimo='';
	$query="SELECT Fecha From incidentes where DATEDIFF(Fecha,'".$fecha."')<=0 and Id<>$id Order by Fecha Desc";
	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$fechaultimo=$row2['Fecha'];}mysql_free_result($rs2);
	if($fechaultimo!=''){
		$diast=dias_transcurridos($fechaultimo,$fecha);
		$objPHPExcel->getActiveSheet()->setCellValue('F70', GLO_textoPHPExcel($diast));
	}
	//involucrados
	$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap,f.Nombre as Funcion From incidentes_per m,personal p,funcion f where m.IdPersonal=p.Id and p.IdFuncion=f.Id and m.IdP=$id Order by m.Id LIMIT 5";$rs2=mysql_query($query,$conn);
	$rowex=29;
	while($row2=mysql_fetch_array($rs2)){
		if($row2['IdPersonal']==0){$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowex, GLO_textoPHPExcel($row2['Nombre']));}
		else{$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowex, GLO_textoPHPExcel($row2['Ap'].' '.$row2['Nom']));}
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$rowex, GLO_textoPHPExcel($row2['Funcion']));
		$rowex++;
	}mysql_free_result($rs2);

	//medidas
	$query="SELECT m.*,p.Nombre as N,p.Apellido as A,p2.Nombre as N2,p2.Apellido as A2 From incidentes_med m,personal p,personal p2 where m.IdPersonal=p.Id and m.IdPersonal2=p2.Id and m.IdP=$id Order by m.Id LIMIT 8";$rs2=mysql_query($query,$conn);
	$rowex=61;
	while($row2=mysql_fetch_array($rs2)){
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowex, GLO_textoPHPExcel($row2['Obs']));
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$rowex, GLO_textoPHPExcel($row2['A'].' '.$row2['N']));
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$rowex, GLO_FormatoFecha($row2['Fecha1']));
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$rowex, GLO_textoPHPExcel($row2['A2'].' '.$row2['N2']));
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$rowex, GLO_FormatoFecha($row2['Fecha2']));
		$rowex++;
	}mysql_free_result($rs2);
	
	mysql_close($conn); 
	//ESTILO
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	//finalizo
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

?>