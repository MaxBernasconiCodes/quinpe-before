<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

function CAM_BuscaEstado($var){
$res='';
if($var==1){$res='APROBADO';}
if($var==2){$res='RECHAZADO';}
return $res;
}

function CAM_BuscaPrioridad($var){
$res='';
if($var==1){$res='ALTA';}
if($var==2){$res='MEDIA';}
if($var==3){$res='BAJA';}
return $res;
}

function CAM_BuscaRes($var){
$res='';
if($var==1){$res='ACEPTADO';}
if($var==2){$res='RECHAZADO';}
return $res;
}
function CAM_ComboEstado($campo){
$combo="";
if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."APROBADO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."APROBADO"."</option>\n";}
if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."RECHAZADO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."RECHAZADO"."</option>\n";}
echo $combo;
}

function CAM_ComboPrioridad($campo){
$combo="";
if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."ALTA"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."ALTA"."</option>\n";}
if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."MEDIA"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."MEDIA"."</option>\n";}
if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."BAJA"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."BAJA"."</option>\n";}
echo $combo;
}

function CAM_ComboResolucion($campo){
$combo="";
if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."ACEPTADO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."ACEPTADO"."</option>\n";}
if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."RECHAZADO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."RECHAZADO"."</option>\n";}
echo $combo;
}
function CAM_TablaTipo($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,p.Nombre as Tipo From iso_cambios_t1 m,iso_cambios_tipo p where m.IdTipo=p.Id and m.IdPadre=$idpadre Order by p.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."710"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Tipo de Cambio</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".' >'.GLO_FAButton('CmdAddT','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo="";$link="";
while($row=mysql_fetch_array($rs)){
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Tipo'],0,70)."</td>";	 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaT",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}

function CAM_TablaAsistentes($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From iso_cambios_r1 m,personal p where m.IdPersonal=p.Id and m.IdPadre=$idpadre Order by p.Apellido,p.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."710"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Integrantes del equipo de evaluacion</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".' >'.GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo="";$link="";
while($row=mysql_fetch_array($rs)){
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Ap'].' '.$row['Nom'],0,70)."</td>";	 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}
function CAM_TablaActividades($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From iso_cambios_plan m,personal p where m.IdPersonal=p.Id and m.IdPadre=$idpadre Order by m.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."480"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Actividades Pendientes</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Responsable</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Fecha</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Estado</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".'>'.GLO_FAButton('CmdAddP','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' "; $cont=0; 
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarPendiente.php?Flag1=True"."&id=".$row['Id']."'";
	if($row['Estado']==0){$estado='Pendiente';$colorestado=' style="color:#f44336;vertical-align:top"';}
	else{$estado='Realizada';$colorestado=' style="color:#00bcd4;vertical-align:top"';}
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="white-space:normal;"'."> ".substr($row['Obs'],0,200)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="vertical-align:top"'." > ".substr($row['Ap'].' '.$row['Nom'],0,12)."</td>";
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>"; 
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="vertical-align:top"'."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>"; 
	$tablaclientes .="<td  class="."TablaDato ".$link.$colorestado."> ".$estado."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaP",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}


?>