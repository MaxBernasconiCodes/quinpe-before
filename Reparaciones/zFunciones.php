<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

function TraerAccionOrden($idorden,$conn){
	$query="select Obs from pedidosrepreq where IdPR=$idorden";	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$accion=substr($row2['Obs'],0,24);}else{$accion='';}mysql_free_result($rs2);
	return $accion;
}




function REP_colorestsoli($idestado){
$colorest='';
if($idestado=='1'){$colorest=' style="font-weight:bold;color:#ff9900"';}//solicitada
if($idestado=='2'){$colorest=' style="font-weight:bold;color:#f44336"';}//rech
if($idestado=='3'){$colorest=' style="font-weight:bold;color:#4CAF50"';}//aceptada
if($idestado=='4'){$colorest=' style="font-weight:bold;color:#00668e"';}//a retirar
if($idestado=='5'){$colorest=' style="font-weight:bold;color:#cc0099"';}//resuelto
return $colorest;
}



function REP_estadosolicitud($conn,$estado,$soli){//cambia estado
	if($soli!=0){
		$query="UPDATE pedidosrep set IdEstado=$estado Where Id=$soli";$rs10=mysql_query($query,$conn);
	}
}


function REP_estadoorden($conn,$estado,$orden){
	if($orden!=0){
		$nroId2=GLO_generoID('pedidosrep_hist',$conn);
		$fecha=FechaMySql(date("d-m-Y"));$user=$_SESSION["login"];
		//cambia estado
		$query="UPDATE pedidosrepord set IdEstado=$estado Where Id=$orden";$rs10=mysql_query($query,$conn);
		//graba historial
		$query="INSERT INTO pedidosrep_hist (Id,IdPR,IdEstado,Fecha,IdUsuario,Obs) VALUES ($nroId2,$orden,$estado,'$fecha','$user','')";
		$rs10=mysql_query($query,$conn);	
	}
}

function REP_updateestadoorden($conn,$orden,$estadoalta){ 
	$estadoactual=0;$estadonuevo=1;$planillacompleta=0;$tieneacciones=0;$acccumplidas=0;$accpendientes=0;$accotroestado=0;
	$idsoli=0;$estadosoli=0;
	if($estadoalta==0){//modifica orden
		//ver si planilla esta completa	y estado actual
		$query="select o.ListoPL,o.IdEstado,o.IdSoli,r.IdEstado as IdEstadoS from pedidosrepord o,pedidosrep r where o.IdSoli=r.Id and o.Id=$orden";
		$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){
			$estadosoli=$row2['IdEstadoS'];$idsoli=$row2['IdSoli'];$estadoactual=$row2['IdEstado'];
			//1 completa/2 no requerida
			if($row2['ListoPL']==1 or $row2['ListoPL']==2){$planillacompleta=1;}
		}mysql_free_result($rs2);
		//ver si tiene acciones cargadas	
		$query="select Id from pedidosrepreq where IdPR=$orden";$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){$tieneacciones=1;}mysql_free_result($rs2);	
		//ver estado acciones
		if($tieneacciones==1){
			$query="select Id from pedidosrepreq where IdEstado=5 and IdPR=$orden";$rs2=mysql_query($query,$conn);
			$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$acccumplidas=1;}mysql_free_result($rs2);
			$query="select Id from pedidosrepreq where IdEstado=6 and IdPR=$orden";$rs2=mysql_query($query,$conn);
			$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$accpendientes=1;}mysql_free_result($rs2);
			$query="select Id from pedidosrepreq where IdEstado<>5 and IdEstado<>6 and IdPR=$orden";$rs2=mysql_query($query,$conn);
			$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$accotroestado=1;}mysql_free_result($rs2);
		}
		//criterios estado
		if($planillacompleta==0){//planilla incompleta
			if($tieneacciones==1){$estadonuevo=3;}//si tiene acciones 'en ejecucion'	
		}else{//planilla completa
			//si tiene acciones 'controlado y en ejecucion'	, si no tiene acciones 'controlado'	
			if($tieneacciones==1){$estadonuevo=4;}else{$estadonuevo=2;}
			//si todas las acciones estan cumplidas 'cerrado a retirar'
			if($acccumplidas==1 and $accpendientes==0 and $accotroestado==0){$estadonuevo=5;}
			//si todas cumplidas salvo alguna pendiente 'pendiente a retirar'
			if($acccumplidas==1 and $accpendientes==1 and $accotroestado==0){$estadonuevo=6;}
		}
	}else{//alta orden
		$estadonuevo=$estadoalta;//1 si es emitida, 7 si es rechazada
	}
	
	//si cambia el estado actualizo la orden, el historial y la solicitud
	if($estadoactual!=$estadonuevo){
		//si 'cerrado' pasa a 'entregado c/pdte' o vsa, y solicitud retirada
		if(($estadonuevo==5 or $estadonuevo==6) and ($estadoactual==8 or $estadoactual==9) and ($estadosoli==5)){
			if($estadonuevo==5){$estadonuevo=8;}else{$estadonuevo=9;}
		}
		REP_estadoorden($conn,$estadonuevo,$orden);
		// si pasa  a otro que no sea 'finalizado sin accion', pasa a 'aceptada'
		if($estadonuevo==1 or $estadonuevo==2 or $estadonuevo==3 or $estadonuevo==4){if($estadosoli!=3){REP_estadosolicitud($conn,3,$idsoli);}}
		//si pasa a estados 'pdte a retirar' o 'cerrado a retirar', marca solicitud 'a retirar'
		if($estadonuevo==5 or $estadonuevo==6){if($estadosoli!=4){REP_estadosolicitud($conn,4,$idsoli);}}
		//si pasa a estados 'cerrada' o 'entregada c/pdte', marca solicitud 'retirada'
		if($estadonuevo==8 or $estadonuevo==9){	if($estadosoli!=5){REP_estadosolicitud($conn,5,$idsoli);}
			
		}
	}
	
}

