<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//solo agregar/eliminar items si el estado de la cotiz es 0
//mostrar campos
if ($_GET['Flag1']=="True"){
	$query="SELECT * From co_pcotiz where Id<>0 and Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA'] =FormatoFecha($row['Fecha']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['TxtObs'] =$row['Obs'];
		$_SESSION['CbProv'] =$row['IdProv'];
		$_SESSION['TxtObs2'] =$row['Obs2'];//prov sugerido
		$_SESSION['CbEstado']= $row['IdEstado'];
		$_SESSION['TxtIdEstado']= $row['IdEstado'];
	}
	mysql_free_result($rs);
}

 
function MostrarTablaItems($idpadre,$conn){ 
$idpadre=intval($idpadre);
$query="SELECT i.Id,np.Fecha,np.Id as IdNP,npi.Id as IdNPI,npi.Cant as CantItem,npi.IdEstado,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem,e.Nombre as Estado,a.Id as IdArticuloItem,a.Nombre as Articulo,a.Modelo, m.Nombre as Marca,um.Abr,np.IdUnidad,np.IdPersonal,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_pcotiz_it i,co_npedido_est e,epparticulos a,unidadesmedida um,marcas m,items il,unidadesmedida u2 Where i.IdItemNP=npi.Id and np.Id=npi.IdNP and e.Id=npi.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and a.IdMarca=m.Id and npi.IdItem=il.Id and il.IdUnidad=u2.Id and i.IdPCotiz=$idpadre Order by a.Nombre,il.Nombre"; 
$rs=mysql_query($query,$conn);
$tablaclientes='';
$tablaclientes .=GLO_inittabla(1000,0,0,0);
$tablaclientes .='<td  align="center" >';
$tablaclientes .='<table width="1000" border="0"  cellpadding="0" cellspacing="0"><tr ><td height="18" width="700"><i class="fa fa-tag iconsmallsp iconlgray"></i> <strong>Pedidos:</strong></td><td width="300" align="right">';
if ($_SESSION['TxtIdEstado']==0){$tablaclientes .=GLO_FAButton('CmdAddI','submit','90','self','Items NP','add','boton02');}
$tablaclientes .='</td></tr></table> ';
//
$tablaclientes .='<table width="1000" border="0" cellspacing="0" cellpadding="0" class="TMT" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Fecha</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> Pedido</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> Cant</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato"."> </td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."400"." class="."TablaTituloDato"."> Art&iacute;culo o Producto</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Marca</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Modelo</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato"."> Obs.Item</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."90"." class="."TablaTituloDato"."> Estado</td>"; 
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>";
$tablaclientes .="<td "."width="."30"." class="."TablaTituloDatoR"."></td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$recuento=0; 
while($row=mysql_fetch_array($rs)){ 
	$idestado=NP_BuscarEstadoNPIId($row['IdNPI'],$row['IdEstado'],$conn);
	$estado=NP_BuscarEstadoNPI($row['IdNPI'],$row['Estado'],$conn);
	$colorestado=NP_BuscarEstadoNPIColor($idestado);
	//articulo,producto 
	$textoart='';$abr='';
	if($row['IdArticuloItem']>0){
		$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
	}else{
		if($row['IdProd']>0){$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];}
	}
	$tablaclientes .='<tr '.'>'; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato"."> ".FormatoFecha($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato"." style='text-align:right;'> ".str_pad($row['IdNP'], 6, "0", STR_PAD_LEFT)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato"." style='text-align:right;'> ".str_pad($row['IdNP'], 8, "0", STR_PAD_LEFT)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato"." style='text-align:right;'> ".$row['CantAutoItem']."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato"."> ".substr($abr,0,5)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".' title="'.$textoart.'">'.substr($textoart,0,50)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Marca'],0,8)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Modelo'],0,8)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
	$tablaclientes .="<td  class="."TablaDato".' title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,8)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$colorestado." > ".substr($estado,0,12)."</td>";  
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td><td class="."TablaDatoR".">";  
	if ($_SESSION['TxtIdEstado']==0){  
		$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0);  
	}
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
	$tablaclientes .='</tr>'; 
	$recuento=$recuento+1;
}	
//Cerrar tabla
$tablaclientes .="</table>"; $tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p></td></tr></table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}


GLOF_Init('TxtFechaA','BannerConMenuHV','zModificarCotizacion',0,'MenuH',0,0,0);
GLO_tituloypath(0,720,'','COTIZACION','salir');
?>


<table width="720" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="310"></td><td width="70" height="3"  ></td><td width="240"></td> </tr>
<tr><td height="18"  align="right"  >Cotizaci&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>">&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td height="18"  align="right"  ></td><td  valign="top" ></td><td></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top">&nbsp; <select name="CbProv" style="width:270px" class="campos" id="CbProv" ><? ComboProveedorRFROX("CbProv",intval($_SESSION['CbProv']),"",$conn); ?></select></td><td align="right"></td><td></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top"> &nbsp; <input name="TxtObs2" type="text"  class="TextBoxRO" readonly="true" style="width:270px" maxlength="50"  value="<? echo $_SESSION['TxtObs2']; ?>" onkeyup="this.value=this.value.toUpperCase()" ></td><td align="right"></td><td></td></tr>
<tr> <td height="18"  align="right"  >Estado:</td><td  valign="top">&nbsp; <select name="CbEstado" style="width:100px" class="campos"><option value=""></option> <? ComboTablaRFX("co_pcotiz_est","CbEstado","Id","","",$conn); ?></select> </td><td align="right"></td><td></td></tr>
</table> 


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdEstado',0);
GLO_obsform(720,100,'Observaciones','TxtObs',2,0);
GLO_guardarform(720,0,2,1,0);
GLO_mensajeerror(); 

MostrarTablaItems($_SESSION['TxtNumero'],$conn);
GLO_cierratablaform(); 
mysql_close($conn);

GLO_initcomment(1000,0);
echo 'Solo se pueden <font class="comentario3">Agregar</font> y  <font class="comentario3">Eliminar</font> Pedidos, si la Cotizaci&oacute;n est&aacute; sin <font class="comentario2">Enviar</font>.<br>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>