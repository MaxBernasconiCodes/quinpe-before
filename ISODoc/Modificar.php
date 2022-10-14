<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



if ($_GET['Flag1']=="True"){
	$query="SELECT d.*,e.Nombre as Estado,p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2,p3.Nombre as N3,p3.Apellido as A3,pr.Apellido as RSProv From iso_doc d,iso_doc_estados e,personal p1,personal p2,personal p3,proveedores pr where e.Id=d.IdEstado and p1.Id=d.IdPersCRE and pr.Id=d.IdProvCRE and p2.Id=d.IdPersCON  and p3.Id=d.IdPersAPR and d.Id<>0 and d.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']= str_pad($row['Id'], 5, "0", STR_PAD_LEFT); 
		$_SESSION['TxtEstado']= $row['Estado'];
		$_SESSION['TxtCod']= $row['Codigo'];
		$_SESSION['TxtVs']= str_pad($row['Version'], 2, "0", STR_PAD_LEFT); 
		$_SESSION['TxtNombre']= $row['Nombre']; 
		$_SESSION['TxtArchivo']= $row['Ruta']; 
		$_SESSION['CbTipo']= $row['IdTipoDoc']; 
		$_SESSION['CbSector']= $row['IdSector']; 
		$_SESSION['CbOrigen']= $row['Origen'];
		$_SESSION['TxtPers1']= $row['A1'].' '.$row['N1'];
		$_SESSION['TxtProv1']= $row['RSProv'];
		$_SESSION['TxtPers2']= $row['A2'].' '.$row['N2'];
		$_SESSION['TxtPers3']= $row['A3'].' '.$row['N3'];
		$_SESSION['TxtFecha1']= FormatoFecha($row['FechaCRE']);if ($_SESSION['TxtFecha1']=='00-00-0000'){$_SESSION['TxtFecha1'] ="";}
		$_SESSION['TxtFecha2']= FormatoFecha($row['FechaCON']);if ($_SESSION['TxtFecha2']=='00-00-0000'){$_SESSION['TxtFecha2'] ="";}
		$_SESSION['TxtFecha3']= FormatoFecha($row['FechaAPR']);if ($_SESSION['TxtFecha3']=='00-00-0000'){$_SESSION['TxtFecha3'] ="";}
		$_SESSION['TxtFecha4']= FormatoFecha($row['FechaEXP']);if ($_SESSION['TxtFecha4']=='00-00-0000'){$_SESSION['TxtFecha4'] ="";}
		$_SESSION['TxtCom1']= $row['ComentCRE']; 
		$_SESSION['TxtCom2']= $row['ComentCON']; 
		$_SESSION['TxtCom3']= $row['ComentAPR']; 	
		$_SESSION['TxtFO']= $row['FlagOrig']; 
		$_SESSION['TxtFR']= $row['FlagRev']; 
		$_SESSION['TxtIdPers2']= $row['IdPersCON'];  
		$_SESSION['TxtIdPers3']= $row['IdPersAPR'];
		$_SESSION['TxtIdEstado']= $row['IdEstado'];
	}mysql_free_result($rs);
	//verifico si existe nueva version
	$_SESSION['TxtFVS']=ISODOC_TieneVersionNueva($_SESSION['TxtNumero'],$conn);//pasa id doc
} 


function MostrarTablaEvidencias($idpadre,$conn){
	$query="SELECT r.* From iso_doc_evi r where r.IdDoc=$idpadre Order by r.Id";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="725" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."590"." class="."TableShowT"."> Descripcion</td>"; 
	$tablaclientes .="<td "."width="."55"." class="."TableShowT"."> A&ntilde;o</td>"; 
	$tablaclientes .='<td width="80" class="TableShowT TAR">'; 
	//valida estado y perfil
	if (ISODOC_puedemodificar(1)==1){$tablaclientes .=GLO_FAButton('CmdAddAEVI','submit','','self','Agregar','add','iconbtn');}
	$tablaclientes .='</td></tr>';    
	//Datos
	while($row=mysql_fetch_array($rs)){
		if($row['Anio']==0){$anio='';}else{$anio=$row['Anio'];}
		//
		$tablaclientes .=" <tr> ";
		$tablaclientes .='<td class="TableShowD ">'.substr($row['Descripcion'],0,75)."</td>";  
		$tablaclientes .='<td class="TableShowD ">'.$anio."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR">'; 
		//valida estado y perfil
		if (ISODOC_puedever(1)==1){	
			if( !(empty($row['Ruta']))){
				$tablaclientes .=GLO_rowbutton("CmdVerFileEVI",$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);
			}
		}
		//valida estado y perfil
		if (ISODOC_puedemodificar(1)==1){
			$tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdActRegEVI",$row['Id'],"Actualizar",'self','folder','iconlgray','Actualizar',0,0,0); 
			$tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdBorrarFilaAEVI",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);  
		} 
		$tablaclientes .="</td></tr>";  
	}mysql_free_result($rs);	
	$tablaclientes .="</table>";
	echo $tablaclientes;	
}

