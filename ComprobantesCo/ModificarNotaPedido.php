<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT np.*,p.Nombre as Nom,p.Apellido as Ap From co_npedido np,personal p where np.Id<>0 and np.IdUsr=p.Id and np.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA'] =GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtNombre']=$row['Titulo'];
		$_SESSION['OptTipoP'] =$row['Prioridad'];
		$_SESSION['CbSoli'] =$row['IdPerSoli'];
		$_SESSION['TxtUsuario']=$row['IdUsr'];
		$_SESSION['CbPAuto'] =$row['IdPerPAuto'];
		$_SESSION['CbAuto'] =$row['IdPerAuto'];
		$_SESSION['CbSector'] =$row['IdSector'];
		$_SESSION['TxtObs'] =$row['Obs'];
		$_SESSION['CbPPED'] =$row['IdPuntoP'];
		$_SESSION['CbCentro'] =$row['IdCentro'];
		$_SESSION['CbUnidad'] =$row['IdUnidad'];
		$_SESSION['CbPersonal'] =$row['IdPersonal'];
		$_SESSION['CbInstrumento'] =$row['IdInstr'];
		$_SESSION['CbSector2'] =$row['IdSectorM'];
		$_SESSION['TxtPersonal']= $row['Ap'].' '.$row['Nom'];//usuario q registro		
	}	mysql_free_result($rs);
}

 
//valido si tiene autorizados o preautorizados
$tienenpipauto=NP_TieneItemsPreauto(intval($_SESSION['TxtNumero']),$conn);
$tienenpiauto=NP_TieneItemsAuto(intval($_SESSION['TxtNumero']),$conn);


