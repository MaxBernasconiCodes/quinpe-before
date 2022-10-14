<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
$_SESSION['TxtOriPage'] = intval($_GET['ori']);
$query="SELECT r.*,u.Dominio,pr.IdEstado as IdEstadoS,e.Nombre as EstadoS,rt.Nombre as TipoS,p.Apellido as Ap,p.Nombre as Nom,pr.Fecha as FechaS,pr.FechaSI,eo.Nombre as EstadoO From pedidosrepord r,unidades u,pedidosrep pr,pedidosrep_est e,pedidosrepord_est eo,pedidosrep_tipo rt,personal p where r.Id<>0 and r.IdUnidad=u.Id and r.IdSoli=pr.Id and pr.IdEstado=e.Id and r.IdEstado=eo.Id and pr.IdTipo=rt.Id and pr.IdPersonal=p.Id and r.Id=".intval($_GET['id']); 
$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtFecha1'] = GLO_FormatoFecha($row['Fecha']);		
	$_SESSION['CbUnidad'] = $row['IdUnidad'];
	$_SESSION['CbSector'] = $row['IdSector'];
	$_SESSION['CbInstrumento'] = $row['IdInstr'];
	$_SESSION['TxtEstadoO'] = $row['EstadoO'];
	$_SESSION['TxtIdEstadoO'] = $row['IdEstado'];
	$_SESSION['CbTipo'] = $row['IdTipo'];	
	$_SESSION['CbSoli'] = $row['IdSoli'];
	$_SESSION['CbSoli1'] = $row['IdSoli'];
	$_SESSION['CbPersonal'] = $row['IdPersonal'];
	//
	$_SESSION['TxtFecha3'] = GLO_FormatoFecha($row['FechaI']);
	$_SESSION['TxtFecha4'] = GLO_FormatoFecha($row['FechaE']);
	$_SESSION['TxtObs'] = $row['Obs'];
	//fecha limite +5 dias
	if (!(empty($_SESSION['TxtFecha3']))){ 
		$fecha3=$_SESSION['TxtFecha3'];$_SESSION['TxtFecha5']=date("d-m-Y", strtotime("$fecha3 +5 day"));	
	}
	//solicitud
	if($row['IdSoli']!=0){
		$_SESSION['TxtFechaS'] = GLO_FormatoFecha($row['FechaS']);
		$_SESSION['TxtFechaSI'] = GLO_FormatoFecha($row['FechaSI']);
		$_SESSION['TxtSoliS'] = $row['Ap'].' '.$row['Nom'];
		$_SESSION['TxtTipoS'] = $row['TipoS'];
		$_SESSION['TxtEstadoS'] =$row['EstadoS'];
		$_SESSION['TxtIdEstadoS'] =$row['IdEstadoS'];
	}else{
		$_SESSION['TxtFechaS'] = "";
		$_SESSION['TxtFechaSI'] = "";
		$_SESSION['TxtSoliS'] = "";
		$_SESSION['TxtTipoS'] = "";
		$_SESSION['TxtEstadoS'] = "";
		$_SESSION['TxtIdEstadoS'] = "";
	}
	//ver si tiene acciones cargadas para definir si solicita la Fecha a Retirar
	$orden=$row['Id'];$tieneacciones=0;$acccumplidas=0;$accotroestado=0;$_SESSION['TxtIdAccCumpl']=0;		
	$query="select Id from pedidosrepreq where IdPR=$orden";$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$tieneacciones=1;}mysql_free_result($rs2);	
	//ver estado acciones 
	if($tieneacciones==1){
		$query="select Id from pedidosrepreq where (IdEstado=5 or IdEstado=6) and IdPR=$orden";$rs2=mysql_query($query,$conn);
		$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$acccumplidas=1;}mysql_free_result($rs2);
		$query="select Id from pedidosrepreq where IdEstado<>5 and IdEstado<>6 and IdPR=$orden";$rs2=mysql_query($query,$conn);
		$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$accotroestado=1;}mysql_free_result($rs2);
		//si todas estan cumplidas, fecha a retirar de la orden es solicitada
		if($acccumplidas==1 and $accotroestado==0){$_SESSION['TxtIdAccCumpl']=1;}
	}


}mysql_free_result($rs);
} 


