<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdBuscar'])){
	$consulta="";$consultadet="";
	//verifica que se seleccione criterio
	if ((empty($_POST['TxtFechaDCP'])) or (empty($_POST['TxtFechaHCP']))){$consulta="";}
	else{
		$wfechad="DATEDIFF(nc.FechaEmision,'".FechaMySql($_POST['TxtFechaDCP'])."')>=0";
		$wfechah="DATEDIFF(nc.FechaEmision,'".FechaMySql($_POST['TxtFechaHCP'])."')<=0";
				
		$cliente=intval($_POST['CbCliente']);if($cliente!=0){$wcliente="and nc.IdCliente=$cliente";}else{$wcliente='';}
		$estado=intval($_POST['CbEstadoNC']);if($estado!=0){$westado="and nc.IdEstado=$estado";}else{$westado='';}
		$origen=intval($_POST['CbTipo']);if($origen!=0){$worigen="and nc.IdTipo=$origen";}else{$worigen='';}		
		$tipoh=intval($_POST['CbTipoH']);if($tipoh!=0){$wtipoh="and nc.TipoH=$tipoh";}else{$wtipoh='';}
		//persona
		$persona=intval($_POST['CbPersonal']);if($persona!=0){$wpersona="and (nc.IdResponsable1=$persona or nc.IdResponsable2=$persona or nc.IdResponsable3=$persona or nc.IdResponsable4=$persona or nc.IdResponsable5=$persona or nc.IdResponsable6=$persona)";}else{$wpersona='';}
		//sector
		$sector=intval($_POST['CbSector']);if($sector!=0){$wsector="and (nc.IdSector=$sector or nc.IdSector2=$sector or nc.IdSector3=$sector or nc.IdSector4=$sector)";}else{$wsector='';}
		//vtos
		$hoy=date("d-m-Y"); $wvtoc='';$wvtocpl='';
		$vtocumpl=intval($_POST['ChkVtoCumpl']);if($vtocumpl==1){$wvtocpl="and (nc.FechaCumpl='0000-00-00' and nc.FechaPlazo!='0000-00-00' and DATEDIFF(nc.FechaPlazo,'".FechaMySql($hoy)."')<0)";}
		$vtoc=intval($_POST['ChkVtoCierre']);if($vtoc==1){$wvtoc="and (nc.FechaCierre='0000-00-00' and nc.FechaPrevista!='0000-00-00' and DATEDIFF(nc.FechaPrevista,'".FechaMySql($hoy)."')<0)";}
		
		//consulta
		$consulta="Select nc.*,nc2.Id as NroNCNueva,t.Nombre as Tipo From iso_nc nc,iso_nc nc2,iso_nc_tipo t Where nc.Id<>0 and nc.IdNCNueva=nc2.Id and nc.IdTipo=t.Id $wpersona $wsector $wcliente $wvtoc $wvtocpl $westado $worigen $wtipoh and $wfechad and $wfechah Order by nc.Id";
		//consulta
		$consultadet="Select nc.*,t.Nombre as Tipo,c.Nombre as Cliente,s.Nombre as Sector,s2.Nombre as Sec2,s3.Nombre as Sec3,s4.Nombre as Sec4,n1.Nombre as Norma1,n2.Nombre as Norma2,n3.Nombre as Norma3,r1.Nombre as Req1,r2.Nombre as Req2,r3.Nombre as Req3,r4.Nombre as Req4,r5.Nombre as Req5,r6.Nombre as Req6,r1.Nro as NReq1,r2.Nro as NReq2,r3.Nro as NReq3,r4.Nro as NReq4,r5.Nro as NReq5,r6.Nro as NReq6,v.Nombre as Verif,p1.Apellido as ApRAI,p1.Nombre as NomRAI,p2.Apellido as ApRD,p2.Nombre as NomRD,nc2.Id as NroNCNueva From iso_nc nc,iso_nc_tipo t,clientes c,sector s,iso_nc_norma n1,iso_nc_norma n2,iso_nc_norma n3,iso_nc_req r1,iso_nc_req r2,iso_nc_req r3,iso_nc_req r4,iso_nc_req r5,iso_nc_req r6,iso_nc_verif v,personal p1,personal p2,sector s2,sector s3,sector s4,iso_nc nc2 Where nc.IdTipo=t.Id and nc.IdCliente=c.Id and nc.IdSector=s.Id and nc.IdNorma=n1.Id and nc.IdNorma2=n2.Id and nc.IdNorma3=n3.Id and nc.IdRequisito=r1.Id and nc.IdRequisito2=r2.Id and nc.IdRequisito3=r3.Id and nc.IdRequisito4=r4.Id and nc.IdRequisito5=r5.Id and nc.IdRequisito6=r6.Id and nc.IdVerificador=v.Id and p1.Id=nc.IdRespAI and p2.Id=nc.Emisor and nc.IdSector2=s2.Id and nc.IdSector3=s3.Id and nc.IdSector4=s4.Id and nc.IdNCNueva=nc2.Id $wpersona $wsector $wcliente $wvtoc $wvtocpl $westado $worigen $wtipoh and $wfechad and $wfechah Order by nc.Id";

	}	
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$_SESSION['TxtConsultaNC']=$consulta;
	$_SESSION['TxtConsultaNCDet']=$consultadet;
	header("Location:../ISO_NC.php");
}






