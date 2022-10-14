<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$_SESSION['TxtOriPage'] = intval($_GET['ori']);
	$query="SELECT r.*,u.Dominio,o.FechaI,o.FechaE,o.Obs,e.Nombre as EstadoS From pedidosrep r,unidades u,pedidosrepord o,pedidosrep_est e where r.Id<>0 and r.IdUnidad=u.Id and r.IdOrden=o.Id and r.IdEstado=e.Id and r.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFecha1'] = GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtFecha2'] = GLO_FormatoFecha($row['FechaSI']);
		$_SESSION['TxtFecha3'] = GLO_FormatoFecha($row['FechaI']);
		$_SESSION['TxtFecha4'] = GLO_FormatoFecha($row['FechaE']);
		$_SESSION['CbUnidad'] = $row['IdUnidad'];
		$_SESSION['CbSector'] = $row['IdSector'];
		$_SESSION['CbInstrumento'] = $row['IdInstr'];
		$_SESSION['TxtEstadoS'] =$row['EstadoS'];
		$_SESSION['TxtIdEstadoS'] =$row['IdEstado'];
		$_SESSION['TxtDominio'] = $row['Dominio'];
		$_SESSION['CbTipo'] = $row['IdTipo'];
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['CbPersonal'] = $row['IdPersonal'];
		//fecha limite +5 dias
		if (!(empty($_SESSION['TxtFecha3']))){ 
			$fecha3=$_SESSION['TxtFecha3'];$_SESSION['TxtFecha5']=date("d-m-Y", strtotime("$fecha3 +5 day"));	
		}
		//orden
		if($row['IdOrden']!=0){$_SESSION['TxtIdOrden'] = str_pad($row['IdOrden'], 6, "0", STR_PAD_LEFT);}else{$_SESSION['TxtIdOrden'] = '';}
	
	}mysql_free_result($rs);
	//verifico si tiene requerimientos cargados
	$query="SELECT rr.Id From pedidosrepreqsoli rr where rr.Id<>0 and rr.IdPR=".intval($_SESSION['TxtNumero']);$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)==0){$_SESSION['TxtTieneReq']=0;}else{$_SESSION['TxtTieneReq']=1;}mysql_free_result($rs);
} 


function MostrarTablaTaller($idpadre,$conn){
//Titulos de la tabla
$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT20"><tr ><td><i class="fa fa-tools iconsmallsp iconlgray"></i> <strong>Taller:</strong></td></tr><tr> <td  align="center">';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> Orden</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> F.Ingresar</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> F.L&iacute;mite</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> F.Retirar</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."480"." class="."TablaTituloDato"."> Comentarios</td>";  
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo="";$clase="TablaDato";$link="";
//datos
$tablaclientes .='<tr '.$estilo.'>';  
$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
$tablaclientes .="<td  class="."TablaDato".$link." style='text-align:right;'> ".$_SESSION['TxtIdOrden']."</td>"; 
$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
$tablaclientes .="<td  class="."TablaDato".$link."> ".$_SESSION['TxtFecha3']."</td>"; 
$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
$tablaclientes .="<td  class="."TablaDato".$link."> ".$_SESSION['TxtFecha5']."</td>"; 
$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
$tablaclientes .="<td  class="."TablaDato".$link."> ".$_SESSION['TxtFecha4']."</td>"; 
$tablaclientes .='<td class="TablaMostrarLeft"></td>';   
$tablaclientes .="<td  class="."TablaDato".$link."> ".'<input name="TxtObs" type="text" readonly="true" class="TextBoxRO"  style="width:430px;border:none"  value="'.$_SESSION['TxtObs'].'">'."</td>"; 
$tablaclientes .="<td class="."TablaMostrarRight"."> </td></tr>";  
//cierro	
$tablaclientes .="</table></td></tr></table>"; 
echo $tablaclientes;	
}



