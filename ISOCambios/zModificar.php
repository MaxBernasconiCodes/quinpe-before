<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos
		if ( empty($_POST['TxtFecha']) or empty($_POST['CbPersonal']) or  empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include("Includes/zDatosU.php");			
			//query
			$query="UPDATE iso_cambios set Fecha='$fecha',Nombre='$nom',Razon='$raz',Req='$req',IdPersonal=$per,Estado=$est,Prio=$prio,Obs='$obs',FechaE='$fechae',Obs2='$obs2',FechaR='$fechar',Res=$res Where Id=$id"; $rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
			mysql_close($conn); 			
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
		}//cierra 1.	
}//cierra cmd



//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From iso_cambios_adj Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From iso_cambios_adj Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/SGI/'.$archivo) ;}
	mysql_close($conn); 	
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("iso_cambios_adj",intval($_POST['TxtId']),"SGI/","Ruta");
}




elseif (isset($_POST['CmdAddP'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaPendiente.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaP'])){
	$query="Delete From iso_cambios_plan Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}




elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaAsistente.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$query="Delete From iso_cambios_r1 Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}



elseif (isset($_POST['CmdAddT'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaTipo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaT'])){
	$query="Delete From iso_cambios_t1 Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


elseif (isset($_POST['CmdExcel'])){
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro28_Cambio.xls");
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);$idpadre=intval($_POST['TxtNumero']);
	$query="SELECT c.*,p.Nombre as Nom,p.Apellido as Ap From iso_cambios c,personal p where c.Id<>0 and c.IdPersonal=p.Id  and c.Id=$id"; $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$nro=str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$fecha = GLO_FormatoFecha($row['Fecha']);
		$fechae = GLO_FormatoFecha($row['FechaE']);
		$fechar = GLO_FormatoFecha($row['FechaR']);
		$tema=GLO_textoPHPExcel($row['Nombre']);
		$razon=GLO_textoPHPExcel($row['Razon']);
		$obs=GLO_textoPHPExcel($row['Obs']);//des cambio
		$obs2=GLO_textoPHPExcel($row['Obs2']);//des impactos
		$pers=GLO_textoPHPExcel($row['Ap'].' '.$row['Nom']);
		$estado=CAM_BuscaEstado($row['Estado']);
		$prio=CAM_BuscaPrioridad($row['Prio']);
		$resol=$row['Res'];
		$req=GLO_textoPHPExcel($row['Req']);
	}mysql_free_result($rs);
	//
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,17, GLO_textoPHPExcel('Dise&ntilde;o'));	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,9, GLO_textoPHPExcel('Obra/Servicio/Sector de Planta:'));
	//
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,7, $fecha);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,8, $pers);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,9, $tema);	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,10, $razon);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,7, $nro);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,8, $estado);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,9, $req);	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,10, $prio);
	//
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,12, $obs);
	//tipo cambio	
	$query="SELECT m.IdTipo From iso_cambios_t1 m,iso_cambios_tipo p where m.IdTipo=p.Id and m.IdPadre=$idpadre Order by m.Id";$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){ 
		if($row2['IdTipo']==1){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,15, 'X');}
		if($row2['IdTipo']==2){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,17, 'X');}
		if($row2['IdTipo']==3){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,19, 'X');}
		if($row2['IdTipo']==4){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,15, 'X');}
		if($row2['IdTipo']==5){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,17, 'X');}
		if($row2['IdTipo']==6){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,19, 'X');}
		if($row2['IdTipo']==7){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,15, 'X');}
		if($row2['IdTipo']==8){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,17, 'X');}
		if($row2['IdTipo']==9){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,19, 'X');}
	}mysql_free_result($rs2);	
	//
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,23, $fechae);	
	//integrantes
	$integr="";	
	$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From iso_cambios_r1 m,personal p where m.IdPersonal=p.Id and m.IdPadre=$idpadre Order by p.Apellido,p.Nombre ";$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){$integr=GLO_ListaTexto($integr,$row2['Ap'].' '.$row2['Nom']);}mysql_free_result($rs2);	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,23, GLO_textoPHPExcel($integr));	
	//
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,25, $obs2);
	if($resol==1){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,28, 'X');}
	if($resol==2){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,28, 'X');}
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,28, $fechar);
	//pendientes	
	$rowex=32;$cont=0;
	$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From iso_cambios_plan m,personal p where m.IdPersonal=p.Id and m.IdPadre=$idpadre Order by m.Id";$rs2=mysql_query($query,$conn);
	while($row2=mysql_fetch_array($rs2)){ 
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex+1, 1);//insertar fila
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowex.':J'.$rowex);
		$objPHPExcel->getActiveSheet()->mergeCells('K'.$rowex.':T'.$rowex);
		$objPHPExcel->getActiveSheet()->mergeCells('U'.$rowex.':AD'.$rowex);
		//
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowex, GLO_textoPHPExcel($row2['Obs']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowex, GLO_textoPHPExcel($row2['Ap'].' '.$row2['Nom']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowex, GLO_FormatoFecha($row2['Fecha']));
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




elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../ISO_Cambios.php");
}


?>