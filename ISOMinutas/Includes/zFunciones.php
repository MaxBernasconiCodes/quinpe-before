<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


function MIN_TablaAsistentes($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,s.Nombre as Sector,p.Nombre as Nom,p.Apellido as Ap From iso_minutas_as m,sector s,personal p where m.IdSector=s.Id and m.IdPersonal=p.Id and m.IdMin=$idpadre Order by m.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."20"." class="."TablaTituloDato"."> </td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."530"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Asistentes</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."160"." class="."TablaTituloDato"."> Sector</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".' >'.GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";  $cont=0; 
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarAsistente.php?Flag1=True"."&id=".$row['Id']."'";
	$cont=$cont+1;  
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="text-align:center;vertical-align:top"'." > ".$cont."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	//si carga personal lo muestra, sino muestra texto
	if($row['IdPersonal']==0){$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Nombre'],0,60)."</td>";}
	else{$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Ap'].' '.$row['Nom'],0,60)."</td>";}		 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Sector'],0,20)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}

function MIN_TablaDesarrollo ($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.* From iso_minutas_des m where m.IdMin=$idpadre Order by m.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."20"." class="."TablaTituloDato"."> </td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."690"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Actividades Desarrolladas</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".'>'.GLO_FAButton('CmdAddD','submit','','self','Agregar','add','iconbtn').'</td>';  
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";  $cont=0; 
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarDesarrollo.php?Flag1=True"."&id=".$row['Id']."'";
	$cont=$cont+1; 
	$tablaclientes .='<tr '.$estilo.'>'; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="text-align:center;vertical-align:top"'." > ".$cont."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="white-space:normal;"'."> ".substr($row['Obs'],0,300)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaD",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}


function MIN_TablaPendientes($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT m.*,p.Nombre as Nom,p.Apellido as Ap From iso_minutas_pd m,personal p where m.IdPersonal=p.Id and m.IdMin=$idpadre Order by m.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."20"." class="."TablaTituloDato"."> </td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."500"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Actividades Pendientes</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Responsable</td>";   
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".' style="font-weight:bold;"'."> Estado</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>"; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".'>'.GLO_FAButton('CmdAddP','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>"; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' "; $cont=0; 
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='ModificarPendiente.php?Flag1=True"."&id=".$row['Id']."'";
	//estado
	if($row['Estado']==0){$estado='Pendiente';$colorestado=' style="color:#f44336;vertical-align:top"';}
	if($row['Estado']==1){$estado='Realizada';$colorestado=' style="color:#00bcd4;vertical-align:top"';}
	if($row['Estado']==2){$estado='Cancelada';$colorestado=' style="color:#cc0099;vertical-align:top"';}
	//
	$cont=$cont+1; 
	$tablaclientes .='<tr '.$estilo.'>';
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="text-align:center;vertical-align:top"'." > ".$cont."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato ".$link.' style="white-space:normal;"'."> ".substr($row['Obs'],0,200)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	//si carga personal lo muestra, sino muestra texto
	if($row['IdPersonal']==0){$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Nombre'],0,15)."</td>";}
	else{$tablaclientes .="<td  class="."TablaDato ".$link." > ".substr($row['Ap'].' '.$row['Nom'],0,15)."</td>";}		 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>"; 
	$tablaclientes .="<td  class="."TablaDato ".$link.$colorestado."> ".$estado."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	//realizada
	if( $row['Estado']==0){
		$tablaclientes .='<input name="CmdConfFila" type="submit"  class="botonseleccionar" title="Realizada" value=""  id="'.$row['Id'].'"  onclick="document.Formulario.TxtId.value=this.id;">&nbsp;'; 
	}
	//borrar
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaP",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}





?>

