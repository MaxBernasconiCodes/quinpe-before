<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
$query="SELECT * From iso_audi_prog where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['CbTipo'] =$row['IdTipo'];
	$_SESSION['CbSector'] =$row['IdSector'];
	$_SESSION['CbYac'] =$row['IdYac'];
	$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaProg']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
	$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaReal']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
	$_SESSION['TxtFechaRP'] = FormatoFecha($row['FechaRProg']);if ($_SESSION['TxtFechaRP']=='00-00-0000'){$_SESSION['TxtFechaRP'] ="";}
	$_SESSION['TxtHora']=$row['HoraReal']; if ($_SESSION['TxtHora']=='00:00:00'){$_SESSION['TxtHora'] ="";}
	$_SESSION['TxtHoraD']=$row['Duracion']; if ($_SESSION['TxtHoraD']=='00:00:00'){$_SESSION['TxtHoraD'] ="";}
	$_SESSION['TxtObs'] = $row['Obs'];
	$_SESSION['ChkAnul']= $row['Anulado'];
	$_SESSION['OptTipo'] = $row['Tipo'];
	//
	$_SESSION['TxtNombre'] = $row['Nombre'];
	$_SESSION['TxtAlc'] = $row['Alcance'];
	$_SESSION['TxtMet'] = $row['Met'];
	$_SESSION['TxtRes'] = $row['Res'];
	$_SESSION['TxtCri'] = $row['Cri'];
	//
	$_SESSION['TxtDir'] = $row['Dirigido'];
	$_SESSION['TxtObj'] = $row['Obj'];	
	//estado
	$colorestado='style="width:200px;border:none;"';$estado='';
	if ($row['IdEstado']==1) {$colorestado=' style="font-weight:bold;color:#00bcd4;width:200px;border:none;"';$estado='PROG';}// AZUL
	if ($row['IdEstado']==2) {$colorestado=' style="font-weight:bold;color:#4CAF50;width:200px;border:none;"';$estado='CUMPL';}// VERDE 	
	if ($row['Anulado']==1) {$colorestado=' style="font-weight:bold;color:#f44336;width:200px;border:none;"';$estado='ANULADA';}//ROJO
	//detalle
	if (($row['IdEstado']==1 or $row['IdEstado']==2 ) and ($row['Anulado']==0)) {
		//cumplido
		if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']!='0000-00-00')){
			if (CompararFechas(FormatoFecha($row['FechaReal']),FormatoFecha($row['FechaProg']))==1){$estado='CUMPL.NO PUNTUAL';}
			else{$estado='CUMPL.PUNTUAL';}				
		}
		//programado	
		if( ($row['FechaProg']!='0000-00-00') and ($row['FechaReal']=='0000-00-00')){
			if (CompararFechas(FormatoFecha($row['FechaProg']),date("d-m-Y"))==2){$estado='PROG.VENCIDO';}else{$estado='PROG.VIGENTE';}				
		}	
	}		
	$_SESSION['TxtEstado']=$estado;
}mysql_free_result($rs);

} 

function MostrarTablaProcesos($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT c.*, f.Nombre From iso_audi_procesos c, iso_procesos f where c.IdProceso=f.Id and c.IdAudiProg=$idpadre Order by f.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<tr ><td height="18" ><i class="fa fa-bars iconsmallsp iconlgray"></i>&nbsp;<strong>Procesos:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .="<table width="."730"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."700"." class="."TablaTituloDato"."> Proceso</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddPro','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".$row['Nombre']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaPro",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .='</table></td></tr><tr> <td height="15"></td></tr>';echo $tablaclientes;	
mysql_free_result($rs);

}


function MostrarTablaAuditores($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT c.*, f.Nombre as Nom,f.Apellido as Ap From iso_audi_auditores c, personal f where c.IdPersonal=f.Id and c.IdAudiProg=$idpadre Order by f.Apellido,f.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<tr ><td height="18" ><i class="fa fa-user-tie iconsmallsp iconlgray"></i> <strong>Auditores:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .="<table width="."730"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."700"." class="."TablaTituloDato"."> Nombre</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddA1','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	//si carga personal lo muestra, sino muestra texto
	if($row['IdPersonal']==0){$tablaclientes .="<td  class="."TablaDato "."> ".substr($row['Nombre'],0,60)."</td>";}
	else{$tablaclientes .="<td  class="."TablaDato "." > ".substr($row['Ap'].' '.$row['Nom'],0,60)."</td>";}		 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaA1",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .='</table></td></tr><tr> <td height="15"></td></tr>';echo $tablaclientes;	
mysql_free_result($rs);

}


