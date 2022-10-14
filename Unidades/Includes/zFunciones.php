<?
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



function UNI_Cubiertas($idpadre,$conn){//idpadre es id unidad 
	$query="SELECT a.*,t.Nombre as Marca From unidades_cubiertas a,unidades_marcascub t where a.Id<>0 and  t.Id=a.IdMarca and a.IdUnidad=$idpadre Order by a.Fecha";$rs=mysql_query($query,$conn);
	//tabla
	$tablaclientes='';
	$tablaclientes .='<table width="730" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
	$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Marca</td>";  
	$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Cant</td>";
	$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Medida</td>";  
	$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Odom</td>";
	$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Km Rec</td>";   
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Alin</td>"; 
	$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Balan</td>"; 
	$tablaclientes .="<td "."width="."170"." class="."TableShowT".">Ubicacion reemplazo</td>";  
	$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddCub','submit','','self','Agregar','add','iconbtn')."</td>"; 
	$tablaclientes .='</tr>';        
	$estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarCub.php?Flag1=True"."&id=".$row['Id']."'";
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Marca'],0,12)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".$row['Cant']."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Med'],0,12)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".$row['Odo']."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".$row['KmR']."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_Si($row['Ali'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_Si($row['Bal'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['UbiR'],0,18)."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR">';
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaCub",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
		$tablaclientes .='</td></tr>'; 
		$tablaclientes .='</tr>'; 
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;
}



function UNI_AccesoriosAsignados($idpadre,$conn){//idpadre es id unidad (sin devolver)
	$query="SELECT a.*,i.Nombre,t.Nombre as Elem From accesorios_asig a,accesorios i,accesorios_tipo t where a.Id<>0 and i.Id=a.IdInstrumento and t.Id=i.IdElemento and a.IdUnidad=$idpadre and FechaH='0000-00-00' Order by a.FechaD";$rs=mysql_query($query,$conn);
	//tabla
	$tablaclientes='';
	$tablaclientes .='<table width="730" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."220"." class="."TableShowT"."> Accesorio</td>";   
	$tablaclientes .="<td "."width="."300"." class="."TableShowT".">Elemento</td>";  
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Desde</td>"; 
	$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Observaciones</td>";  
	$tablaclientes .='<td width="40" class="TableShowT TAR"></td>'; 
	$tablaclientes .='</tr>';        
	$recuento=0; $estilo="";$link="";
	while($row=mysql_fetch_array($rs)){ 
		if($row['TIndef']==1){$ti='Tiempo indefinido';}else{$ti='';}
		//
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class="."TableShowD".$link."> ".str_pad($row['IdInstrumento'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,20)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Elem'],0,36)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".$ti."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR"></td>';  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;
}


function Uni_MostrarUniAcc($idpadre,$conn){
	$query="SELECT ua.Id,ua.IdUniAcc,u.Dominio,u.Modelo,m.Nombre as Marca,ca.Nombre as Categ From unidades_acc ua,unidades u,unidadesmarcas m,unidadescateg ca where ua.IdUniAcc=u.Id and u.IdMarca=m.Id and u.IdCateg=ca.Id and ua.IdUnidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="730" border="0" cellspacing="0" cellpadding="0" ><tr>';
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'> N&uacute;mero</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Dominio</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"."> Categor&iacute;a</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Marca</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Modelo</td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddUA','submit','','self','Agregar','add','iconbtn')."</td>"; 
	$tablaclientes .='<td class="TablaTituloRight"></td>';  
	$tablaclientes .='</tr>';             
	$estilo="";$link="";
	while($row=mysql_fetch_array($rs)){
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class="."TablaDato".$link." style='text-align:right;'> ".str_pad($row['IdUniAcc'], 6, "0", STR_PAD_LEFT)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Dominio'],0,12)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Categ'],0,12)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Marca'],0,20)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Modelo'],0,20)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDatoR".">";
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaUA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
		$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
	}	
	$tablaclientes .="</table>";echo $tablaclientes;	
	mysql_free_result($rs);
}


function Uni_MostrarComentarios($idpadre,$conn){
	$query="SELECT * From unidadescomentarios where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="730" border="0" cellspacing="0" cellpadding="0" ><tr>';
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."160"." class="."TablaTituloDato"."> Usuario</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td "."width="."530"." class="."TablaTituloDato"."> Comentario</td>";  
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddC','submit','','self','Agregar','add','iconbtn')."</td>"; 
	$tablaclientes .='<td class="TablaTituloRight"></td>';  
	$tablaclientes .='</tr>';             
	$estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){
		//busco nombre comentario
		$query= "Select p.Nombre,p.Apellido From personal p,usuarios u Where p.Id=u.IdPersonal and u.Usuario='".$row['IdUsuario']."'";
		$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){$creadox=substr($row2['Apellido'].' '.$row2['Nombre'],0,11);} else{$creadox='';}
		mysql_free_result($rs2);	
		$link=" onclick="."location='ModificarComentario.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDato".$link."> ".$creadox.' '.FormatoFecha($row['Fecha'])."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDato".$link."> ".substr($row['Comentario'],0,75)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDatoR".">";
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaC",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
		$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
	}	
	$tablaclientes .="</table>";echo $tablaclientes;	
	mysql_free_result($rs);
}