/*
		//si pasa a estados pdte a retirar o cerrado a retirar, marca solicitud a retirar
		if($estadonuevo==5 or $estadonuevo==6){if($estadosoli!=4){REP_estadosolicitud($conn,4,$idsoli);}}
		else{
			//si estado anterior era pdte a retirar o cerrado a retirar, marca solicitud a aceptada 
			if($estadoactual==5 or $estadoactual==6){if($estadosoli==4){REP_estadosolicitud($conn,3,$idsoli);}}
		}
*/

function REP_estadoaccion($conn,$estado,$accion){
	if($accion!=0){
		//inserto historial estado
		$nroId2=GLO_generoID('pedidosrepreq_hist',$conn);
		$fecha=FechaMySql(date("d-m-Y"));$user=$_SESSION["login"];
		//cambia estado
		$query="UPDATE pedidosrepreq set IdEstado=$estado Where Id=$accion";$rs10=mysql_query($query,$conn);
		//graba historial
		$query="INSERT INTO pedidosrepreq_hist (Id,IdPRR,IdEstado,Fecha,IdUsuario) VALUES ($nroId2,$accion,$estado,'$fecha','$user')";
		$rs10=mysql_query($query,$conn);
	}
}



function REP_updateestadoaccion($conn,$accion,$orden,$alta){
	$estadoactual=0;$estadonuevo=1;$externa=0;$todospsimim=0;$insconpsi=0;$finalizada=0;$finalizadacpdte=0;$ingresose=0;
	//ver estado,externo y finalizado
	$query="select FFin,Pdtes,IdEstado,Alcance from pedidosrepreq where Id=$accion";$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){
		$estadoactual=$row2['IdEstado'];$externa=$row2['Alcance'];
		if($row2['FFin']!='0000-00-00'){$finalizada=1;if($row2['Pdtes']==1){$finalizadacpdte=1;}}	
	}mysql_free_result($rs2);
	if($alta==0){//si modifica la acci&oacute;n
		//ver si ingreso a servicio externo
		$query="select Id from pedidosrepreq_act where IngresoSE<>0 and IdPRR=$accion";$rs2=mysql_query($query,$conn);
		$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$ingresose=1;}mysql_free_result($rs2);	
		//ver si tiene insumos con psi
		$query="select Id from pedidosrepreq_ins where PSI<>0 and IdPRR=$accion";$rs2=mysql_query($query,$conn);
		$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$insconpsi=1;}mysql_free_result($rs2);	
		//ver si tiene todos los insumos con psi y mim
		$query="select Id from pedidosrepreq_ins where (PSI=0 or MIM=0) and IdPRR=$accion";$rs2=mysql_query($query,$conn);
		$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)==0){$todospsimim=1;}mysql_free_result($rs2);		
		//criterios estado
		if($finalizada==1){if($finalizadacpdte==0){$estadonuevo=5;}else{$estadonuevo=6;}}//finalizada con pdtes o sin pdtes
		else{//sin finalizar
			//si es externa, verifico si ingres&oacute; o no a servicio ext
			if($externa==1){if($ingresose==0){$estadonuevo=2;}else{$estadonuevo=7;}}
			else{//interna		
				if($insconpsi==0){$estadonuevo=1;}//si no tiene insumos con psi
				else{//tiene insumos con psi
					if($todospsimim==1){$estadonuevo=4;}else{$estadonuevo=3;}//ver si todos tienen mim
				}	
			}	
		}	
	}else{//si es alta de accion
		if($externa==1){$estadonuevo=2;}	
	}
	
	
	//si cambia el estado actualizo la orden y la accion y el historial de ambas
	if($estadoactual!=$estadonuevo){
		//actualizo estado e historial accion 
		REP_estadoaccion($conn,$estadonuevo,$accion);		
	}
	//actualizo estado e historial orden 
	REP_updateestadoorden($conn,$orden,0);		

}


