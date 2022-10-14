<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['id'],0,0);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


	
$query="SELECT * From epparticulos where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
	$_SESSION['TxtNombre'] = $row['Nombre'];
	$_SESSION['CbRubro'] = $row['IdRubro'];
	$_SESSION['CbMarca'] = $row['IdMarca'];
	$_SESSION['CbUnidad'] = $row['IdUnidad'];
	$_SESSION['TxtModelo'] = $row['Modelo'];
	$_SESSION['TxtFrec'] = $row['Frecuencia'];
	$_SESSION['TxtObs'] = $row['Obs'];
	$_SESSION['TxtNSE'] = $row['NSE'];
	$_SESSION['CbTipo'] = $row['EPP'];	//antes era epp, ahora es tipo (tipo epp=1)
	$_SESSION['ChkReq'] = $row['Stock'];
	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
	$_SESSION['TxtFechaV'] = GLO_FormatoFecha($row['FechaV']);
	//
	$_SESSION['TxtFoto'] = $row['Foto'];
	$_SESSION['TxtRango1'] = $row['Rango1'];
	$_SESSION['TxtRango2'] = $row['Rango2'];
	$_SESSION['TxtTAG'] = $row['TAG'];
	$_SESSION['CbUnM'] = $row['UnidadM'];
	$_SESSION['CbTipoC'] = $row['TipoC'];
}mysql_free_result($rs);





function MostrarTablaCE($idpadre,$conn){ 
	$query="SELECT pp.*,im.Nombre as TipoC From instrumentosprog pp,instrumentostipocertif im  where pp.Id<>0 and pp.IdTipoCertif=im.Id and pp.IdInstrumento=$idpadre Order by pp.Inactivo,pp.FechaProg";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='<table width="720" border="0"  cellpadding="0" cellspacing="0" class="TMT5 TMB5"><tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Certificaciones:</strong></td></tr><tr> <td  align="center">';
	$tablaclientes .='<table width="720" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Certif</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
	$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Certificaci&oacute;n</td>";   
	$tablaclientes .="<td "."width="."150"." class="."TableShowT".">Certificado </td>";  
	$tablaclientes .="<td "."width="."220"." class="."TableShowT"."> Observaciones</td>"; 
	$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Vencimiento</td>"; 
	$tablaclientes .='<td width="40" class="TableShowT TAR"></td>'; 
	$tablaclientes .='</tr>';             
	$recuento=0; $estilo=" style='cursor:pointer;' ";
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='VerCE.php?Flag1=True"."&id=".$row['Id']."'";;
		$fechar =GLO_FormatoFecha($row['FechaReal']);
		if ($row['Inactivo']==0){$clase="TableShowD";}else{$clase="TableShowD TGray";}	
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .='<td class="'.$clase.'"'.$link."> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
		$tablaclientes .='<td class="'.$clase.'"'.$link."> ".GLO_FormatoFecha($row['FechaProg'])."</td>"; 
		$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['TipoC'],0,12)."</td>"; 
		$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Certificado'],0,16)."</td>";  
		$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Obs'],0,30)."</td>"; 
		if ($fechar!="" and (strtotime(date("d-m-Y"))-strtotime($fechar))>0 and $row['Inactivo']==0){
			$tablaclientes .="<td class="."TableShowD TRed".$link."> ".$fechar."</td>";}else{$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$fechar."</td>";
		}	 
		$tablaclientes .='<td  class="TableShowD TAR"></td>';  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);
	$tablaclientes .="</table></td></tr></table>"; 
	echo $tablaclientes;
}
		

GLOF_Init('TxtNombre','BannerPopUp','zVer',1,'',0,0,0);

GLO_tituloypath(0,720,'','ARTICULOS','close');

$ver=1;
include ("zCampos.php");
GLO_mensajeerror(); 

//si son bienes muestro asignaciones y certificaciones
if(intval($_SESSION['CbTipo'])==2){	
	MostrarTablaCE($_SESSION['TxtNumero'],$conn);
}

GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"epparticulos_adj","720","Articulos/","Archivos adjuntos","paperclip",1,1,1);

mysql_close($conn);
GLO_cierratablaform(); 

include ("../Codigo/FooterConUsuario.php");
?>