function MostrarTablaArchivos($idpadre,$conn){
	$query="SELECT r.* From iso_doc_reg r where r.IdDoc=$idpadre Order by r.Id";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .='<table width="725" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."645"." class="."TableShowT"."> Descripcion</td>"; 
	$tablaclientes .='<td width="80" class="TableShowT TAR">'; 
	//valida estado y perfil
	if (ISODOC_puedemodificar(1)==1){$tablaclientes .=GLO_FAButton('CmdAddA','submit','','self','Agregar','add','iconbtn');}
	$tablaclientes .='</td></tr>';    
	//Datos
	while($row=mysql_fetch_array($rs)){
		$tablaclientes .=" <tr> ";
		$tablaclientes .='<td class="TableShowD ">'.substr($row['Descripcion'],0,80)."</td>";  
		$tablaclientes .='<td  class="TableShowD TAR">'; 
		//valida estado y perfil
		if (ISODOC_puedever(1)==1){	
			if( !(empty($row['Ruta']))){
				$tablaclientes .=GLO_rowbutton("CmdVerFile",$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);
			}
		}
		//valida estado y perfil
		if (ISODOC_puedemodificar(1)==1){
			$tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdActReg",$row['Id'],"Actualizar",'self','folder','iconlgray','Actualizar',0,0,0); 
			$tablaclientes .=' &nbsp; '.GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
		} 
		$tablaclientes .="</td></tr>";  
	}mysql_free_result($rs);	
	$tablaclientes .="</table>";
	echo $tablaclientes;	
}


function MostrarTablaCopias($idpadre,$conn){
	$query="SELECT d.* From iso_doc_copias d where d.IdDoc=$idpadre Order by d.FechaB";
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes .="<table width="."725"." border="."0"." cellspacing="."0"." cellpadding="."0"." >";
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Cantidad</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Entregada</td>"; 
	$tablaclientes .="<td class="."TablaTituloLeft"."> </td>";
	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Retirada</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td "."width="."495"." class="."TablaTituloDato".">Observaciones</td>"; 
	$tablaclientes .='<td class="TablaTituloLeft"></td>';
	$tablaclientes .="<td width="."20"." class="."TablaTituloDatoR".">"; 
	//agregar registro: si es perf.coord/admin y estado aprobado
	if ((($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14) ) and ($_SESSION['TxtIdEstado']==4)){
	$tablaclientes .=GLO_FAButton('CmdAddC','submit','','self','Agregar','add','iconbtn');}
	$tablaclientes .='</td><td class="TablaTituloRight"></td>';  
	$tablaclientes .='</tr>';    
	//Datos
	while($row=mysql_fetch_array($rs)){
		//modifica si es admin/coord
		if (($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14)){
			$estilo=" style='cursor:pointer;' ";
			$link=" onclick="."location='ModificarCopia.php?Flag1=True"."&IdCP=".$row['Id']."&Id=".$idpadre."'";
		}else{$estilo="";$link="";}
		$falta = FormatoFecha($row['FechaA']);if ($falta=='00-00-0000'){$falta="";}
		$fbaja= FormatoFecha($row['FechaB']);if ($fbaja=='00-00-0000'){$fbaja="";}	
		if ($fbaja==''){$clase="TablaDato";}else{$clase="TablaDatoR2";}
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class=".$clase.$link."> ".$row['Cantidad']."</td>";  
		$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
		$tablaclientes .="<td class=".$clase.$link."> ".$falta."</td>";  			
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td class=".$clase.$link."> ".$fbaja."</td>";  			
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Obs'],0,60)."</td>"; 
		$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
		$tablaclientes .="<td class=".$clase.$link."></td>"; 
		$tablaclientes .="<td class="."TablaMostrarRight"."> </td></tr>";  
	}	
	$tablaclientes .="</table>";echo $tablaclientes;	
	mysql_free_result($rs);

}


GLOF_Init('','BannerConMenuHV','zModificar',0,'MenuH',0,0,0); 
GLO_tituloypath(0,725,'../ISO_Doc.php','DOCUMENTO','linksalir');

include("Includes/zCamposENC.php");
include("Includes/zCamposDOC.php");
include("Includes/zCamposCRE.php");
include("Includes/zCamposCON.php");
include("Includes/zCamposAPR.php");
include("Includes/zCamposGRA.php");//grabar
?>

   



<!--registros-->
<table width="725" border="0"  cellpadding="0" cellspacing="0">
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Documentacion Asociada:</strong></td></tr>
<tr> <td  align="center" ><?php MostrarTablaArchivos($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15"></td></tr>
<!--evidencias-->
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Evidencias:</strong></td></tr>
<tr> <td  align="center" ><?php MostrarTablaEvidencias($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15"></td></tr>
<!--copias-->
<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Copias:</strong></td></tr>
<tr> <td  align="center" ><?php MostrarTablaCopias($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
</table> 


<? 
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(725,0);
echo 'Para <font class="comentario2">Controlar</font> un documento, debe tener el <font class="comentario3">Archivo</font> correspondiente cargado<br>';
echo 'Una vez que est&eacute; <font class="comentario3">Aprobado</font> se podr&aacute;n generar desde cada documento las nuevas <font class="comentario2">Versiones </font> ';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>