function ComboSolicitudes($conn){
//variables
$estorden=intval($_SESSION['TxtIdEstadoO']);
$soli=intval($_SESSION['CbSoli']);
//valido where a usar
$where="";
$uni=intval($_SESSION['CbUnidad']); if($uni!=0){$where="and r.IdUnidad=$uni";}
$sec=intval($_SESSION['CbSector']); if($sec!=0){$where="and r.IdSector=$sec";}
$ins=intval($_SESSION['CbInstrumento']); if($ins!=0){$where="and r.IdInstr=$ins";}
//veo si tiene algun requerimiento visto
$query="SELECT rr.Id From pedidosrepreqsoli rr,pedidosrep pr where rr.Id<>0 and rr.IdPR=pr.Id and rr.Estado=1 and pr.IdOrden=".intval($_SESSION['TxtNumero']);$rs2=mysql_query($query,$conn);
$row2=mysql_fetch_array($rs2);if(mysql_num_rows($rs2)!=0){$tienereqvisto=1;}else{$tienereqvisto=0;}mysql_free_result($rs2);	
//si est&aacute; emitida o finaliza elige solicitud, sino la solicitud no se puede modificar
if ( ($estorden==1 or  $estorden==7) and ($tienereqvisto==0) ){
	//solicitudes sin asignar, estado solicitado
	$query1="SELECT r.*,e.Nombre as Estado,rt.Nombre as TipoS From pedidosrep r,pedidosrep_est e,pedidosrep_tipo rt,pedidosrepreqsoli rr where r.IdEstado=e.Id and r.IdTipo=rt.Id and rr.IdPR=r.Id and r.IdOrden=0 and r.IdEstado=1 $where";
	//solicitud asignada a la orden
	$query2="SELECT r.*,e.Nombre as Estado,rt.Nombre as TipoS From pedidosrep r,pedidosrep_est e,pedidosrep_tipo rt where r.IdEstado=e.Id and r.IdTipo=rt.Id and r.Id<>0 and r.Id=$soli";
	$query="$query1 UNION $query2 Order by Id";$rs=mysql_query($query,$conn);
	$combo='<option value=""></option>';
}else{
	//solicitud asignada a la orden
	$query2="SELECT r.*,e.Nombre as Estado,rt.Nombre as TipoS From pedidosrep r,pedidosrep_est e,pedidosrep_tipo rt where r.IdEstado=e.Id and r.IdTipo=rt.Id and r.Id<>0 and r.Id=$soli";
	$query=$query2;$rs=mysql_query($query,$conn);
	$combo="";
}
//combo
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION['CbSoli']) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected";
   $combo .= "'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).'&nbsp;&nbsp;&nbsp;('.substr($row['Estado'],0,20).') '.substr($row['TipoS'],0,40)."</option>\n";
 }else{ $combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).'&nbsp;&nbsp;&nbsp;('.substr($row['Estado'],0,20).') '.substr($row['TipoS'],0,40)."</option>\n";   }}
echo $combo;mysql_free_result($rs);
}



