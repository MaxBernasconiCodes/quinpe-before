<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
		if ( empty($_POST['TxtFecha']) or empty($_POST['TxtCodigo']) or  empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$fecha=FechaMySql($_POST['TxtFecha']);
			$cod=mysql_real_escape_string($_POST['TxtCodigo']);	
			$obs=mysql_real_escape_string($_POST['TxtNombre']);	
			$sec=intval($_POST['CbSector']);	
			$id=intval($_POST['TxtNumero']);
			//query
			$query="UPDATE plan set Fecha='$fecha',Codigo='$cod',IdSector=$sec,Nombre='$obs' Where Id=$id"; $rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);PL_Auditoria(2,$id,$conn);}else{GLO_feedback(2);} 
			mysql_close($conn); 			
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
		}	
}

elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaAsistente.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$query="Delete From plan_part Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);PL_Auditoria(2,intval($_POST['TxtNumero']),$conn);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

elseif (isset($_POST['CmdTareas'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Tareas.php?Id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdHistorial'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Historial.php?Id=".intval($_POST['TxtNumero']));
}

elseif (isset($_POST['CmdExcel'])){
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro30_PlanA.xls");
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$id=intval($_POST['TxtNumero']);
	//Datos
	$objPHPExcel->setActiveSheetIndex(0);
	//Plan
	$query="Select m.*,s.Nombre as Sector From plan m,sector s Where m.Id<>0 and m.IdSector=s.Id and m.Id=$id"; 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$objPHPExcel->getActiveSheet()->setCellValue('C3', GLO_FormatoFecha($row['Fecha']));
		$objPHPExcel->getActiveSheet()->setCellValue('C4', GLO_textoPHPExcel($row['Codigo']));
		$objPHPExcel->getActiveSheet()->setCellValue('C5', GLO_textoPHPExcel($row['Sector']));
		$objPHPExcel->getActiveSheet()->setCellValue('C6', GLO_textoPHPExcel($row['Nombre']));
	}mysql_free_result($rs);	
	//Participantes
	$rowex=9;
	$query="SELECT m.* From plan_part m where m.IdP=$id Order by m.Nombre"; $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){		
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, GLO_textoPHPExcel($row['Nombre']));
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$rowex, GLO_textoPHPExcel($row['Empresa']));		
		$rowex++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex, 1);
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowex.':C'.$rowex);
	}mysql_free_result($rs);	
	//Tareas
	$objPHPExcel->setActiveSheetIndex(1);
	$rowex=4;$cont=1;
	$query="SELECT m.*,y.Nombre as Yac,e.Nombre as Estado From plan_t m,yacimientos y,plan_e e where m.IdYac=y.Id and m.IdEstado=e.Id and m.IdP=$id Order by m.Id"; $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){	
		$prio='';if($row['Prio']==1){$prio='Alta';} if($row['Prio']==2){$prio='Media';}if($row['Prio']==3){$prio='Baja';}	
		//resp
		$resp='';
		$query="SELECT s.Nombre as Sector From plan_tresp m,sector s where m.IdSector=s.Id and m.IdPT=".$row['Id']." Order by s.Nombre";
		$rs2=mysql_query($query,$conn);while($row2=mysql_fetch_array($rs2)){$resp=GLO_ListaTexto($resp,substr($row2['Sector'],0,4));}
		mysql_free_result($rs2);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, $cont);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowex, GLO_textoPHPExcel($row['Obs']));
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$rowex, GLO_textoPHPExcel($row['Nombre']));		
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowex, GLO_textoPHPExcel($row['Yac']));
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$rowex, GLO_textoPHPExcel($prio));
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$rowex, GLO_textoPHPExcel($resp));
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$rowex, GLO_FormatoFecha($row['F1']));
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$rowex, GLO_FormatoFecha($row['F2']));
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$rowex, GLO_FormatoFecha($row['F3']));
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$rowex, GLO_FormatoFecha($row['F4']));
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$rowex, GLO_textoPHPExcel($row['Estado']));	
		$rowex++;$cont++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex, 1);
	}mysql_free_result($rs);	
	//Historial
	$objPHPExcel->setActiveSheetIndex(2);
	$rowex=4;
	$query="SELECT a.*, ac.Nombre as Cambio, p.Nombre, p.Apellido From plan_audi a, auditoriaacciones ac, personal p where a.IdCambio=ac.Id and  a.IdPersonal=p.Id and a.IdPadre=$id Order by a.Id"; $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){		
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowex, GLO_FormatoFecha($row['Fecha']));
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowex, GLO_textoPHPExcel($row['Apellido'].' '.$row['Nombre']));		
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$rowex, GLO_textoPHPExcel($row['Cambio']));	
		$rowex++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($rowex, 1);
	}mysql_free_result($rs);	
	//desconecto
	mysql_close($conn); 
	//finalizo
	$objPHPExcel->setActiveSheetIndex(0);
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}

?>