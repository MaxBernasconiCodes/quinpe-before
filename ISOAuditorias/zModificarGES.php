<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST[CmdAceptar])){

		//verifica campos requeridos

		if ( empty($_POST['CbTipo']) or empty($_POST['CbSector']) or empty($_POST['TxtFechaA']) or empty($_POST['TxtNombre']) ){

			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		

			GLO_feedback(3);header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");

		}else{ 

			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

			include("Includes/zDatosU.php");

			$query="UPDATE iso_audi_prog set IdSector=$sec,IdTipo=$tipo,FechaProg='$fechaa',FechaReal='$fechab',Obs='$obs',IdEstado=$estado,IdYac=$yac,HoraReal='$hora',Duracion='$horad',Anulado=$anul,IdInstalacion=$inst,Dirigido='$diri',Obj='$obj',Alcance='$alc',IdCentro=$ctro,FechaRProg='$fecharp',Met='$met',Res='$res',Cri='$cri',Tipo=$tipoie,Nombre='$nom' Where Id=$id";

			$rs=mysql_query($query,$conn);

			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

			mysql_close($conn); 		

			//limpiar datos del form anterior

			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}

			header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");



		}		

}



//nc

elseif (isset($_POST['CmdVerH'])){

	header("Location:../ISONC/Ver.php?id=".intval($_POST['TxtId']));

}



//procesos

