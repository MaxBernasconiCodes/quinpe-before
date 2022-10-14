<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos
		if ( empty($_POST['TxtFecha']) or empty($_POST['TxtHora1']) or  empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$id=intval($_POST['TxtNumero']);
			if (empty($_POST['TxtFecha'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFecha']);}
			$hora1=$_POST['TxtHora1'];if($hora1==''){$hora1='00:00';}
			$obs=mysql_real_escape_string($_POST['TxtNombre']);	
			//query
			$query="UPDATE iso_minutas set Fecha='$fecha',Hora='$hora1',Nombre='$obs' Where Id=$id"; $rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
			mysql_close($conn); 			
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
		}//cierra 1.	
}//cierra cmd


//check realizada
elseif (isset($_POST['CmdConfFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$query="UPDATE iso_minutas_pd set Estado=1 Where Id=".intval($_POST['TxtId']);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaAsistente.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$query="Delete From iso_minutas_as Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}



elseif (isset($_POST['CmdAddD'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaDesarrollo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaD'])){
	$query="Delete From iso_minutas_des Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdAddP'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaPendiente.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaP'])){
	$query="Delete From iso_minutas_pd Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From iso_minutasarchivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From iso_minutasarchivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("iso_minutasarchivos",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}



elseif (isset($_POST['CmdExcel'])){
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro26_Minuta.xls");
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	$query="SELECT * From iso_minutas where Id<>0 and Id=$id"; $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$nro=str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		if($row['Fecha']!='0000-00-00'){$fecha =FormatoFecha($row['Fecha']);}else{$fecha='';}
		$hora1=date("H:i",strtotime($row['Hora'])); if ($hora1=='00:00'){$hora1="";}
		$tema=GLO_textoPHPExcel($row['Nombre']);
	}mysql_free_result($rs);	
	//exportar
	$rowex=5;
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowex, $fecha);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowex, $hora1);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$rowex, $nro);	$rowex=$rowex+3;	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, $tema);$rowex=$rowex+1;
	//asistentes
	$rowex=13;
	$query="SELECT m.*,s.Nombre as Sector,p.Nombre as Nom,p.Apellido as Ap From iso_minutas_as m,sector s,personal p where m.IdSector=s.Id and m.IdPersonal=p.Id and m.IdMin=$nro Order by m.Id";$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex+1, 1);//insertar fila
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowex.':D'.$rowex);
		if($row2['IdPersonal']==0){$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, GLO_textoPHPExcel($row2['Nombre']));}
		else{$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, GLO_textoPHPExcel($row2['Ap'].' '.$row2['Nom']));}
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowex, GLO_textoPHPExcel($row2['Sector']));
		$objPHPExcel->getActiveSheet()->getRowDimension($rowex)->setRowHeight(-1);//autosize fila
		$rowex=$rowex+1;
	}mysql_free_result($rs2);
	//desarrollo	
	$rowex=$rowex+4;$cont=0;
	$query="SELECT m.* From iso_minutas_des m where m.Id<>0 and m.IdMin=$nro Order by m.Id";$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex+1, 1);//insertar fila		
		$cont=$cont+1;$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, GLO_textoPHPExcel($cont.'.'.$row2['Obs']));
		$objPHPExcel->getActiveSheet()->getRowDimension($rowex)->setRowHeight(-1);//autosize fila
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowex.':G'.$rowex);
		$rowex=$rowex+1;
	}mysql_free_result($rs2);		
	//pendientes	
	$rowex=$rowex+5;$cont=0;
	$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From iso_minutas_pd m,personal p where m.Id<>0 and m.IdPersonal=p.Id and m.IdMin=$nro Order by m.Id";$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){ 
		if($row2['Estado']==0){$estado='Pendiente';}if($row2['Estado']==1){$estado='Realizada';}if($row2['Estado']==2){$estado='Cancelada';}
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex+1, 1);//insertar fila
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowex.':D'.$rowex);
		$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowex.':G'.$rowex);
		$cont=$cont+1;$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, GLO_textoPHPExcel($cont.'.'.$row2['Obs']));
		if($row2['IdPersonal']==0){$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowex, GLO_textoPHPExcel($row2['Nombre']));}
		else{$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowex, GLO_textoPHPExcel($row2['Ap'].' '.$row2['Nom']));}
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$rowex, GLO_textoPHPExcel($estado));
		$objPHPExcel->getActiveSheet()->getRowDimension($rowex)->setRowHeight(-1);//autosize fila
		$rowex=$rowex+1;
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