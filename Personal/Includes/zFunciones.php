<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

function PE_CbContrato($campo){
	$combo="";
	if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."PERMANENTE"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PERMANENTE"."</option>\n";}
	if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."'2'"." selected='selected'>"."PLAZO FIJO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."PLAZO FIJO"."</option>\n";}
	if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."'3'"." selected='selected'>"."A PRUEBA"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."A PRUEBA"."</option>\n";}
	echo $combo;
}


function PE_ComboOrden(){
$combo="";
if( "p.Apellido,p.Nombre" == $_SESSION['CbOrden']) { $combo .= " <option value="."'p.Apellido,p.Nombre'"." selected='selected'>"."APELLIDO"."</option>\n";}else{$combo .= " <option value="."'p.Apellido,p.Nombre'"." >"."APELLIDO"."</option>\n";}
if( "p.FechaAlta,p.Apellido,p.Nombre" == $_SESSION['CbOrden']) { $combo .= " <option value="."'p.FechaAlta,p.Apellido,p.Nombre'"." selected='selected'>"."FECHA ALTA"."</option>\n";}else{$combo .= " <option value="."'p.FechaAlta,p.Apellido,p.Nombre'"." >"."FECHA ALTA"."</option>\n";}
if( "p.Legajo,p.Apellido,p.Nombre" == $_SESSION['CbOrden']) { $combo .= " <option value="."'p.Legajo,p.Apellido,p.Nombre'"." selected='selected'>"."LEGAJO"."</option>\n";}else{$combo .= " <option value="."'p.Legajo,p.Apellido,p.Nombre'"." >"."LEGAJO"."</option>\n";}
if( "l.Nombre,p.Apellido,p.Nombre" == $_SESSION['CbOrden']) { $combo .= " <option value="."'l.Nombre,p.Apellido,p.Nombre'"." selected='selected'>"."LOCALIDAD"."</option>\n";}else{$combo .= " <option value="."'l.Nombre,p.Apellido,p.Nombre'"." >"."LOCALIDAD"."</option>\n";}
if( "rs.Nombre,p.Apellido,p.Nombre" == $_SESSION['CbOrden']) { $combo .= " <option value="."'rs.Nombre,p.Apellido,p.Nombre'"." selected='selected'>"."RAZON SOCIAL"."</option>\n";}else{$combo .= " <option value="."'rs.Nombre,p.Apellido,p.Nombre'"." >"."RAZON SOCIAL"."</option>\n";}
echo $combo;
}


function MostrarTablaDesemp($idpadre,$conn){ 
$query="SELECT v.*,vv.Nombre as Tipo,p.Nombre,p.Apellido From personal_des v,personal_destipo vv,personal p where v.IdTipo=vv.Id and v.IdPersonal=p.Id and v.Id<>0 and v.IdEntidad=$idpadre Order by v.Fecha,p.Apellido,p.Nombre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Novedad</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Observador</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."240"." class="."TablaTituloDato"."> Comentario</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddDes','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarDes.php?Flag1=True"."&id=".$row['Id']."'";	
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Apellido'].' '.$row['Nombre'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,30)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaDes",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}
 
 
function MostrarTablaCargasF($idpadre,$conn){ 
$query="SELECT v.*,vv.Nombre as Tipo From personal_cargas v,personal_cargastipo vv where v.IdTipo=vv.Id and v.Id<>0 and v.IdEntidad=$idpadre Order by v.Apellido,v.Nombre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"."> Apellido</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"."> Nombre</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato"."> CUIL</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Desde</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Hasta</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> D.IIGG</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Tipo</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddCF','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarCF.php?Flag1=True"."&id=".$row['Id']."'";	
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Apellido'],0,12)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,12)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['CUIL'],0,15)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_SiNo($row['IIGG'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,12)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaCF",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);

}

 
function MostrarTablaTelefonos($idpadre,$conn){ 
$query="SELECT * From personaltelefonos where Id<>0 and IdEntidad=$idpadre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Area</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"."> N&uacute;mero</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';  
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Interno</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."450"." class="."TablaTituloDato"."> Observaciones</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR"."> "; 
$tablaclientes .=GLO_FAButton('CmdAddT','submit','','self','Agregar','add','iconbtn');
$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";
while($row=mysql_fetch_array($rs)){ 	
	$link=" onclick="."location='ModificarTelefono.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['CodigoArea'],0,10)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['NumeroTelefono'],0,25)."</td>";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Interno'],0,10)."</td>";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Observaciones'],0,75)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaT",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
//Mostrar tabla
echo $tablaclientes;	
//Cierra consulta
mysql_free_result($rs);
}




function MostrarTablaArchivos($idpadre,$conn){
$query="SELECT * From personalarchivos where IdEntidad=$idpadre Order by Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Archivo</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."660"." class="."TablaTituloDato"."> Descripci&oacute;n</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."60"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Descripcion'],0,100)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdVerFile",$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);  
	$tablaclientes .=' '.GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);  
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);

}

