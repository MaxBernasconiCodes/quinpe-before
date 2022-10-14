<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");include("Includes/zFuncionesA.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and  $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){	
	$query="SELECT * From epparticulos where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] = $row['Nombre'];
		$_SESSION['CbRubro'] = $row['IdRubro'];
		$_SESSION['CbMarca'] = $row['IdMarca'];
		$_SESSION['TxtModelo'] = $row['Modelo'];
		$_SESSION['CbUnidad'] = $row['IdUnidad'];
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
}

function ASIG_MostrarAsignados($idpadre,$conn){//idpadre es id articulo 
	$query="SELECT a.*, p.Nombre as Nom,p.Apellido as Ape,u.Dominio,u.Nombre as Uni,s.Nombre as Sector From instrumentosasig a,personal p,unidades u, sectorm s where a.Id<>0 and p.Id=a.IdPersonal and a.IdUnidad=u.Id and a.IdSectorM=s.Id and a.IdInstrumento=$idpadre Order by a.FechaD DESC,a.FechaH ASC";
	$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT5"><tr ><td height="18" ><i class="fa fa-truck iconsmallsp iconlgray"></i> <strong>Asignaciones:</strong></td></tr><tr> <td  align="center">';
	$tablaclientes .='<table width="750" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."300"." class="."TableShowT"."> Personal</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Desde</td>"; 
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Hasta</td>"; 
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Devuelto</td>"; 
	$tablaclientes .="<td "."width="."210"." class="."TableShowT".">Observaciones</td>";  
	$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddI','submit','','self','Agregar','add','iconbtn')." </td>"; 
	$tablaclientes .='</tr>';        
	$recuento=0; $estilo=" style='cursor:pointer;' ";
	$_SESSION['TxtOriARTAsig']=0; //para ver a donde vuelve
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarAsignacion.php?Flag1=True"."&id=".$row['Id']."'";
		if($row['TIndef']==1){$ti='Tiempo indefinido';}else{$ti='';}
		if(GLO_FechaVencida(GLO_FormatoFecha($row['FechaE']))==1 and GLO_FormatoFecha($row['FechaH'])==''){$classvto=' TRed';}else{$classvto='';}
		//
		include("Includes/zNombreA.php");
		//
		$tablaclientes .='<tr '.$estilo.'>';  
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($nomasignado,0,40)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>"; 
		$tablaclientes .='<td class="TableShowD'.$classvto.'"'.$link."> ".GLO_FormatoFecha($row['FechaE'])."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>";  
		$tablaclientes .="<td class="."TableShowD".$link."> ".$ti."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaI",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);	
	$tablaclientes .="</table></td></tr></table>"; 
	echo $tablaclientes;
}


function MostrarTablaCE($idpadre,$conn){ 
	$query="SELECT pp.*,im.Nombre as TipoC From instrumentosprog pp,instrumentostipocertif im  where pp.Id<>0 and pp.IdTipoCertif=im.Id and pp.IdInstrumento=$idpadre Order by pp.Inactivo,pp.FechaProg";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TMT5 TMB5"><tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Certificaciones:</strong></td></tr><tr> <td  align="center">';
	$tablaclientes .='<table width="750" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Certif</td>";   
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
	$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Certificaci&oacute;n</td>";   
	$tablaclientes .="<td "."width="."150"." class="."TableShowT".">Certificado </td>";  
	$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Observaciones</td>"; 
	$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Vencimiento</td>"; 
	$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddCE','submit','','self','Agregar','add','iconbtn')." </td>"; 
	$tablaclientes .='</tr>';             
	$recuento=0; $estilo=" style='cursor:pointer;' ";
	$_SESSION['TxtOriACCCertif']=0; //para ver a donde vuelve
	while($row=mysql_fetch_array($rs)){ 
		$link=" onclick="."location='ModificarCE.php?Flag1=True"."&id=".$row['Id']."'";;
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
		$tablaclientes .='<td  class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaCE",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
		$tablaclientes .='</tr>'; 
		$recuento=$recuento+1;
	}mysql_free_result($rs);
	$tablaclientes .="</table></td></tr></table>"; 
	echo $tablaclientes;
}
		
GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',1,'MenuH',0,0,0);
GLO_tituloypath(0,720,'../Articulos.php','ARTICULOS','linksalir');
include ("zCampos.php");
GLO_botonesform("720",0,2);
GLO_mensajeerror(); 
//si son bienes muestro asignaciones y certificaciones
if(intval($_SESSION['CbTipo'])==2){
	ASIG_MostrarAsignados($_SESSION['TxtNumero'],$conn);
	MostrarTablaCE($_SESSION['TxtNumero'],$conn);
}
GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"epparticulos_adj","750","Articulos/","Archivos adjuntos","paperclip",0,0,1);
mysql_close($conn);
GLO_cierratablaform(); 

GLO_initcomment(750,2);
echo 'La <font class="comentario3">Unidad de medida</font> se utiliza para registrar el <font class="comentario2">Stock</font><br>';
echo 'Los <font class="comentario2">Bienes</font> podran registrar <font class="comentario3">Asignaciones</font> y <font class="comentario3">Certificaciones</font><br>';
echo 'Para agregar <font class="comentario2">Marca</font> haga click en <i class="fa fa-plus iconvsmallsp iconlgray"></i> y luego en <i class="fa fa-redo iconvsmallsp iconlgray"></i>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>