function Uni_MostrarVtos($idpadre,$conn){ 
	$query="SELECT v.*,t.Nombre as Tipo From unidadesvtos v,unidadesvtos_tipos t where v.Id<>0 and v.IdTipo=t.Id and v.IdEntidad=".$idpadre." Order by v.Inactivo,t.Nombre";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="730" border="0" cellspacing="0" cellpadding="0" ><tr>';
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."500"." class="."TablaTituloDato"."> Habilitaci&oacute;n</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Emisi&oacute;n</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Vto</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Req</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddVto','submit','','self','Agregar','add','iconbtn')."</td>"; 
	$tablaclientes .='<td class="TablaTituloRight"></td>';  
	$tablaclientes .='</tr>';             
	$estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarVto.php?Flag1=True"."&id=".$row['Id']."'";
		$fvto= GLO_FormatoFecha($row['Fecha']);
		if ($fvto!="" and (strtotime(date("d-m-Y"))-strtotime($fvto))>0 and $row['Inactivo']==0){$color=' style="font-weight:bold;color:#f44336"';}else{$color='';}  
		if ($row['Inactivo']==0){$clase="TablaDato";}else{$clase="TablaDatoR2";}
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
		$tablaclientes .="<td  class="."TablaDatoR".">";
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaVto",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
		$tablaclientes .='<td class="TablaMostrarRight"></td>';  
		$tablaclientes .='</tr>'; }	
	//Cerrar tabla
	$tablaclientes .="</table>"; 
	echo $tablaclientes;	
	mysql_free_result($rs);
}


function Uni_MostrarContratos($idpadre,$conn){ 
	$query="SELECT v.*,t.Apellido as Prov From unidades_con v,proveedores t where v.Id<>0 and v.IdProv=t.Id and v.IdEntidad=$idpadre Order by v.FechaI";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="730" border="0" cellspacing="0" cellpadding="0" ><tr>';
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato".">Contrato</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Inicio</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Fin</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."450"." class="."TablaTituloDato".">Proveedor</td>";   
	$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
	$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddCon','submit','','self','Agregar','add','iconbtn')."</td>";  
	$tablaclientes .='<td class="TablaTituloRight"></td>';  
	$tablaclientes .='</tr>';             
	$estilo=" style='cursor:pointer;' ";$clase="TablaDato";
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarCon.php?Flag1=True"."&id=".$row['Id']."'";
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class=".$clase.$link."> ".$row['NroCon']."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
		$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaI'])."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
		$tablaclientes .="<td class=".$clase.$link."> ".GLO_FormatoFecha($row['FechaF'])."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 	 
		$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,50)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td  class="."TablaDatoR".">";
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaCon",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
		$tablaclientes .='<td class="TablaMostrarRight"></td>';  
		$tablaclientes .='</tr>'; }	
	//Cerrar tabla
	$tablaclientes .="</table>"; 
	echo $tablaclientes;	
	mysql_free_result($rs);
}

function ComboPolizaSeguroRFX($campo,$conn){
$query="SELECT pa.*,t.Nombre as Tipo,p.Nombre as Aseg From polizassegauto pa,polizasaseg p,polizastipo t where pa.Id<>0 and pa.IdTipo=t.Id and pa.IdAseg=p.Id  Order by p.Nombre";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION[$campo]) {$combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$row['Nro'].' '.$row['Tipo'].' '.$row['Aseg']."</option>\n";
  }else{ $combo .= " <option value='".$row['Id']."'>".$row['Nro'].' '.$row['Tipo'].' '.$row['Aseg']."</option>\n";   }}
echo $combo;mysql_free_result($rs);
}

?>