function MostrarTablaItems($idpadre,$conn){ 
	$idpadre=intval($idpadre);
	$query="SELECT npi.*,a.Nombre as Articulo,a.Modelo, m.Nombre as Marca,um.Abr,p.Apellido as Prov,e.Nombre as Estado,il.Nombre as Prod,u2.Abr as Abr2 From co_npedido_it npi,epparticulos a,unidadesmedida um,proveedores p,marcas m,co_npedido_est e,items il,unidadesmedida u2 where npi.Id<>0 and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and npi.IdProv=p.Id and a.IdMarca=m.Id and npi.IdEstado=e.Id and npi.IdItem=il.Id and il.IdUnidad=u2.Id and npi.IdNP=$idpadre Order by a.Nombre,il.Nombre";$rs=mysql_query($query,$conn);
	//Titulos de la tabla
	$tablaclientes='<table width="1000" border="0"  cellpadding="0" cellspacing="0" ><tr> <td height="5" ></td></tr><tr ><td height="18" ><i class="fa fa-tag iconsmallsp iconlgray"></i> <strong>Pedidos:</strong></td></tr><tr> <td  align="center" >';
	//
	$tablaclientes .='<table width="1000" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width="."290"." class="."TableShowT"."> Art&iacute;culo o Producto</td>";
	$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Marca</td>"; 
	$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Modelo</td>"; 
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Cant</td>"; 
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Auto</td>"; 
	$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
	$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Proveedor</td>"; 
	$tablaclientes .="<td "."width="."50"." class="."TableShowT"." >COTIZ</td>"; 
	$tablaclientes .="<td "."width="."60"." class="."TableShowT"." >OC</td>"; 
	$tablaclientes .="<td "."width="."90"." class="."TableShowT".">RemitoI</td>"; 
	$tablaclientes .="<td "."width="."70"." class="."TableShowT".">Obs Item</td>"; 
	$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Estado</td>"; 
	$tablaclientes .="<td "."width="."30"." class="."TableShowT"." style='text-align:right;'> ";
	//alta si es solicitante o quien registro
	if( intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbSoli']) or intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['TxtUsuario']) ){$essolioreg=1;}else{$essolioreg=0;}
	//o  es perfil compras
	if( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11){$escompras=1;}else{$escompras=0;}
	//o  es auto
	if( intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbAuto']) ){$esauto=1;}else{$esauto=0;}
	//o si es preauto 
	if( intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbPAuto']) ){$espreauto=1;}else{$espreauto=0;}
	//valido
	if( $essolioreg==1 or $escompras==1 or $esauto==1 or $espreauto==1){
		$tablaclientes .=GLO_FAButton('CmdAddI','submit','','self','Agregar','add','iconbtn');
	}
	$tablaclientes .='</tr>';
	$estilo=" style='cursor:pointer;'"; 
	while($row=mysql_fetch_array($rs)){ 	
		$link=" onclick="."location='ModificarItemNP.php?Flag1=True"."&IdItem=".$row['Id']."&Id=".$idpadre."'";
		$idestado=NP_BuscarEstadoNPIId($row['Id'],$row['IdEstado'],$conn);
		$estado=NP_BuscarEstadoNPI($row['Id'],$row['Estado'],$conn);
		$colorestado=NP_BuscarEstadoNPIColor($idestado);	
		//cantidad autorizada
		if($row['CantAuto']>0){$clasecant='';}else{$clasecant=' TRed TBold';}
		//articulo,producto u observaciones
		$claseart='';
		if($row['IdArticulo']>0){//articulo
			$textoart=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];}
		else{
			if($row['IdItem']>0){//producto
				$textoart=str_pad($row['IdItem'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
			}else{$claseart=' TRed';$textoart=$row['Obs'];$abr='';}		
		}
		//oc
		if($row['NroOC']=='0' or $row['NroOC']==''){$nrooc='';}else{$nrooc=$row['NroOC'];}
		//datos
		$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
		$tablaclientes .='<td class="TableShowD'.$claseart.'"'.$link.' title="'.$textoart.'">'.substr($textoart,0,35)."</td>";  
		$tablaclientes .="<td  class="."TableShowD".$link." > ".substr($row['Marca'],0,8)."</td>"; 
		$tablaclientes .="<td  class="."TableShowD".$link." > ".substr($row['Modelo'],0,8)."</td>"; 
		$tablaclientes .='<td class="TableShowD TAR"'.$link."> ".$row['Cant']."</td>";  
		$tablaclientes .='<td class="TableShowD TAR'.$clasecant.'"'.$link."> ".$row['CantAuto']."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($abr,0,5)."</td>";  
		$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Prov'],0,7)."</td>";  
		$tablaclientes .='<td class="TableShowD"'.$link."> ".CO_BuscarCOTIZ($row['Id'],$conn)."</td>";  
		$tablaclientes .='<td class="TableShowD"'.$link."> ".$nrooc."</td>";  
		$tablaclientes .='<td class="TableShowD"'.$link."> ".NP_TraeRINPI($row['Id'],$conn)."</td>"; 
		$tablaclientes .="<td class="."TableShowD".$link.' title="'.$row['Obs'].'">'.substr($row['Obs'],0,8)."</td>";  
		$tablaclientes .="<td class="."TableShowD".$link.$colorestado."> ".substr($estado,0,12)."</td>";  
		$tablaclientes .='<td class="TableShowD TAR">';  
		//elimina si esta abierto y es solicitante o quien registro
		if( $idestado==1 and (intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbSoli']) or intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['TxtUsuario'])) ){$essolioreg=1;}else{$essolioreg=0;}
		//o esta abierto y es perfil compras
		if( $idestado==1 and ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11) ){$escompras=1;}else{$escompras=0;}
		//o si es auto y no tiene compr asociado
		if( $idestado<6 and intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbAuto']) ){$esauto=1;}else{$esauto=0;}
		//o si es preauto y esta abierto, preauto o rechpre	
		if( ($idestado==1 or $idestado==2 or $idestado==4) and intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbPAuto']) ){$espreauto=1;}else{$espreauto=0;}
		//valido
		if( $essolioreg==1 or $escompras==1 or $esauto==1 or $espreauto==1){
			$tablaclientes .=' '.GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
		}
		$tablaclientes .='</tr>'; 
	}mysql_free_result($rs);
	//Cerrar tabla
	$tablaclientes .='</table></td></tr><tr><td  height="10"></td></tr></table>'; 
	echo $tablaclientes;	

}


GLOF_Init('TxtNombre','BannerConMenuHV','zModificarNotaPedido',0,'MenuH',0,0,0);
GLO_tituloypath(0,770,'','NOTA DE PEDIDO','salir'); 

include("Includes/zCamposNP.php");

GLO_cierratablaform();
mysql_close($conn);


GLO_initcomment(1000,0);
echo 'Muestra en rojo los <font class="comentario2">Art&iacute;culos</font> que deben completarse ya que no se encontraron en la lista';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>