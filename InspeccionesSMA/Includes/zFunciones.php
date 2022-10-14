<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



function MostrarTablaVtosSMA($idpadre,$conn){ 
$query="SELECT v.*,t.Nombre as Tipo From personalvtos v,personalvtos_tipos t where v.Id<>0 and v.IdTipo=t.Id and v.IdEntidad=".$idpadre." Order by v.Inactivo,t.Nombre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."530"." class="."TablaTituloDato"."> Habilitaci&oacute;n</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Emisi&oacute;n</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Vto</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .='<td "."width="40" class="TablaTituloDato" title="Requerido"> Req</td>';   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .='<td "."width="40" class="TablaTituloDato" title="Inactivo"> Inac</td>';   
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo="";$link="";
while($row=mysql_fetch_array($rs)){ 
	$fvto= GLO_FormatoFecha($row['Fecha']);	
	if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0 and ($row['Inactivo']==0) ){$color=' style="font-weight:bold;color:#f44336"';}else{$color='';}  
	if($row['Inactivo']==0){$clase="TablaDato";}else{$clase="TablaDatoR2";}
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,50)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaE'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link.$color."> ".$fvto."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_Si($row['Req'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_Si($row['Inactivo'])."</td>"; 
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}


function MostrarTablaItemsInsp($idpadre,$conn){ 
$query="SELECT d.*, e.Nombre as Estado,p.Nombre,p.Apellido From inspecciones_det d,inspecciones_det_est e,personal p where d.IdEstado=e.id and d.Id<>0 and p.Id=d.IdPersonal and d.IdInsp=$idpadre Order by d.Fecha, p.Apellido,p.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" class="TableShow" id="tshow"><tr>';
$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
$tablaclientes .="<td "."width="."350"." class="."TableShowT"."> Detalle</td>";   
$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> Responsable</td>"; 
$tablaclientes .="<td "."width="."110"." class="."TableShowT"."> Estado</td>"; 
$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Cumpl.</td>";   
$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddD','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='</tr>';             
$recuento=0; $estilo=" style='cursor:pointer;'";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarD.php?Flag1=True"."&id=".$row['Id']."'";
	if($row['IdEstado']==1){$claseestado=' TGreen';}else{$claseestado=' TRed';}//1 cumplido, 2 pendiente
	//
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Obs'],0,42)."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Apellido'].' '.$row['Nombre'],0,12)."</td>"; 
	$tablaclientes .='<td class="TableShowD'.$claseestado.'"'.$link.'>'.substr($row['Estado'],0,12)."</td>";  
	$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha2'])."</td>"; 
	$tablaclientes .='<td class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaD",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
	$tablaclientes .='</tr>'; 
	$recuento=$recuento+1;
}	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}

?>