elseif (isset($_POST[CmdAddPro])){

	header("Location:AltaProceso.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));

}

elseif (isset($_POST[CmdBorrarFilaPro])){

	$query="Delete From iso_audi_procesos Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}





//archivos

elseif (isset($_POST[CmdAddA])){

	foreach($_POST as $key => $value){$_SESSION[$key] = "";}

	header("Location:ArchivoGES.php?Id=".intval($_POST['TxtNumero']));

}

elseif (isset($_POST[CmdBorrarFilaA])){

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);

	//busco path

	$query="SELECT Ruta From iso_audi_archivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);

	//elimino

	$query="Delete From iso_audi_archivos Where Id=$id";$rs=mysql_query($query,$conn);	

	if($rs){unlink('../Archivos/NC/'.$archivo) ;}

	mysql_close($conn); 	

	header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}

elseif (isset($_POST[CmdVerFile])){

	GLO_OpenFile("iso_audi_archivos",intval($_POST['TxtId']),"NC/","Ruta");

}





elseif (isset($_POST[CmdAddA1])){

	header("Location:AltaAuditor.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));

}



elseif (isset($_POST[CmdAddA2])){

	header("Location:AltaAuditado.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));

}



elseif (isset($_POST[CmdAddR])){

	header("Location:AltaReq.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));

}



elseif (isset($_POST[CmdBorrarFilaA1])){

	$query="Delete From iso_audi_auditores Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}





elseif (isset($_POST[CmdBorrarFilaA2])){

	$query="Delete From iso_audi_auditados Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}





elseif (isset($_POST[CmdBorrarFilaR])){

	$query="Delete From iso_audi_progreq Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}





elseif (isset($_POST[CmdCancelar])){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:../ISO_Auditorias.php");

}





elseif (isset($_POST[CmdImprimir])){

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

	$idpadre=intval($_POST['TxtNumero']);

	$query="Select a.*,s.Nombre as Sector,t.Nombre as Tipo,y.Nombre as Yac,i.Nombre as Inst,c.Nombre as Centro From iso_audi_prog a,yacimientos y,sector s,iso_audi_tipo t,instalaciones i,epparticulos c Where a.Idyac=y.Id and a.IdSector=s.Id and a.IdTipo=t.Id and a.IdInstalacion=i.Id and a.IdCentro=c.Id and a.Id=$idpadre Order by a.FechaProg";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

	if(mysql_num_rows($rs)!=0){	

		//exporto

		require_once '../PHPExcel/Classes/PHPExcel.php';

		$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro5_SGIFOR006.xls");

		//encabezado

		if($row['FechaProg']!='0000-00-00'){$fechap =FechaMesYear($row['FechaProg']);}else{$fechap='';}

		$hora=date("H:i",strtotime($row['HoraReal'])); if ($hora=='00:00'){$hora="";}

		$horad=date("H:i",strtotime($row['Duracion'])); if ($horad=='00:00'){$horad="";}

		//$objPHPExcel->getActiveSheet()->setCellValue('F6', str_pad($row['Id'], 6, "0", STR_PAD_LEFT));

		$objPHPExcel->getActiveSheet()->setCellValue('F7', $fechap);

		$objPHPExcel->getActiveSheet()->setCellValue('H7', $hora);

		$objPHPExcel->getActiveSheet()->setCellValue('J7', $horad);

		$objPHPExcel->getActiveSheet()->setCellValue('O6', GLO_textoPHPExcel($row['Centro']));

		$objPHPExcel->getActiveSheet()->setCellValue('N7', GLO_textoPHPExcel($row['Sector']));

		$objPHPExcel->getActiveSheet()->setCellValue('F8', GLO_textoPHPExcel($row['Dirigido']));

		$objPHPExcel->getActiveSheet()->setCellValue('C12', GLO_textoPHPExcel($row['Obj']));

		$objPHPExcel->getActiveSheet()->setCellValue('C15', GLO_textoPHPExcel($row['Alcance']));

		$objPHPExcel->getActiveSheet()->setCellValue('C105', GLO_textoPHPExcel($row['Obs']));

		//equipo auditor

		$query="SELECT c.*, f.Nombre,f.Apellido From iso_audi_auditores c, personal f where c.IdPersonal=f.Id and c.IdAudiProg=$idpadre Order by f.Apellido,f.Nombre";$rs2=mysql_query($query,$conn);

		$fila=18;

		while($row2=mysql_fetch_array($rs2)){

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, preg_replace('/[^a-zA-Z0-9[:space:]]/s',"",$row2['Apellido'].' '.$row2['Nombre']));

			$fila=$fila+1;

		}mysql_free_result($rs2);

		//auditados

		$query="SELECT c.*, f.Nombre,f.Apellido,f2.Nombre as Funcion From iso_audi_auditados c, personal f,funcion f2 where c.IdPersonal=f.Id and f.IdFuncion=f2.Id and c.IdAudiProg=$idpadre Order by f.Apellido,f.Nombre";$rs2=mysql_query($query,$conn);

		$fila=34;

		while($row2=mysql_fetch_array($rs2)){

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, preg_replace('/[^a-zA-Z0-9[:space:]]/s',"",$row2['Apellido'].' '.$row2['Nombre']));

			$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, preg_replace('/[^a-zA-Z0-9[:space:]]/s',"",$row2['Funcion']));

			$fila=$fila+1;

		}mysql_free_result($rs2);

		//NO CONFORMIDADES

		$query="SELECT c.*, f.Nombre,f.Nro,h.Nombre as TipoH From iso_audi_progreq c, iso_nc_req f,iso_audi_tipoh h where c.IdReq=f.Id and c.Tipo=h.Id and c.IdAudiP=$idpadre Order by f.Nro";$rs2=mysql_query($query,$conn);

		$fila=52;

		while($row2=mysql_fetch_array($rs2)){

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row2['Nro']);

			$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, preg_replace('/[^a-zA-Z0-9[:space:]]/s',"",$row2['Nombre']));

			$tipo='';if($row2['Tipo']==1){$tipo='P';}if($row2['Tipo']==2){$tipo='Q';}if($row2['Tipo']==3){$tipo='R';}

			if($row2['Tipo']==4){$tipo='S';}if($row2['Tipo']==5){$tipo='T';}

			if($tipo!=''){$objPHPExcel->getActiveSheet()->setCellValue($tipo.$fila, 'x');}

			$fila=$fila+1;

		}mysql_free_result($rs2);

		//finalizo

		include("../Codigo/ExcelHeader.php");	

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

		//exit;

	}mysql_free_result($rs);

	mysql_close($conn); 

	header("Location:ModificarGES.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}



?>





