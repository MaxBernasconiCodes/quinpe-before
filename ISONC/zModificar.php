<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos
		if ((empty($_POST['TxtFecha'])) or empty($_POST['CbRespAccion1']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
			$_SESSION['GLO_msgE']='Por favor complete Fecha NC y Responsable Accion Correctiva';
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include("Includes/zDatosU.php");
			//query
			$query="UPDATE iso_nc set IdTipo=$tipo,IdCliente=$cli,FechaEmision='$fecha',IdSector=$sec,IdSector2=$sec2,IdSector3=$sec3,IdSector4=$sec4,Emisor=$resp,IdNorma=$norma1,IdNorma2=$norma2,IdNorma3=$norma3,IdRequisito=$req1,IdRequisito2=$req2,IdRequisito3=$req3,IdRequisito4=$req4,IdRequisito5=$req5,IdRequisito6=$req6,Descripcion='$des',DesAI='$desai',FechaAI='$fechaai', IdRespAI=$rai,Causa='$causa',IdParticipante1=$pcausa1,IdParticipante2=$pcausa2,IdParticipante3=$pcausa3,IdParticipante4=$pcausa4,IdParticipante5=$pcausa5,IdParticipante6=$pcausa6,OtrosP='$otrosp',OtrosPMail='$otrospm',Accion='$accion',IdResponsable1=$raccion1,IdResponsable2=$raccion2,IdResponsable3=$raccion3,IdResponsable4=$raccion4,IdResponsable5=$raccion5,IdResponsable6=$raccion6,OtrosR='$otrosr',OtrosRMail='$otrosrm',FechaPlazo='$fechapl',FechaCumpl='$fechacpl',IdVerificador=$verif,FechaPrevista='$fechap',FechaCierre='$fechac',Observaciones='$obs',IdNCNueva=$nueva,IdEstado=$estado,Aceptada=$acc,TipoH=$tipoh,RespDetExt='$respext'  Where Id=$id"; $rs=mysql_query($query,$conn);
			if ($rs){
				GLO_feedback(1);
				//inserto auditoria
				$nroId2=GLO_generoID("iso_nc_auditoria",$conn);
				$idncaudi=$id;$fechaaudit=FechaMySqlHora(date("d-m-Y H:i:s"));$user=$_SESSION["login"];
				$query="INSERT INTO iso_nc_auditoria (Id,IdNC,IdUsuario,IdCambio,Fecha) VALUES ($nroId2,$idncaudi,'$user',3,'$fechaaudit')";
				$rs=mysql_query($query,$conn);	
			
			
			}else{GLO_feedback(2); } 
			mysql_close($conn); 			
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
		}//cierra 1.	
}//cierra cmd



elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero'])."&Nro=".intval($_POST['TxtNumero']));
}



elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From iso_nc_archivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//ultimo id auditoria
	$query="SELECT Max(Id) as UId FROM iso_nc_auditoria";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){$nroId2=1;}else{$nroId2=$row['UId']+1;}mysql_free_result($rs);
	//inserto auditoria
	$idncaudi=$_POST['TxtNumero'];$fechaaudit=FechaMySqlHora(date("d-m-Y H:i:s"));$user=$_SESSION["login"];
	$query="INSERT INTO iso_nc_auditoria (Id,IdNC,IdUsuario,IdCambio,Fecha) VALUES ($nroId2,$idncaudi,'$user',4,'$fechaaudit')";
	$rs=mysql_query($query,$conn);	
	//elimino
	$query="Delete From iso_nc_archivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/NC/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");	
}


if (isset($_POST['CmdVerFile'])){	
	GLO_OpenFile("iso_nc_archivos",intval($_POST['TxtId']),"NC/","Ruta"); 
}


elseif (isset($_POST['CmdAuditoria'])){
	header("Location:Auditoria.php?Id=".intval($_POST['TxtNumero'])."&Nro=".intval($_POST['TxtNumero']));
}


elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../ISO_NC.php");
}

elseif (isset($_POST['CmdExcel'])){
	$idnc=intval($_POST['TxtNumero']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//
	$query="Select nc.*,c.Nombre as Cliente,s.Nombre as Sector,s2.Nombre as Sec2,s3.Nombre as Sec3,s4.Nombre as Sec4,n1.Nombre as Norma1,n2.Nombre as Norma2,n3.Nombre as Norma3,r1.Nombre as Req1,r2.Nombre as Req2,r3.Nombre as Req3,r4.Nombre as Req4,r5.Nombre as Req5,r6.Nombre as Req6,r1.Nro as NReq1,r2.Nro as NReq2,r3.Nro as NReq3,r4.Nro as NReq4,r5.Nro as NReq5,r6.Nro as NReq6,p2.Apellido as ApRD,p2.Nombre as NomRD,p1.Apellido as ApRAI,p1.Nombre as NomRAI,nc2.Id as NroNCNueva,t.Nombre as Tipo From iso_nc nc,clientes c,sector s,iso_nc_norma n1,iso_nc_norma n2,iso_nc_norma n3,iso_nc_req r1,iso_nc_req r2,iso_nc_req r3,iso_nc_req r4,iso_nc_req r5,iso_nc_req r6,personal p1,personal p2,sector s2,sector s3,sector s4,iso_nc nc2,iso_nc_tipo t Where  nc.IdCliente=c.Id and nc.IdSector=s.Id and nc.IdNorma=n1.Id and nc.IdNorma2=n2.Id and nc.IdNorma3=n3.Id and nc.IdRequisito=r1.Id and nc.IdRequisito2=r2.Id and nc.IdRequisito3=r3.Id and nc.IdRequisito4=r4.Id and nc.IdRequisito5=r5.Id and nc.IdRequisito6=r6.Id and p2.Id=nc.Emisor and nc.IdSector2=s2.Id and nc.IdSector3=s3.Id and nc.IdSector4=s4.Id and p1.Id=nc.IdRespAI and nc.IdNCNueva=nc2.Id and nc.IdTipo=t.Id and nc.Id=$idnc"; 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		//sector
		$sector='';
		if($row['IdSector']!=0) {$sector=$sector.$row['Sector'].', ';}
		if($row['IdSector2']!=0){$sector=$sector.$row['Sec2'].', ';}
		if($row['IdSector3']!=0){$sector=$sector.$row['Sec3'].', ';}
		if($row['IdSector4']!=0){$sector=$sector.$row['Sec4'];}
		$sec=GLO_textoPHPExcel($sector);
		//
		$nro=str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
		$tipo=$row['IdTipo'];
		$veri=$row['IdVerificador'];
		$origen=GLO_textoPHPExcel($row['Tipo']);
		$cli=GLO_textoPHPExcel($row['Cliente']);
		//emisor
		if($row['Emisor']!=0){$emi=GLO_textoPHPExcel($row['ApRD'].' '.$row['NomRD']);}
		if($row['RespDetExt']!=''){
			if($emi!=''){$emi=$emi.', ';}
			$emi=$emi.GLO_textoPHPExcel($row['RespDetExt']);
		}
		//
		$respai=GLO_textoPHPExcel($row['ApRAI'].' '.$row['NomRAI']);
		$des=GLO_textoPHPExcel($row['Descripcion']);
		$cau=GLO_textoPHPExcel($row['Causa']);
		$desai=GLO_textoPHPExcel($row['DesAI']);	
		$obs=GLO_textoPHPExcel($row['Observaciones']);
		$otp=GLO_textoPHPExcel($row['OtrosP']);
		$acc=GLO_textoPHPExcel($row['Accion']);
		$otr=GLO_textoPHPExcel($row['OtrosR']);	
		$aceptada=$row['Aceptada'];		
		//part Causa
		$respcausa='';
		$query='Select p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2, p3.Nombre as N3,p3.Apellido as A3, p4.Nombre as N4,p4.Apellido as A4, p5.Nombre as N5,p5.Apellido as A5,p6.Nombre as N6,p6.Apellido as A6 From iso_nc nc, personal p1, personal p2, personal p3, personal p4, personal p5, personal p6 Where nc.Id='.$idnc.' and nc.IdParticipante1=p1.Id and nc.IdParticipante2=p2.Id and nc.IdParticipante3=p3.Id and nc.IdParticipante4=p4.Id and nc.IdParticipante5=p5.Id and nc.IdParticipante6=p6.Id';
		$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){	
			if($row2['N1']!=''){$respcausa=$respcausa.$row2['N1'].' '.$row2['A1'].', ';}
			if($row2['N2']!=''){$respcausa=$respcausa.$row2['N2'].' '.$row2['A2'].', ';}
			if($row2['N3']!=''){$respcausa=$respcausa.$row2['N3'].' '.$row2['A3'].', ';}
			if($row2['N4']!=''){$respcausa=$respcausa.$row2['N4'].' '.$row2['A4'].', ';}
			if($row2['N5']!=''){$respcausa=$respcausa.$row2['N5'].' '.$row2['A5'].', ';}
			if($row2['N6']!=''){$respcausa=$respcausa.$row2['N6'].' '.$row2['A6'].', ';}
			$respcausa=GLO_textoPHPExcel($respcausa);
		}mysql_free_result($rs2);	
		//resp AC/AP
		$resp='';
		$query='Select p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2, p3.Nombre as N3,p3.Apellido as A3, p4.Nombre as N4,p4.Apellido as A4, p5.Nombre as N5,p5.Apellido as A5,p6.Nombre as N6,p6.Apellido as A6 From iso_nc nc, personal p1, personal p2, personal p3, personal p4, personal p5, personal p6 Where nc.Id='.$idnc.' and nc.IdResponsable1=p1.Id and nc.IdResponsable2=p2.Id and nc.IdResponsable3=p3.Id and nc.IdResponsable4=p4.Id and nc.IdResponsable5=p5.Id and nc.IdResponsable6=p6.Id';
		$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){	
			if($row2['N1']!=''){$resp=$resp.$row2['N1'].' '.$row2['A1'].', ';}
			if($row2['N2']!=''){$resp=$resp.$row2['N2'].' '.$row2['A2'].', ';}
			if($row2['N3']!=''){$resp=$resp.$row2['N3'].' '.$row2['A3'].', ';}
			if($row2['N4']!=''){$resp=$resp.$row2['N4'].' '.$row2['A4'].', ';}
			if($row2['N5']!=''){$resp=$resp.$row2['N5'].' '.$row2['A5'].', ';}
			if($row2['N6']!=''){$resp=$resp.$row2['N6'].' '.$row2['A6'].', ';}
			$resp=GLO_textoPHPExcel($resp);	
		}mysql_free_result($rs2);
		//otros
		if($otp!=''){$respcausa=$respcausa.$otp;}
		if($otr!=''){$resp=$resp.$otr;}
		//aceptada
		if($aceptada==1){$yaceptada='H49';}
		if($aceptada==0){$yaceptada='H51';}
		//norma
		$norma='';
		if($row['IdNorma']!=0){$norma=$norma.$row['Norma1'].', ';}
		if($row['IdNorma2']!=0){$norma=$norma.$row['Norma2'].', ';}
		if($row['IdNorma3']!=0){$norma=$norma.$row['Norma3'];}
		$norma=GLO_textoPHPExcel($norma);
		//req
		$requi='';
		if($row['IdRequisito']!=0) {$requi=$requi.$row['NReq1'].' '.$row['Req1'].', ';}
		if($row['IdRequisito2']!=0){$requi=$requi.$row['NReq2'].' '.$row['Req2'].', ';}
		if($row['IdRequisito3']!=0){$requi=$requi.$row['NReq3'].' '.$row['Req3'].', ';}
		if($row['IdRequisito4']!=0){$requi=$requi.$row['NReq4'].' '.$row['Req4'].', ';}
		if($row['IdRequisito5']!=0){$requi=$requi.$row['NReq5'].' '.$row['Req5'].', ';}	
		if($row['IdRequisito6']!=0){$requi=$requi.$row['NReq6'].' '.$row['Req6'];}
		$requi=GLO_textoPHPExcel($requi);
		//fechas
		$fechae =GLO_FormatoFecha($row['FechaEmision']);
		$fechapl =GLO_FormatoFecha( $row['FechaPlazo']);
		$fechacpl =GLO_FormatoFecha( $row['FechaCumpl']);
		$fechap =GLO_FormatoFecha( $row['FechaPrevista']);
		$fechac =GLO_FormatoFecha( $row['FechaCierre']);
		$fechaai =GLO_FormatoFecha( $row['FechaAI']);
		//nueva
		if ($row['IdNCNueva']!=0) {$nuevanc=str_pad($row['NroNCNueva'], 5, "0", STR_PAD_LEFT);}else{$nuevanc='';}
	}mysql_free_result($rs);
	//verificador
	if($veri==1){$yveri='V49';}
	if($veri==2){$yveri='V51';}
	if($veri==3){$yveri='V53';}
	if($veri==4){$yveri='V55';}
	//exporto
	require_once '../PHPExcel/Classes/PHPExcel.php';
	// Create new PHPExcel object
	$objPHPExcel = PHPExcel_IOFactory::load("../Archivos/Plantillas/Libro8_NC.xls");
	mysql_close($conn); 
	//1
	$objPHPExcel->getActiveSheet()->setCellValue('C7', $nro);
	$objPHPExcel->getActiveSheet()->setCellValue('H8', $origen);
	$objPHPExcel->getActiveSheet()->setCellValue('S8', $cli);
	//2
	$objPHPExcel->getActiveSheet()->setCellValue('C20', $norma);
	$objPHPExcel->getActiveSheet()->setCellValue('C21', $requi);
	$objPHPExcel->getActiveSheet()->setCellValue('C23', $des);
	$objPHPExcel->getActiveSheet()->setCellValue('C25', $fechae);
	$objPHPExcel->getActiveSheet()->setCellValue('J25', $sec);
	$objPHPExcel->getActiveSheet()->setCellValue('W25', $emi);
	//3
	$objPHPExcel->getActiveSheet()->setCellValue('C28', $cau);
	$objPHPExcel->getActiveSheet()->setCellValue('C30', $respcausa);
	//4
	$objPHPExcel->getActiveSheet()->setCellValue('C33', $desai);
	$objPHPExcel->getActiveSheet()->setCellValue('C35', $fechaai);
	$objPHPExcel->getActiveSheet()->setCellValue('M35', $respai);
	//6
	$objPHPExcel->getActiveSheet()->setCellValue('C43', $acc);
	$objPHPExcel->getActiveSheet()->setCellValue('J45', $resp);
	$objPHPExcel->getActiveSheet()->setCellValue('C45', $fechapl);
	$objPHPExcel->getActiveSheet()->setCellValue('Z45', $fechacpl);
	//7
	$objPHPExcel->getActiveSheet()->setCellValue($yaceptada, 'X');
	$objPHPExcel->getActiveSheet()->setCellValue('K47', $fechap);
	$objPHPExcel->getActiveSheet()->setCellValue('L49', $fechac);
	$objPHPExcel->getActiveSheet()->setCellValue('M51', $nuevanc);
	$objPHPExcel->getActiveSheet()->setCellValue('C58', $obs);
	if($veri!=0){$objPHPExcel->getActiveSheet()->setCellValue($yveri, 'X');}
	//finalizo
	include("../Codigo/ExcelHeader.php");	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}





?>