function MostrarTablaComentarios($idpadre,$conn){
$query="SELECT * From personalcomentarios where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."160"." class="."TablaTituloDato"."> Usuario</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."550"." class="."TablaTituloDato"."> Comentario</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR"."> "; 
$tablaclientes .=GLO_FAButton('CmdAddC','submit','','self','Agregar','add','iconbtn');
$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	//busco nombre comentario
	$query= "Select p.Nombre,p.Apellido From personal p,usuarios u Where p.Id=u.IdPersonal and u.Usuario='".$row['IdUsuario']."'";
	$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
	if(mysql_num_rows($rs2)!=0){$creadox=substr($row2['Apellido'].' '.$row2['Nombre'],0,11);} else{$creadox='';}
	mysql_free_result($rs2);
	$estilo=" style='cursor:pointer;' ";
	$link=" onclick="."location='ModificarComentario.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".$creadox.' '.FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Comentario'],0,85)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaC",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);
}



function MostrarTablaAntecedentes($idpadre,$conn){ 
$query="SELECT v.* From personal_antec v where v.Id<>0 and v.IdEntidad=".$idpadre." Order by v.FechaD";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Desde</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Hasta</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."290"." class="."TablaTituloDato"."> Organizaci&oacute;n</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."280"." class="."TablaTituloDato"."> Detalle</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddAntec','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarAntec.php?Flag1=True"."&id=".$row['Id']."'";	
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Org'],0,35)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,35)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaAntec",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}
 
function MostrarTablaVtos($idpadre,$conn){ 
$query="SELECT v.*,t.Nombre as Tipo From personalvtos v,personalvtos_tipos t where v.Id<>0 and v.IdTipo=t.Id and v.IdEntidad=".$idpadre." Order by v.Inactivo,t.Nombre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."490"." class="."TablaTituloDato"."> Habilitaci&oacute;n</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Emisi&oacute;n</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Vto</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .='<td "."width="40" class="TablaTituloDato" title="Requerido"> Req</td>';   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .='<td "."width="40" class="TablaTituloDato" title="Inactivo"> Inac</td>';   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddVto','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;'";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarVto.php?Flag1=True"."&id=".$row['Id']."'";
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
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaVto",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}


function MostrarTablaTalles($idpadre,$conn){ 
$query="SELECT v.*,t.Nombre as Tipo From personaltalles v,personaltalles_el t where v.Id<>0 and v.IdElem=t.Id and v.IdEntidad=".$idpadre." Order by t.Nombre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."220"." class="."TablaTituloDato"."> Elemento</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."110"." class="."TablaTituloDato"."> Talle</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."380"." class="."TablaTituloDato"."> Observaciones</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddTalle','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarTalle.php?Flag1=True"."&id=".$row['Id']."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,25)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Talle'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,40)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaTalle",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}

function MostrarTablaExpI($idpadre,$conn){ 
$query="SELECT v.*,s.Nombre as Sector From personal_expi v,sector s where v.Id<>0 and v.IdSector=s.id and v.IdEntidad=$idpadre Order by v.FechaD";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Desde</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Hasta</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."220"." class="."TablaTituloDato"."> Sector</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDatoR"."> Puntos</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."280"." class="."TablaTituloDato"."> Detalle</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddEI','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarEI.php?Flag1=True"."&id=".$row['Id']."'";	
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,26)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class="."TablaDatoR".$link."> ".$row['Puntos']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,35)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaEI",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}

function MostrarTablaLic($idpadre,$conn){ 
$query="SELECT v.*,s.Nombre as Tipo From personal_lic v,personal_lictipo s where v.Id<>0 and v.IdTipo=s.id and v.IdEntidad=$idpadre Order by v.FechaD";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" class="TableShow" id="tshow"><tr>';
$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Desde</td>";   
$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Hasta</td>";   
$tablaclientes .='<td width="40" class="TableShowT TAR"> Dias</td>';   
$tablaclientes .='<td width="220" class="TableShowT"> Tipo</td>';   
$tablaclientes .="<td "."width="."310"." class="."TableShowT"."> Detalle</td>";   
$tablaclientes .='<td width="40" class="TableShowT TAR">'; 
$tablaclientes .=GLO_FAButton('CmdAddLic','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td></tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TableShowD";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarLic.php?Flag1=True"."&id=".$row['Id']."'";
	$fechad=GLO_FormatoFecha($row['FechaD']);	
	$fechah=GLO_FormatoFecha($row['FechaH']);
	//dias de licencia tomados
	$dias='';
	if( $fechad!='' and $fechah!='' ){
		if( CompararFechas($fechad,$fechah)!=1 ){ $dias= dias_transcurridos_2($fechad,$fechah); }
	}
	//
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .="<td class=".$clase.$link."> ".$fechad."</td>"; 
	$tablaclientes .="<td class=".$clase.$link."> ".$fechah."</td>"; 
	$tablaclientes .='<td class="TableShowD TAR"'.$link."> ".$dias."</td>"; 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,26)."</td>"; 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,40)."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR">';
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaLic",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td></tr>'; 
}mysql_free_result($rs);	
$tablaclientes .="</table>"; 
echo $tablaclientes;	
}