function REP_TablaAct($idpadre,$conn,$tipo){//tipo 0 $idpadre = id accion, tipo 1 $idpadre = id orden
$idpadre=intval($idpadre);
if($tipo==0){ //desde accion
$query="SELECT r.*,p.Apellido,p.Nombre From pedidosrepreq_act r,personal p  where r.Id<>0 and r.IdPersonal=p.Id and r.IdPRR=$idpadre Order by r.Fecha,r.Hora1 ";}
else{//desde orden
$query="SELECT r.*,p.Apellido,p.Nombre From pedidosrepreq_act r,personal p,pedidosrepreq a where r.Id<>0 and r.IdPersonal=p.Id and r.IdPRR=a.Id and a.IdPR=$idpadre Order by r.Fecha,r.Hora1";
}
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0"  class="TMT20"><tr><td width="430" valign="bottom"><i class="fa fa-tasks iconsmallsp iconlgray"></i> <strong>Tareas:</strong></td><td width="300" align="right">';
//desde accion
if($tipo==0){$tablaclientes .='<input name="CmdFin" type="submit" class="boton02" style="width:90px;" value="Finalizar Accion" onClick="document.Formulario.target='."'_self'".'">';}
$tablaclientes .='</td></tr><tr> <td colspan="2">';
$tablaclientes .='<table width="750" class="TableShow TMT" id="tshow"><tr>';
$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> Inicio</td>";   
$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> Fin</td>";   
$tablaclientes .="<td "."width="."400"." class="."TableShowT"."> Actividad</td>";   
$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> Responsable</td>";   
$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Serv.Ext.</td>";   
$tablaclientes .='<td width="40" class="TableShowT TAR">';
//si esta retirada o finalizada no puede modificar
if($tipo==0){ //desde accion
if (intval($_SESSION['TxtIdEstadoO'])!=7 and intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
$tablaclientes .=GLO_FAButton('CmdAddAc','submit','','self','Agregar','add','iconbtn');}
}
$tablaclientes .='</td></tr>';             
while($row=mysql_fetch_array($rs)){ 
	//desde accion
	if($tipo==0){$link=" onclick="."location='ModificarAc.php?Flag1=True"."&id=".$row['Id']."'";$estilo=" style='cursor:pointer;'";}
	else{$link="";$estilo="";}
	if($row['IngresoSE']==1){$ise='Ingreso';}else{$ise='';}
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoHora($row['Hora1'])."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoHora($row['Hora2'])."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Obs'],0,55)."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Apellido'].' '.$row['Nombre'],0,14)."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".$ise."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR">';
	//si esta retirada no puede borrar 
	if($tipo==0){//desde accion
		if (intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
			$tablaclientes .=GLO_rowbutton("CmdBorrarFilaAc",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
		}
	}
	$tablaclientes .='</td></tr>'; 
}mysql_free_result($rs);	
$tablaclientes .='</table></td></tr></table>';
echo $tablaclientes;
}


function REP_TablaReqSoli($idpadre,$conn){ //requerimientos de las solicitudes de la orden
	$query="SELECT rr.* From pedidosrepreqsoli rr,pedidosrep pr where rr.Id<>0 and rr.IdPR=pr.Id and pr.IdOrden=$idpadre Order by rr.Fecha,rr.Obs ";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="750" class="TableShow TMT" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."65"." class="."TableShowT"."> Fecha</td>";  
	$tablaclientes .="<td "."width="."595"." class="."TableShowT"."> Requerimiento</td>";   
	$tablaclientes .="<td "."width="."40"." class="."TableShowT"."> Urg</td>";   
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"." > Estado</td>";   
	$tablaclientes .='</tr>';             
	$estilo="";$clase="TableShowD";$link="";
	while($row=mysql_fetch_array($rs)){ 
		$color=' style="font-weight:bold;color:#f44336" ';$estado='Pdte';if($row['Estado']==1){$estado='Visto';$color='';} 
		$urg='';if($row['Urg']==1){$urg='Baja';} if($row['Urg']==2){$urg='Media';}if($row['Urg']==3){$urg='Alta';}
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
		$tablaclientes .="<td class=".$clase."> ".'<input type="text" readonly="true" class="TextBoxRO"  style="width:520px;border:none"  value="'.$row['Obs'].'">'."</td>"; 
		$tablaclientes .="<td class=".$clase.$link."> ".$urg."</td>"; 
		$tablaclientes .="<td class=".$clase.$link.$color."> ".$estado."</td>"; 
		$tablaclientes .='</tr>'; 
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;	
}
	
?>