function MostrarTablaReq($idpadre,$conn){ //pedidosrepreq IdPR join Id pedidosrepord
$query="SELECT rr.*,c.Nombre as Cat,e.Nombre as Estado,l.Nombre as ClaseN,t.Nombre as TipoN From pedidosrepreq rr,pedidosrepreq_cat c,pedidosrepreq_est e,pedidosrepreq_clase l,pedidosrepreq_tipo t  where rr.Id<>0 and rr.IdCat=c.Id and rr.IdEstado=e.Id and rr.Clase=l.Id and rr.Tipo=t.Id and rr.IdPR=$idpadre Order by l.Nombre,c.Nombre ";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT20"><tr ><td><i class="fa fa-tasks iconsmallsp iconlgray"></i> <strong>Acciones a Implementar:</strong></td></tr><tr> <td  align="center">';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato"."> Clase</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato"."> Tipo</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."> Ext</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Categoria</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."> Urg</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."150"." class="."TablaTituloDato"."> Observaciones</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."220"." class="."TablaTituloDato"."> Estado</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .='<td width="40" class="TablaTituloDato TAR">';
//si esta retirada no puede agregar acciones
if (intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
$tablaclientes .=GLO_FAButton('CmdAddReq','submit','','self','Agregar','add','iconbtn');}
$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarReq.php?Flag1=True"."&id=".$row['Id']."'";
	$urg='';$color='';	if($row['Urg']==1){$urg='Baja';} if($row['Urg']==2){$urg='Media';}
	if($row['Urg']==3){$urg='Alta';$color=' style="font-weight:bold;color:#f44336" ';}
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['ClaseN'],0,10)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['TipoN'],0,10)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_Si($row['Alcance'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cat'],0,12)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link.$color."> ".$urg."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Estado'],0,30)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .='<td  class="TablaDato TAR">';
	//si esta retirada no puede borrar 
	if (intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaReq",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	}
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
	$tablaclientes .='</tr>'; 
}mysql_free_result($rs);	
$tablaclientes .="</table></td></tr></table>"; 
echo $tablaclientes;	
}


function MostrarTablaEstados($idorden,$conn){//pedidosrep_hist historico cambios estado orden
$query="SELECT p.*,e.Nombre as Estado From pedidosrep_hist p, pedidosrepord_est e where p.IdEstado=e.Id and p.IdPR=$idorden and p.IdPR<>0 Order by p.Fecha";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT20"><tr ><td><i class="fa fa-traffic-light iconsmallsp iconlgray"></i> <strong>Estados Orden:</strong></td></tr><tr> <td  align="center">';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."175"." class="."TablaTituloDato"."> Estado</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."185"." class="."TablaTituloDato"."> Usuario</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."320"." class="."TablaTituloDato"."> Comentarios</td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarEPR.php?Flag1=True"."&id=".$row['Id']."'";
	//busco nombre comentario
	$query= "Select p.Nombre,p.Apellido From personal p,usuarios u Where p.Id=u.IdPersonal and u.Usuario='".$row['IdUsuario']."'";
	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$creadox=substr($row2['Apellido'].' '.$row2['Nombre'],0,22);} else{$creadox='';}mysql_free_result($rs2);
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Estado'],0,25)."</td>";
	$tablaclientes .="<td class="."TablaMostrarLeft"."></td>";  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".$creadox."</td>";
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase."> ".'<input type="text" readonly="true" class="TextBoxRO"  style="width:270px;border:none"  value="'.$row['Obs'].'">'."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarRight"."> </td></tr>";  
}mysql_free_result($rs);	
$tablaclientes .="</table></td></tr></table>"; 
echo $tablaclientes;	
}


