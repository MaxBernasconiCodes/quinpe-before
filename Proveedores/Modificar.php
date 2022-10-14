<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include ("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['id'],0,0);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){	
	$query="SELECT * From proveedores where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre']=$row['Nombre'];
		$_SESSION['TxtApellido'] = $row['Apellido'];
		$_SESSION['CbDocumento'] = $row['TipoDocumento'];
		$_SESSION['TxtDoc']= $row['Documento'];
		$_SESSION['CbCUIT'] =$row['TipoIdentificacion'];
		$_SESSION['TxtCUIT']= $row['Identificacion'];
		$_SESSION['CbLocalidad'] = $row['IdLocalidad'];
		$_SESSION['TxtDireccion']=  $row['Direccion'];
		$_SESSION['TxtProvincia']=  $row['Provincia'];
		$_SESSION['TxtCP']=  $row['CP'];
		$_SESSION['TxtEMail']= $row['EMail']; 
		$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaBaja']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
		$_SESSION['CbActividad'] = $row['IdActividad'];
		$_SESSION['TxtObs'] = $row['Observaciones'];
		$_SESSION['OptTipo'] = $row['Tipo'];
		$_SESSION['CbIva'] = $row['IdIva'];
		$_SESSION['ChkC1'] = $row['Critico'];
		$_SESSION['ChkC2'] = $row['Evaluar'];
		$_SESSION['TxtPagina'] = $row['PW'];
		$_SESSION['TxtContacto'] = $row['PC'];
		$_SESSION['TxtCargo'] = $row['PCC'];
	}
	mysql_free_result($rs);
}

function PROV_MostrarTablaACT($idpadre,$conn){ 
	$query="SELECT c.Id, a.Nombre From proveedores_act c,actividades a where c.Id<>0 and c.IdActividad=a.Id and c.IdPadre=$idpadre Order by a.Nombre";
	$rs=mysql_query($query,$conn);
	$tablaclientes='';
	$tablaclientes .='<table width="770" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."730"." class="."TableShowT"."> Actividad</td>";   
	$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddOACT','submit','','self','Agregar','add','iconbtn')." </td>"; 
	$tablaclientes .='</tr>';             
	$estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarOACT.php?Flag1=True"."&id=".$row['Id']."&identidad=".$idpadre."'";
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Nombre'],0,60)."</td>"; 
		$tablaclientes .='<td class="TableShowD TAR">';
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaOACT",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);  
		$tablaclientes .='</tr>';
	}mysql_free_result($rs);	
	$tablaclientes .="</table>"; 
	echo $tablaclientes;
}

function PROV_TablaDesemp($idpadre,$conn){ 
	$idpadre=intval($idpadre);
	$query="SELECT v.*,p1.Nombre as N1,p1.Apellido as A1,p2.Nombre as N2,p2.Apellido as A2 From proveedores_des v,personal p1,personal p2 where v.Id<>0 and v.IdP1=p1.Id and v.IdP2=p2.Id and v.IdEntidad=$idpadre Order by v.Fecha desc";$rs=mysql_query($query,$conn);
	//nombre
	$tablaclientes='<table width="770" border="0"  cellpadding="0" cellspacing="0"><tr><td height="10"></td></tr><tr ><td><i class="fa fa-chart-line iconsmallsp iconlgray"></i> <strong>Evaluacion:</strong></td></tr><tr> <td>';
	//titulos
	$tablaclientes .='<table width="770" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
	$tablaclientes .="<td "."width="."70".' class="TableShowT TAR"> Trayectoria</td>';   
	$tablaclientes .="<td "."width="."60".' class="TableShowT TAR">  Gestion</td>';  
	$tablaclientes .="<td "."width="."50".' class="TableShowT TAR">  Total</td>';   
	$tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Descripcion</td>";   
	$tablaclientes .="<td "."width="."140".' class="TableShowT"> Responsable Compras</td>'; 
	$tablaclientes .="<td "."width="."140".' class="TableShowT"> Referente Receptor</td>'; 
	$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddDes','submit','','self','Agregar','add','iconbtn')." </td>"; 
	$tablaclientes .='</tr>'; 
	$_SESSION['GLO_IdLocationPROVD']=2;            
	while($row=mysql_fetch_array($rs)){ 
		GLO_LinkRowTablaInit($estilo,$link,$row['Id'],2);		
		include ("Includes/zTotales.php");
		$color1=PROV_EPestilo($t3,1,0);
		$color2=PROV_EPestilo($t3,2,0);
		//
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .='<td class="TableShowD"'.$link."> ".GLO_FormatoFecha($row['Fecha'])."</td>"; 
		$tablaclientes .='<td class="TableShowD  TAR"'.$link."> ".$t1."</td>"; 
		$tablaclientes .='<td class="TableShowD  TAR"'.$link."> ".$t2."</td>"; 
		$tablaclientes .='<td class="TableShowD  TAR"'.$link." style='font-weight:bold;".$color1."'> ".$t3."</td>"; 
		$tablaclientes .='<td class="TableShowD"'.$link." style='font-weight:bold;".$color2."'> ".PROV_EPlabel($t3)."</td>"; 
		$tablaclientes .='<td class="TableShowD"'.$link."> ".substr($row['A1'].' '.$row['N1'],0,15)."</td>"; 	
		$tablaclientes .='<td class="TableShowD"'.$link."> ".substr($row['A2'].' '.$row['N2'],0,15)."</td>"; 	
		$tablaclientes .='<td  class="TableShowD TAR">';
		$tablaclientes .=GLO_rowbutton("CmdBorrarFilaDes",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);
		$tablaclientes .='</tr>'; 
	}mysql_free_result($rs);	
	$tablaclientes .='</table></td></tr><tr><td height="20"></td></tr></table>'; 
	echo $tablaclientes;	
	}
	

GLOF_Init('TxtApellido','BannerConMenuHV','zModificar',1,'',0,0,0); 
include ("Includes/zCampos.php");

PROV_TablaDesemp($_SESSION['TxtNumero'],$conn);
?>


<table width="770" border="0"  cellpadding="0" cellspacing="0">
<tr ><td height="18" ><i class="fa fa-phone iconsmallsp iconlgray"></i> <strong>Tel&eacute;fonos:</strong></td></tr>
<tr> <td  align="center" ><? GLO_TablaTelefonos($_SESSION['TxtNumero'],$conn,'provtelefonos',770,0); ?>	</td></tr>
<tr> <td height="20"></td></tr>

<!--actividad-->
<tr ><td height="18" ><i class="fa fa-industry iconsmallsp iconlgray"></i> <strong>Otras Actividades:</strong></td></tr>
<tr> <td  align="center" ><?php PROV_MostrarTablaACT($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="20"></td></tr>
</table>
  

<? 
GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"proveedores_adj","770","Prov/","Archivos adjuntos","paperclip",0,0,1);
GLO_cierratablaform(); 
mysql_close($conn);


GLO_initcomment(770,0);
echo 'Para agregar <font class="comentario2">Localidad</font> o  <font class="comentario2">Actividad</font>, haga click en <i class="fa fa-plus iconvsmallsp iconlgray"></i> y luego en <i class="fa fa-redo iconvsmallsp iconlgray"></i>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>