if (isset($_POST['CmdExcel'])){
	$query=$_POST['TxtConsultaNC'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th> NC</th>\n";
			echo "<th>Descripci&oacute;n NC</th>\n";
			echo "<th>Fecha</th>\n";			
			echo "<th>Acci&oacute;n Correctiva/Acci&oacute;n Preventiva</th>\n";	
			echo "<th>Responsables AP/AC</th>\n";		
			echo "<th>F.Plazo</th>\n";			
			echo "<th>F.Cumpl.</th>\n";
			echo "<th>F.Prevista.</th>\n";
			echo "<th>F.Cierre.</th>\n";
			echo "<th>Nueva NC</th>\n";
			echo "<th>Estado</th>\n";
			echo "</tr>\n";				
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				//estado
				$id=$row['Id'];$detalle='';$nuevanc='';
				if ($row['IdEstado']==1) {$detalle=' Abierto';}
				if ($row['IdEstado']==2) {$detalle=' Cumplido';}	
				if ($row['IdEstado']==3) {$detalle=' Cerrado';} 
				if ($row['IdEstado']==4) {$detalle=' Incumplido';}
				if ($row['IdEstado']==5) {$detalle=' Reprogramado';}
				//fechas
				if($row['FechaEmision']!='0000-00-00'){$fechae =FormatoFecha($row['FechaEmision']);}else{$fechae='';}
				if($row['FechaPlazo']!='0000-00-00'){$fechapl =FormatoFecha( $row['FechaPlazo']);}else{$fechapl='';}
				if($row['FechaCumpl']!='0000-00-00'){$fechacpl =FormatoFecha( $row['FechaCumpl']);}else{$fechacpl='';}
				if($row['FechaPrevista']!='0000-00-00'){$fechap =FormatoFecha( $row['FechaPrevista']);}else{$fechap='';}
				if($row['FechaCierre']!='0000-00-00'){$fechac =FormatoFecha( $row['FechaCierre']);}else{$fechac='';}
				//nueva
				if ($row['IdNCNueva']!=0) {$nuevanc='NC'.' '.str_pad($row['NroNCNueva'], 5, "0", STR_PAD_LEFT);}
				//resp AC/AP
				$resp='';
				$query='Select p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2, p3.Nombre as N3,p3.Apellido as A3, p4.Nombre as N4,p4.Apellido as A4, p5.Nombre as N5,p5.Apellido as A5,p6.Nombre as N6,p6.Apellido as A6 From iso_nc nc, personal p1, personal p2, personal p3, personal p4, personal p5, personal p6 Where nc.Id='.$id.' and nc.IdResponsable1=p1.Id and nc.IdResponsable2=p2.Id and nc.IdResponsable3=p3.Id and nc.IdResponsable4=p4.Id and nc.IdResponsable5=p5.Id and nc.IdResponsable6=p6.Id';
				$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
				if(mysql_num_rows($rs2)!=0){					
					if($row2['N1']!=''){$resp=$resp.$row2['N1'].' '.$row2['A1'].', ';}
					if($row2['N2']!=''){$resp=$resp.$row2['N2'].' '.$row2['A2'].', ';}
					if($row2['N3']!=''){$resp=$resp.$row2['N3'].' '.$row2['A3'].', ';}
					if($row2['N4']!=''){$resp=$resp.$row2['N4'].' '.$row2['A4'].', ';}
					if($row2['N5']!=''){$resp=$resp.$row2['N5'].' '.$row2['A5'].', ';}
					if($row2['N6']!=''){$resp=$resp.$row2['N6'].' '.$row2['A6'].', ';}
				
				}mysql_free_result($rs2);
				//otros
				$otr=$row['OtrosR'];
				if($otr!=''){$resp=$resp.$otr;}	
				//excel
				echo "<tr>\n";
				echo '<td>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Descripcion'])."</td>\n";
				echo '<td>'.$fechae."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Accion'])."</td>\n";
				echo '<td>'.GLO_textoExcel($resp)."</td>\n";				
				echo '<td>'.$fechapl."</td>\n";
				echo '<td>'.$fechacpl."</td>\n";
				echo '<td>'.$fechap."</td>\n";
				echo '<td>'.$fechac."</td>\n";
				echo '<td>'.$nuevanc."</td>\n";
				echo '<td>'.GLO_textoExcel($detalle)."</td>\n";
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
 
 
 if (isset($_POST['CmdExcel2'])){
	$query=$_POST['TxtConsultaNCDet'];$query=str_replace("\\", "", $query);
	if ($query!=""){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){	
			//Titulos excel
			include("../Codigo/ExcelHeader.php");
			include("../Codigo/ExcelStyle.php");
			echo "<th> NC</th>\n";
			echo "<th>Origen</th>\n";
			echo "<th>Cliente</th>\n";			
			echo "<th>Fecha</th>\n";	
			echo "<th>Sector</th>\n";
			echo "<th>Resp.Detecci&oacute;n</th>\n";
			echo "<th>Norma</th>\n";
			echo "<th>Requisito</th>\n";
			echo "<th>Descripci&oacute;n NC</th>\n";	
			echo "<th>Acci&oacute;n Inmediata</th>\n";
			echo "<th>Fecha AI</th>\n";
			echo "<th>Resp.AI</th>\n";				
			echo "<th>Causa</th>\n";	
			echo "<th>Resp.Causa</th>\n";					
			echo "<th>Acci&oacute;n Correctiva/Acci&oacute;n Preventiva</th>\n";	
			echo "<th>Resp.AP/AC</th>\n";		
			echo "<th>F.Plazo</th>\n";			
			echo "<th>F.Cumpl.</th>\n";
			echo "<th>Aceptada</th>\n";
			echo "<th>Verificador</th>\n";
			echo "<th>F.Prevista.</th>\n";
			echo "<th>F.Cierre.</th>\n";
			echo "<th>Observaciones</th>\n";
			echo "<th>Nueva NC</th>\n";
			echo "<th>Estado</th>\n";
			echo "</tr>\n";				
			//datos excel	
			while($row=mysql_fetch_array($rs)){ 
				//estado
				$id=$row['Id'];$detalle='';$nuevanc='';
				if ($row['IdEstado']==1) {$detalle=' Abierto';}
				if ($row['IdEstado']==2) {$detalle=' Cumplido';}	
				if ($row['IdEstado']==3) {$detalle=' Cerrado';} 
				if ($row['IdEstado']==4) {$detalle=' Incumplido';}
				if ($row['IdEstado']==5) {$detalle=' Reprogramado';}
				//fechas
				if($row['FechaEmision']!='0000-00-00'){$fechae =FormatoFecha($row['FechaEmision']);}else{$fechae='';}
				if($row['FechaPlazo']!='0000-00-00'){$fechapl =FormatoFecha( $row['FechaPlazo']);}else{$fechapl='';}
				if($row['FechaCumpl']!='0000-00-00'){$fechacpl =FormatoFecha( $row['FechaCumpl']);}else{$fechacpl='';}
				if($row['FechaPrevista']!='0000-00-00'){$fechap =FormatoFecha( $row['FechaPrevista']);}else{$fechap='';}
				if($row['FechaCierre']!='0000-00-00'){$fechac =FormatoFecha( $row['FechaCierre']);}else{$fechac='';}
				if($row['FechaAI']!='0000-00-00'){$fechaai =FormatoFecha( $row['FechaAI']);}else{$fechaai='';}
				//nueva
				if ($row['IdNCNueva']!=0) {$nuevanc='NC '.str_pad($row['NroNCNueva'], 5, "0", STR_PAD_LEFT);}
				//part Causa
				$respcausa='';
				$query='Select p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2, p3.Nombre as N3,p3.Apellido as A3, p4.Nombre as N4,p4.Apellido as A4, p5.Nombre as N5,p5.Apellido as A5,p6.Nombre as N6,p6.Apellido as A6 From iso_nc nc, personal p1, personal p2, personal p3, personal p4, personal p5, personal p6 Where nc.Id='.$id.' and nc.IdParticipante1=p1.Id and nc.IdParticipante2=p2.Id and nc.IdParticipante3=p3.Id and nc.IdParticipante4=p4.Id and nc.IdParticipante5=p5.Id and nc.IdParticipante6=p6.Id';
				$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
				if(mysql_num_rows($rs2)!=0){					
					if($row2['N1']!=''){$respcausa=$respcausa.$row2['N1'].' '.$row2['A1'].', ';}
					if($row2['N2']!=''){$respcausa=$respcausa.$row2['N2'].' '.$row2['A2'].', ';}
					if($row2['N3']!=''){$respcausa=$respcausa.$row2['N3'].' '.$row2['A3'].', ';}
					if($row2['N4']!=''){$respcausa=$respcausa.$row2['N4'].' '.$row2['A4'].', ';}
					if($row2['N5']!=''){$respcausa=$respcausa.$row2['N5'].' '.$row2['A5'].', ';}
					if($row2['N6']!=''){$respcausa=$respcausa.$row2['N6'].' '.$row2['A6'].', ';}
				
				}mysql_free_result($rs2);				
				//resp AC/AP
				$resp='';
				$query='Select p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2, p3.Nombre as N3,p3.Apellido as A3, p4.Nombre as N4,p4.Apellido as A4, p5.Nombre as N5,p5.Apellido as A5,p6.Nombre as N6,p6.Apellido as A6 From iso_nc nc, personal p1, personal p2, personal p3, personal p4, personal p5, personal p6 Where nc.Id='.$id.' and nc.IdResponsable1=p1.Id and nc.IdResponsable2=p2.Id and nc.IdResponsable3=p3.Id and nc.IdResponsable4=p4.Id and nc.IdResponsable5=p5.Id and nc.IdResponsable6=p6.Id';
				$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
				if(mysql_num_rows($rs2)!=0){					
					if($row2['N1']!=''){$resp=$resp.$row2['N1'].' '.$row2['A1'].', ';}
					if($row2['N2']!=''){$resp=$resp.$row2['N2'].' '.$row2['A2'].', ';}
					if($row2['N3']!=''){$resp=$resp.$row2['N3'].' '.$row2['A3'].', ';}
					if($row2['N4']!=''){$resp=$resp.$row2['N4'].' '.$row2['A4'].', ';}
					if($row2['N5']!=''){$resp=$resp.$row2['N5'].' '.$row2['A5'].', ';}
					if($row2['N6']!=''){$resp=$resp.$row2['N6'].' '.$row2['A6'].', ';}
				
				}mysql_free_result($rs2);
				//aceptada
				if($row['Aceptada']==0){$aceptada='';}else{$aceptada='Si';}	
				//norma
				$norma='';
				if($row['IdNorma']!=0) {$norma=$norma.$row['Norma1'].', ';}
				if($row['IdNorma2']!=0){$norma=$norma.$row['Norma2'].', ';}
				if($row['IdNorma3']!=0){$norma=$norma.$row['Norma3'];}
				//req
				$requi='';
				if($row['IdRequisito']!=0) {$requi=$requi.$row['NReq1'].' '.$row['Req1'].', ';}
				if($row['IdRequisito2']!=0){$requi=$requi.$row['NReq2'].' '.$row['Req2'].', ';}
				if($row['IdRequisito3']!=0){$requi=$requi.$row['NReq3'].' '.$row['Req3'].', ';}
				if($row['IdRequisito4']!=0){$requi=$requi.$row['NReq4'].' '.$row['Req4'].', ';}
				if($row['IdRequisito5']!=0){$requi=$requi.$row['NReq5'].' '.$row['Req5'].', ';}
				if($row['IdRequisito6']!=0){$requi=$requi.$row['NReq6'].' '.$row['Req6'];}
				//otros
				$otp=$row['OtrosP'];$otr=$row['OtrosR'];
				if($otp!=''){$respcausa=$respcausa.$otp;}
				if($otr!=''){$resp=$resp.$otr;}		
				//sector
				$sector='';
				if($row['IdSector']!=0) {$sector=$sector.$row['Sector'].', ';}
				if($row['IdSector2']!=0){$sector=$sector.$row['Sec2'].', ';}
				if($row['IdSector3']!=0){$sector=$sector.$row['Sec3'].', ';}
				if($row['IdSector4']!=0){$sector=$sector.$row['Sec4'];}
				//excel
				echo "<tr>\n";
				echo '<td>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Tipo'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Cliente'])."</td>\n";
				echo '<td>'.$fechae."</td>\n";
				echo '<td>'.$sector."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ApRD'].' '.$row['NomRD'])."</td>\n";
				echo '<td>'.GLO_textoExcel($norma)."</td>\n";
				echo '<td>'.GLO_textoExcel($requi)."</td>\n";				
				echo '<td>'.GLO_textoExcel($row['Descripcion'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['DesAI'])."</td>\n";
				echo '<td>'.$fechaai."</td>\n";
				echo '<td>'.GLO_textoExcel($row['ApRAI'].' '.$row['NomRAI'])."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Causa'])."</td>\n";
				echo '<td>'.GLO_textoExcel($respcausa)."</td>\n";								
				echo '<td>'.GLO_textoExcel($row['Accion'])."</td>\n";
				echo '<td>'.GLO_textoExcel($resp)."</td>\n";				
				echo '<td>'.$fechapl."</td>\n";
				echo '<td>'.$fechacpl."</td>\n";
				echo '<td>'.$aceptada."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Verif'])."</td>\n";				
				echo '<td>'.$fechap."</td>\n";
				echo '<td>'.$fechac."</td>\n";
				echo '<td>'.GLO_textoExcel($row['Observaciones'])."</td>\n";
				echo '<td>'.$nuevanc."</td>\n";
				echo '<td>'.GLO_textoExcel($detalle)."</td>\n";				
				echo "</tr>\n";			
			}	
			//Cierra tabla excel
			echo "</table>\n";				
		}	
		mysql_free_result($rs);	mysql_close($conn); 
	}

 }
?>