<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


function CLI_TablaContratos($idpadre,$conn){ 
$query="Select a.*,c.Nombre,co.IdSoliCotiz,sc.Tipo From c_contratos a,c_cotizaciones co,c_solicitudescotizacion sc, clientes c Where a.IdCliente=c.Id and co.Id=a.IdCotizacion and sc.Id=co.IdSoliCotiz and a.IdCliente=$idpadre Order by a.Fecha Desc";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="730" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> N&uacute;mero</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."65"." class="."TablaTituloDato"."> Creacion</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Cotizaci&oacute;n</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Solicitud</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Tipo</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."65"." class="."TablaTituloDato"."> Inicio</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."65"." class="."TablaTituloDato"."> Fin</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."195"." class="."TablaTituloDato"."> Observaciones</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddCON','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){ 
	$estilo=" style='cursor:pointer;' "; //idcli: para saber si vuelvo a clientes o  comprobantes
	$link=" onclick="."location='../Comprobantes/ModificarContrato.php?Flag1=True&id=".$row['Id']."&idcli=".$row['IdCliente']."'";
	$tipo='';if($row['Tipo']=='L'){$tipo='LICITACION';} if($row['Tipo']=='P'){$tipo='PRESUPUESTO';} 
	$fi= GLO_FormatoFecha($row['FechaInicio']);
	$ff= GLO_FormatoFecha($row['FechaFin']);
	$clase="TablaDato";		
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
	$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['IdCotizacion'], 6, "0", STR_PAD_LEFT)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['IdSoliCotiz'], 6, "0", STR_PAD_LEFT)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".$tipo."</td>";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".$fi."</td>";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".$ff."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,28)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."></td>"; 
	$tablaclientes .='<td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
//Mostrar tabla
echo $tablaclientes;	
//Cierra consulta
mysql_free_result($rs);
}



function CLI_MostrarTablaCC($idpadre,$conn){ 
$query="SELECT c.*,s.Nombre as Sector From clicentroscosto c, sector s where c.Id<>0 and c.IdSector=s.Id and c.IdCliente=$idpadre Order by c.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="770" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."240"." class="."TablaTituloDato"."> Nombre</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Lugar</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."180"." class="."TablaTituloDato"."> Sector</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."110"." class="."TablaTituloDato"."> CUIT</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddCC','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){ 
	$estilo=" style='cursor:pointer;' ";
	$link=" onclick="."location='ModificarCC.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Nombre'],0,25)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Lugar'],0,30)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Sector'],0,24)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['CUIT'],0,15)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDatoR"." >";
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaCC",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
	  
	$tablaclientes .='<td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
//Mostrar tabla
echo $tablaclientes;	
//Cierra consulta
mysql_free_result($rs);
}


function CLI_MostrarTablaUTE($idpadre,$conn){ 
$query="SELECT c.* From cli_utes c where c.Id<>0 and c.IdCliente=$idpadre Order by c.Nombre";
$rs=mysql_query($query,$conn);
$tablaclientes='';
$tablaclientes .='<table width="770" class="TableShow" id="tshow"><tr>';
$tablaclientes .="<td "."width="."540"." class="."TableShowT"."> Razon Social</td>";   
$tablaclientes .="<td "."width="."190"." class="."TableShowT"."> CUIT</td>";   
$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddUTE','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='</tr>';             
$estilo=" style='cursor:pointer;' ";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarUTE.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Nombre'],0,60)."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Identificacion'],0,15)."</td>"; 
	$tablaclientes .='<td class="TableShowD TAR">';
	$tablaclientes .=GLO_rowbutton("CmdBorrarFilaUTE",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);  
	$tablaclientes .='</tr>';
}mysql_free_result($rs);	
$tablaclientes .="</table>"; 
echo $tablaclientes;
}




?>