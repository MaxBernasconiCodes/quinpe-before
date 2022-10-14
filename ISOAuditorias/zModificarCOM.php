<? 

include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(14);



if (isset($_POST[CmdAceptar])){

		//verifica campos requeridos

		if ( empty($_POST['CbTipo']) or empty($_POST['CbSector']) or empty($_POST['TxtFechaA']) or empty($_POST['TxtNombre']) ){

			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		

			GLO_feedback(3);header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");

		}else{ 

			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

			include("Includes/zDatosU.php");

			$query="UPDATE iso_audi_prog set IdSector=$sec,IdTipo=$tipo,FechaProg='$fechaa',FechaReal='$fechab',Obs='$obs',IdEstado=$estado,IdYac=$yac,HoraReal='$hora',Duracion='$horad',Anulado=$anul,IdInstalacion=$inst,Alcance='$alc',IdCentro=$ctro,FechaRProg='$fecharp',Met='$met',Res='$res',Cri='$cri',Tipo=$tipoie,Nombre='$nom' Where Id=$id";

			$rs=mysql_query($query,$conn);

			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

			mysql_close($conn); 		

			//limpiar datos del form anterior

			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}

			header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");



		}		

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

	header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}





//archivos

elseif (isset($_POST[CmdAddA])){

	foreach($_POST as $key => $value){$_SESSION[$key] = "";}

	header("Location:ArchivoCOM.php?Id=".intval($_POST['TxtNumero']));

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

	header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

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





elseif (isset($_POST[CmdAddD])){

	header("Location:AltaDesvio.php?Id=".intval($_POST['TxtNumero'])."&IdTipo=".intval($_POST['CbTipo']));

}





elseif (isset($_POST[CmdBorrarFilaA1])){

	$query="Delete From iso_audi_auditores Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}





elseif (isset($_POST[CmdBorrarFilaA2])){

	$query="Delete From iso_audi_auditados Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}



elseif (isset($_POST[CmdBorrarFilaD])){

	$query="Delete From iso_audi_progdes Where Id=".intval($_POST['TxtId']);

	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);

	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 

	mysql_close($conn); 

	header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

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

		// Create new PHPExcel object

		$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro4_SMAFOR019.xls");

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

		//equipo auditor

		$query="SELECT c.*, f.Nombre,f.Apellido From iso_audi_auditores c, personal f where c.IdPersonal=f.Id and c.IdAudiProg=$idpadre Order by f.Apellido,f.Nombre";$rs2=mysql_query($query,$conn);

		$fila=61;

		while($row2=mysql_fetch_array($rs2)){

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, preg_replace('/[^a-zA-Z0-9[:space:]]/s',"",$row2['Apellido'].' '.$row2['Nombre']));

			$fila=$fila+1;

		}mysql_free_result($rs2);

		//auditados

		$query="SELECT c.*, f.Nombre,f.Apellido,f2.Nombre as Funcion From iso_audi_auditados c, personal f,funcion f2 where c.IdPersonal=f.Id and f.IdFuncion=f2.Id and c.IdAudiProg=$idpadre Order by f.Apellido,f.Nombre";$rs2=mysql_query($query,$conn);

		$fila=77;

		while($row2=mysql_fetch_array($rs2)){

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, preg_replace('/[^a-zA-Z0-9[:space:]]/s',"",$row2['Apellido'].' '.$row2['Nombre']));

			$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, preg_replace('/[^a-zA-Z0-9[:space:]]/s',"",$row2['Funcion']));

			$fila=$fila+1;

		}mysql_free_result($rs2);

		//desvios

		$query="SELECT c.*, f.Nombre, f.Nro,f.Id as IdDesvio From iso_audi_progdes c, iso_audi_desvios f where c.IdDesvio=f.Id and c.IdAudiP=$idpadre Order by f.Nro";$rs2=mysql_query($query,$conn);

		$desvios='';$acciones=''; for ($i=1; $i <=29; $i=$i+1) {${"f".$i}=0;}//inicializo

		while($row2=mysql_fetch_array($rs2)){

			if($row2['Obs']!=''){$desvios=$desvios.$row2['Obs'].chr(10);}

			if($row2['Accion']!=''){$acciones=$acciones.$row2['Accion'].chr(10);}			

			$i=$row2['IdDesvio'];${"f".$i}=${"f".$i}+1;//sumo

		}mysql_free_result($rs2);

		//marco x

		if($f1>0){$objPHPExcel->getActiveSheet()->setCellValue('K17', $f1.'x');}

		if($f2>0){$objPHPExcel->getActiveSheet()->setCellValue('K18', $f2.'x');}

		if($f3>0){$objPHPExcel->getActiveSheet()->setCellValue('K19', $f3.'x');}

		if($f4>0){$objPHPExcel->getActiveSheet()->setCellValue('K20', $f4.'x');}

		if($f5>0){$objPHPExcel->getActiveSheet()->setCellValue('K22', $f5.'x');}

		if($f6>0){$objPHPExcel->getActiveSheet()->setCellValue('K23', $f6.'x');}

		if($f7>0){$objPHPExcel->getActiveSheet()->setCellValue('K24', $f7.'x');}

		if($f8>0){$objPHPExcel->getActiveSheet()->setCellValue('K25', $f8.'x');}

		if($f9>0){$objPHPExcel->getActiveSheet()->setCellValue('K26', $f9.'x');}

		if($f10>0){$objPHPExcel->getActiveSheet()->setCellValue('K27', $f10.'x');}

		if($f11>0){$objPHPExcel->getActiveSheet()->setCellValue('K28', $f11.'x');}

		if($f12>0){$objPHPExcel->getActiveSheet()->setCellValue('K29', $f12.'x');}

		if($f13>0){$objPHPExcel->getActiveSheet()->setCellValue('K30', $f13.'x');}

		if($f14>0){$objPHPExcel->getActiveSheet()->setCellValue('K32', $f14.'x');}

		if($f15>0){$objPHPExcel->getActiveSheet()->setCellValue('K33', $f15.'x');}

		if($f16>0){$objPHPExcel->getActiveSheet()->setCellValue('K34', $f16.'x');}

		if($f17>0){$objPHPExcel->getActiveSheet()->setCellValue('K35', $f17.'x');}

		if($f18>0){$objPHPExcel->getActiveSheet()->setCellValue('K36', $f18.'x');}

		if($f19>0){$objPHPExcel->getActiveSheet()->setCellValue('K37', $f19.'x');}

		if($f20>0){$objPHPExcel->getActiveSheet()->setCellValue('K38', $f20.'x');}

		if($f21>0){$objPHPExcel->getActiveSheet()->setCellValue('K40', $f21.'x');}

		if($f22>0){$objPHPExcel->getActiveSheet()->setCellValue('K41', $f22.'x');}

		if($f23>0){$objPHPExcel->getActiveSheet()->setCellValue('K42', $f23.'x');}

		if($f24>0){$objPHPExcel->getActiveSheet()->setCellValue('K44', $f24.'x');}

		if($f25>0){$objPHPExcel->getActiveSheet()->setCellValue('K45', $f25.'x');}

		if($f26>0){$objPHPExcel->getActiveSheet()->setCellValue('K46', $f26.'x');}

		if($f27>0){$objPHPExcel->getActiveSheet()->setCellValue('K48', $f27.'x');}

		if($f28>0){$objPHPExcel->getActiveSheet()->setCellValue('K49', $f28.'x');}

		if($f29>0){$objPHPExcel->getActiveSheet()->setCellValue('K50', $f29.'x');}

		

		$objPHPExcel->getActiveSheet()->setCellValue('C54', GLO_textoPHPExcel($desvios));

		$objPHPExcel->getActiveSheet()->setCellValue('C56', GLO_textoPHPExcel($acciones));

		//finalizo

		include("../Codigo/ExcelHeader.php");	

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

		//exit;

	}mysql_free_result($rs);

	mysql_close($conn); 

	header("Location:ModificarCOM.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	

}



?>





