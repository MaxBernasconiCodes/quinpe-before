<? include("../Codigo/Seguridad.php") ; 



$query="SELECT * From iso_nc where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
	$_SESSION['CbTipo'] = $row['IdTipo'];
	$_SESSION['CbCliente'] = $row['IdCliente'];
	$_SESSION['CbNorma1'] = $row['IdNorma'];
	$_SESSION['CbNorma2'] = $row['IdNorma2'];
	$_SESSION['CbNorma3'] = $row['IdNorma3'];
	$_SESSION['CbReq1'] = $row['IdRequisito'];
	$_SESSION['CbReq2'] = $row['IdRequisito2'];
	$_SESSION['CbReq3'] = $row['IdRequisito3'];
	$_SESSION['CbReq4'] = $row['IdRequisito4'];
	$_SESSION['CbReq5'] = $row['IdRequisito5'];
	$_SESSION['CbReq6'] = $row['IdRequisito6'];
	$_SESSION['TxtDescripcion'] = $row['Descripcion'];
	$_SESSION['TxtFecha'] = GLO_FormatoFecha($row['FechaEmision']);
	$_SESSION['CbSector'] =$row['IdSector'];
	$_SESSION['CbSector2'] =$row['IdSector2'];
	$_SESSION['CbSector3'] =$row['IdSector3'];
	$_SESSION['CbSector4'] =$row['IdSector4'];
	$_SESSION['CbRespDet'] = $row['Emisor'];
	$_SESSION['TxtRespDet'] = $row['RespDetExt'];
	$_SESSION['TxtDesAI'] = $row['DesAI'];
	
	$_SESSION['CbPartAI'] =$row['IdRespAI'];
	$_SESSION['TxtCausa'] = $row['Causa'];
	$_SESSION['CbPartCausa1'] = $row['IdParticipante1'];
	$_SESSION['CbPartCausa2'] = $row['IdParticipante2'];
	$_SESSION['CbPartCausa3'] = $row['IdParticipante3'];
	$_SESSION['CbPartCausa4'] = $row['IdParticipante4'];
	$_SESSION['CbPartCausa5'] = $row['IdParticipante5'];
	$_SESSION['CbPartCausa6'] = $row['IdParticipante6'];
	
	
	
	//parte 6
	$_SESSION['TxtAccion'] = $row['Accion'];
	$_SESSION['CbRespAccion1'] = $row['IdResponsable1'];
	$_SESSION['CbRespAccion2'] = $row['IdResponsable2'];
	$_SESSION['CbRespAccion3'] = $row['IdResponsable3'];
	$_SESSION['CbRespAccion4'] = $row['IdResponsable4'];
	$_SESSION['CbRespAccion5'] = $row['IdResponsable5'];
	$_SESSION['CbRespAccion6'] = $row['IdResponsable6'];
	$_SESSION['TxtOtrosR'] = $row['OtrosR'];
	$_SESSION['TxtOtrosRM'] = $row['OtrosRMail'];
	$_SESSION['TxtFPlazo'] = GLO_FormatoFecha($row['FechaPlazo']);
	$_SESSION['TxtFCumpl'] = GLO_FormatoFecha($row['FechaCumpl']);
	$_SESSION['TxtFPrevista']=GLO_FormatoFecha($row['FechaPrevista']);
	$_SESSION['TxtFCierre'] = GLO_FormatoFecha($row['FechaCierre']);
	$_SESSION['TxtFechaAI'] = GLO_FormatoFecha($row['FechaAI']);
	$_SESSION['TxtObsVerif'] = $row['Observaciones'];
	$_SESSION['CbVerif'] = $row['IdVerificador'];
	$_SESSION['CbNuevaNC'] = $row['IdNCNueva'];
	$_SESSION['TxtIdEstado'] = $row['IdEstado'];
	$_SESSION['ChkAceptada'] = $row['Aceptada'];
	$_SESSION['TxtOtrosP'] = $row['OtrosP'];
	$_SESSION['TxtOtrosPM'] = $row['OtrosPMail'];
	$_SESSION['CbTipoH'] = $row['TipoH'];
	
	//limpio
	$_SESSION['TxtEstado']='';$detalle='';$idc='';
	$fechapl=$_SESSION['TxtFPlazo'];$fechacpl=$_SESSION['TxtFCumpl'];$fechap=$_SESSION['TxtFPrevista'];$fechac=$_SESSION['TxtFCierre'];
	//estado 1:abierto, 2:cumplido, 3:cerrado, 4:incumplido, 5:reprogramado
	if($_SESSION['TxtIdEstado']==1){$_SESSION['TxtEstado']='Abierto';}
	if($_SESSION['TxtIdEstado']==2){$_SESSION['TxtEstado']='Cumplido';}
	if($_SESSION['TxtIdEstado']==3){$_SESSION['TxtEstado']='Cerrado';}
	if($_SESSION['TxtIdEstado']==4){$_SESSION['TxtEstado']='Incumplido';}
	if($_SESSION['TxtIdEstado']==5){$_SESSION['TxtEstado']='Reprogramado';}
	//cumplimiento  1:vigente, 2:vencido, 3:puntual, 4:no puntual 5:nada incumplido
	//si abierto: verifica cumplimiento vencido
	if ($row['IdEstado']==1) {
		if($row['FechaPlazo']!='0000-00-00'){
			if ((strtotime(date("d-m-Y"))-strtotime($fechapl))>0){$detalle=' VENCIDO';$idc=2;}else{$detalle=' VIGENTE';$idc=1;}				
		}
	}			
	//si cumplido: verifica cumplimiento puntual
	if ($row['IdEstado']==2) {
		if( ($row['FechaPlazo']!='0000-00-00') and ($row['FechaCumpl']!='0000-00-00')){
			if ((strtotime($fechacpl)-strtotime($fechapl))>0){$detalle=' NO PUNTUAL';$idc=4;}else{$detalle=' PUNTUAL';$idc=3;}				
		}
	}
	//si cerrado: verifica cierre puntual, cierre puntual lleva medalla de oro
	if ($row['IdEstado']==3) {
		if( ($row['FechaPrevista']!='0000-00-00') and ($row['FechaCierre']!='0000-00-00')){
			if ((strtotime($fechac)-strtotime($fechap))>0){$detalle=' NO PUNTUAL';$idc=4;}	else{$detalle=' PUNTUAL';$idc=3;}				
		}	
	}
	
	//si incumplido/reprogramado no muestra detalle
	if ($row['IdEstado']==4) {$detalle='';$idc=5;}
	if ($row['IdEstado']==5) {$detalle='';$idc=5;}
	
	$_SESSION['TxtIdCumpl']=$idc;$_SESSION['TxtCumpl']=$detalle;
}mysql_free_result($rs);
?>