function MostrarTablaAuditados($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT c.*, f.Nombre,f.Apellido From iso_audi_auditados c, personal f where c.IdPersonal=f.Id and c.IdAudiProg=$idpadre Order by f.Apellido,f.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<tr ><td height="18" ><i class="fa fa-users iconsmallsp iconlgray"></i> <strong>Auditados:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .="<table width="."730"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."700"." class="."TablaTituloDato"."> Nombre</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddA2','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".$row['Apellido'].' '.$row['Nombre']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".">"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaA2",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .='</table></td></tr><tr> <td height="15"></td></tr>';echo $tablaclientes;	
mysql_free_result($rs);

}


function MostrarTablaReq($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT c.*, f.Nombre,f.Nro,h.Nombre as TipoH,nc.Id as IdNC From iso_audi_progreq c, iso_nc_req f,iso_audi_tipoh h,iso_nc nc where c.IdReq=f.Id and c.Tipo=h.Id and c.IdNC=nc.Id and c.IdAudiP=$idpadre Order by f.Nro";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<tr ><td height="18" ><i class="fa fa-bars iconsmallsp iconlgray"></i>&nbsp;<strong>Resumen de No Conformidades:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .="<table width="."730"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."570"." class="."TablaTituloDato"."> Nombre</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Tipo</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDatoR"."> NC</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."50"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddR','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";
while($row=mysql_fetch_array($rs)){	
	$link=" onclick="."location='ModificarReq.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
	if($row['IdNC']!=0){$nc=str_pad($row['IdNC'], 5, "0", STR_PAD_LEFT);}else{$nc='';}
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".$row['Nro'].' '.substr($row['Nombre'],0,50)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".$row['TipoH']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR".$link."> ".$nc."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR"." '>"; 
	if($row['IdNC']!=0){$tablaclientes .=GLO_rowbutton("CmdVerH",$row['IdNC'],"Ver",'self','lupa','iconlgray','',0,0,0);}//si tiene  NC
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaR",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .='</table></td></tr>';echo $tablaclientes;	
mysql_free_result($rs);

}


function MostrarTablaDesvios($idpadre,$conn){
$idpadre=intval($idpadre);
$query="SELECT c.*,t.Nombre as NombreT, t.Nro as NroT, f.Nombre, f.Nro From iso_audi_progdes c,iso_audi_desvios f, iso_audi_desviost t where c.IdDesvio=f.Id and f.IdDesvioT=t.Id and  c.IdAudiP=$idpadre Order by f.Nro";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='<tr ><td height="18" ><i class="fa fa-chart-line iconsmallsp iconlgray"></i> <strong>Observaciones:</strong></td></tr><tr> <td  align="center" >';
$tablaclientes .="<table width="."730"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."700"." class="."TablaTituloDato"."> Nombre</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."30"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddD','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';  
while($row=mysql_fetch_array($rs)){
	$estilo=" style='cursor:pointer;' ";
	$link=" onclick="."location='ModificarDesvio.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato".$link."> ".$row['NroT'].' '.substr($row['NombreT'],0,50).' | '.$row['Nro'].' '.substr($row['Nombre'],0,50)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR"." >"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaD",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
	$tablaclientes .="<tr> <td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato"." colspan="."3"." style='font-style: italic;'> ".'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descripci&oacute;n: '.substr($row['Obs'],0,90)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarRight"."> </td></tr>"; 
	$tablaclientes .="<tr> <td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato"." colspan="."3"." style='font-style: italic;'> ".'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acci&oacute;n: '.substr($row['Accion'],0,90)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table></td></tr>";echo $tablaclientes;	
mysql_free_result($rs);

}

?>