function MostrarTablaReqSoli($idpadre,$conn){ //requerimientos de las solicitudes de la orden
$query="SELECT rr.* From pedidosrepreqsoli rr,pedidosrep pr where rr.Id<>0 and rr.IdPR=pr.Id and pr.IdOrden=$idpadre Order by rr.Fecha,rr.Obs ";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT5"><tr ><td><i class="fa fa-clipboard-list iconsmallsp iconlgray"></i> <strong>Requerimientos Solicitud:</strong></td></tr><tr> <td  align="center">';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."580"." class="."TablaTituloDato"."> Descripci&oacute;n</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."> Urg</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Estado</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDato"."> </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo="";$clase="TablaDato";$link="";$rojo=' style="font-weight:bold;color:#f44336;vertical-align:top" ';$verde=' style="font-weight:bold;color:#4CAF50;vertical-align:top" ';
while($row=mysql_fetch_array($rs)){ 
	$color=$rojo;$estado='Pdte';if($row['Estado']==1){$estado='Visto';$color=$verde;} 
	$urg='';if($row['Urg']==1){$urg='Baja';} if($row['Urg']==2){$urg='Media';}if($row['Urg']==3){$urg='Alta';}
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link.' style="vertical-align:top">'.FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link.' style="vertical-align:top">'.$row['Obs']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link.' style="vertical-align:top">'.$urg."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link.$color."> ".$estado."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	
	$tablaclientes .='<td  class="TablaDatoR">';
	if($row['Estado']==0){//pendiente
	$tablaclientes .=' <input name="CmdFilaVisto" type="submit"  class="botonseleccionar"  value="" id="'.$row['Id'].'" onclick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_self'".';">';
	}else{//visto
	$tablaclientes .=' <input name="CmdFilaPdte" type="submit"  class="botonseleccionar2"  value="" id="'.$row['Id'].'" onclick="document.Formulario.TxtId.value=this.id;document.Formulario.target='."'_self'".';">';
	}
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
	$tablaclientes .='</tr>'; 
}mysql_free_result($rs);	
$tablaclientes .="</table></td></tr></table>"; 
echo $tablaclientes;	
}



GLOF_Init('CbUnidad','BannerConMenuHV','zModificarOrden',0,'MenuH',0,0,0);
GLO_tituloypath(0,750,'Ordenes.php','ORDENES MANTENIMIENTO','linksalir'); 

include ("zCamposOrden.php");

if( intval($_SESSION['CbSoli'])!=0){include ("zCamposOrdenSoli.php");}else{include ("zCamposOrdenSoliSIN.php");}?>


<!-- aceptar -->
<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td height="3"  width="175"></td><td width="400"></td><td width="175"></td></tr>
<tr> <td></td><td align="center" valign="middle" ><input name="CmdAceptar" type="submit" class="boton" tabindex="4"  value="Guardar" onClick="document.Formulario.target='_self'"></td><td align="right"><? if ( (intval($_SESSION['TxtNumero'])!=0)  and (intval($_SESSION['CbSoli'])!=0)   and (intval($_SESSION['TxtIdEstadoO'])!=7)){ echo '<input name="CmdControl" type="submit" class="boton02" style="width:90px" value="Planilla Control" onClick="document.Formulario.target='."'_self'".'">';} ?>&nbsp;</td><td></td></tr>
</table>



<? 
//mensajes
if($_SESSION['TxtIdAccCumpl']==1 and $_SESSION['TxtFecha4']=='')
{echo '<label class="MuestraError">Por favor complete la Fecha a Retirar</label> ';} 
GLO_exportarform(750,0,0,1,0,0);
GLO_mensajeerror();

// si no es solicitud rechazada
if (intval($_SESSION['TxtIdEstadoO'])!=7){
	MostrarTablaReqSoli($_SESSION['TxtNumero'],$conn);
	MostrarTablaReq($_SESSION['TxtNumero'],$conn);
	REP_TablaAct($_SESSION['TxtNumero'],$conn,1);//tareas de las acciones de esta orden
}
MostrarTablaEstados($_SESSION['TxtNumero'],$conn);

GLO_cierratablaform(); 
mysql_close($conn); 
$_SESSION['TxtOriPage'] = "";

GLO_initcomment(750,0);
echo 'Complete la <font class="comentario2">Planilla de Control</font> y genere las <font class="comentario3">Acciones</font> necesarias<br>';
echo 'Marque los <font class="comentario3">Requerimientos</font> terminados y finalice las <font class="comentario3">Acciones</font><br>';
echo 'Seleccione el boton <font class="comentario2">Entregar</font> Unidad<br>';
echo 'S&oacute;lo es posible cambiar la <font class="comentario3">Solicitud</font>, si la <font class="comentario2">Orden</font> est&aacute; EMITIDA o FINALIZADA SIN ACCION';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>