function MostrarTablaAcad($idpadre,$conn){ 
$query="SELECT v.*,s.Nombre as Tipo From personal_acad v,estudios s where v.Id<>0 and v.IdTipo=s.id and v.IdEntidad=$idpadre Order by v.FechaD";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Desde</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Hasta</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."220"." class="."TablaTituloDato"."> Estudios</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDatoR"."> Promedio</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."280"." class="."TablaTituloDato"."> Titulo</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">"; 
$tablaclientes .=GLO_FAButton('CmdAddAcad','submit','','self','Agregar','add','iconbtn');
$tablaclientes .=' </td><td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarAcad.php?Flag1=True"."&id=".$row['Id']."'";	
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Tipo'],0,26)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class="."TablaDatoR".$link."> ".$row['Puntos']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs3'],0,35)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaAcad",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	$tablaclientes .='</td><td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}


function MostrarTablaCap($idpadre,$conn){ 
//filtro
if (!(empty($_SESSION['TxtFechaD']))){$wfechad="and DATEDIFF(c.FechaProg,'".FechaMySql($_SESSION['TxtFechaD'])."')>=0";}else{$wfechad="";}
if (!(empty($_SESSION['TxtFechaH']))){$wfechah="and DATEDIFF(c.FechaProg,'".FechaMySql($_SESSION['TxtFechaH'])."')<=0";}else{$wfechah="";}	
//query
$query="Select c.*,cc.Titulo,cc.Duracion From cursosprogramacion c,cursos cc  Where c.IdPersonal=$idpadre and c.IdCurso=cc.Id  $wfechad $wfechah Order by  c.FechaProg";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>';
$tablaclientes .='<table width="750" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Prog</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Realiz</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."560"." class="."TablaTituloDato"."> Curso</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDatoR"."> Puntos</td>";   
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo="";$clase="TablaDato";$link="";
while($row=mysql_fetch_array($rs)){ 
	if($row['FechaProg']!='0000-00-00'){$fechap =FechaMesYear($row['FechaProg']);}else{$fechap='';}
	if($row['FechaReal']!='0000-00-00'){$fechar =FechaMesYear( $row['FechaReal']);}else{$fechar='';}
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".$fechap."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".$fechar."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Titulo'],0,55)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
	$tablaclientes .="<td class="."TablaDatoR".$link."> ".$row['Evaluacion']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);

}
?>