function MostrarTablaEstados($idorden,$conn){//pedidosrep_hist historico cambios estado orden
$query="SELECT p.*,e.Nombre as Estado From pedidosrep_hist p, pedidosrepord_est e where p.IdEstado=e.Id and p.IdPR<>0 and p.IdPR=$idorden Order by p.Fecha";$rs=mysql_query($query,$conn);
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
$estilo="";$clase="TablaDato";$link="";
while($row=mysql_fetch_array($rs)){	
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


function MostrarTablaReqSoli($idpadre,$conn){ 
$query="SELECT rr.* From pedidosrepreqsoli rr where rr.Id<>0 and rr.IdPR=$idpadre Order by rr.Fecha,rr.Obs ";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT5"><tr ><td><i class="fa fa-clipboard-list iconsmallsp iconlgray"></i> <strong>Requerimientos:</strong></td></tr><tr> <td  align="center">';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."550"." class="."TablaTituloDato"."> Descripci&oacute;n</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."40"." class="."TablaTituloDato"."> Urg</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Estado</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .='<td width="40" class="TablaTituloDato TAR">';
if(intval($_SESSION['TxtIdOrden'])==0 and intval($_SESSION['TxtIdEstadoS'])==1 ){$tablaclientes .=GLO_FAButton('CmdAddReqSoli','submit','','self','Agregar','add','iconbtn');}//agrega si orden=0 
$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$clase="TablaDato";$rojo=' style="font-weight:bold;color:#f44336;vertical-align:top" ';$verde=' style="font-weight:bold;color:#4CAF50;vertical-align:top" ';
while($row=mysql_fetch_array($rs)){ 
	//modifica si orden=0
	if(intval($_SESSION['TxtIdOrden'])==0  and intval($_SESSION['TxtIdEstadoS'])==1){
	$link=" onclick="."location='ModificarReqSoli.php?Flag1=True"."&id=".$row['Id']."'";$estilo=" style='cursor:pointer;' ";}
	else{$link="";$estilo="";}
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
	if(intval($_SESSION['TxtIdOrden'])==0  and intval($_SESSION['TxtIdEstadoS'])==1){//elimina si orden=0
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaReqSoli",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	}
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
	$tablaclientes .='</tr>'; 
}mysql_free_result($rs);
$tablaclientes .="</table></td></tr></table>"; 
echo $tablaclientes;	
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
$tablaclientes .="<td "."width="."230"." class="."TablaTituloDato"."> Observaciones</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."220"." class="."TablaTituloDato"."> Estado</td>";   
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo="";$clase="TablaDato";$link="";
while($row=mysql_fetch_array($rs)){ 
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['ClaseN'],0,10)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['TipoN'],0,10)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_SiNo($row['Alcance'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cat'],0,12)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,30)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Estado'],0,30)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; 
}mysql_free_result($rs);
$tablaclientes .="</table></td></tr></table>"; 
echo $tablaclientes;	
}



function MostrarTablaInsumos($idpadre,$conn){
$query="SELECT r.*,a.Nombre as Articulo,um.Abr From pedidosrepreq_ins r,pedidosrepreq rr,epparticulos a,unidadesmedida um where r.Id<>0 and r.IdArti=a.Id and a.IdUnidad=um.Id and r.IdPRR=rr.Id and rr.IdPR=$idpadre Order by a.Nombre  ";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT20"><tr ><td><i class="fa fa-toolbox iconsmallsp iconlgray"></i> <strong>Repuestos/Insumos:</strong></td></tr><tr> <td  align="center">';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."400"." class="."TablaTituloDato"."> Repuesto/Insumo</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato"."></td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> Cantidad</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"." >PSI</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato".">MIM</td>";   
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo="";$clase="TablaDato";$link="";
while($row=mysql_fetch_array($rs)){ 
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['IdArti'], 6, "0", STR_PAD_LEFT).' '.substr($row['Articulo'],0,30)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Abr'],0,5)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$row['Cant']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['PSI'], 6, "0", STR_PAD_LEFT).' '.GLO_FormatoFecha($row['FechaPSI'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['MIM'], 6, "0", STR_PAD_LEFT).' '.GLO_FormatoFecha($row['FechaMIM'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; 
}mysql_free_result($rs);	
$tablaclientes .="</table></td></tr></table>"; 
echo $tablaclientes;	
}


GLOF_Init('CbUnidad','BannerConMenuHV','zModificar',0,'MenuH',0,0,0);
GLO_tituloypath(0,750,'','SOLICITUDES MANTENIMIENTO','salir'); 

include ("zCampos.php");
GLO_mensajeerror();

//tablas
MostrarTablaReqSoli($_SESSION['TxtNumero'],$conn);
MostrarTablaTaller($_SESSION['TxtNumero'],$conn); 

//si tiene orden asociada y no esta rechazada
if (intval($_SESSION['TxtIdOrden'])!=0  and  intval($_SESSION['TxtIdEstadoS'])!=2){
	MostrarTablaReq($_SESSION['TxtIdOrden'],$conn);
	REP_TablaAct($_SESSION['TxtIdOrden'],$conn,1);//tareas de las acciones de esta orden
	MostrarTablaInsumos($_SESSION['TxtIdOrden'],$conn);
}

MostrarTablaEstados(intval($_SESSION['TxtIdOrden']),$conn);

GLO_cierratablaform();
mysql_close($conn);
$_SESSION['TxtOriPage'] = "";

GLO_initcomment(750,0);
echo 'Registre los <font class="comentario2">Requerimientos</font> de la <font class="comentario3">Solicitud</font><br>';
echo 'No podr&aacute; modificarse la <font class="comentario2">Solicitud</font> si tiene <font class="comentario3">Orden</font> asociada';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>