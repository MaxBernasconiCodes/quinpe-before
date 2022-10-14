<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -12 month"));$_SESSION['TxtFechaH']=$hoy;
}
if (empty($_SESSION['TxtQCOITEMS'])){// trae por defecto filtro fecha
	if (!(empty($_SESSION['TxtFechaD']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_SESSION['TxtFechaD'])."')>=0";}else{$wfechad="";}
	if (!(empty($_SESSION['TxtFechaH']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_SESSION['TxtFechaH'])."')<=0";}else{$wfechah="";}
	//pedidos que no estan en ninguna OC 
	$_SESSION['TxtQCOITEMS']="SELECT np.*,npi.Id as IdItemNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,e.Nombre as Estado, a.Id as IdArticuloItem,a.Nombre as Articulo,um.Abr,p.Apellido as Prov,p1.Nombre as NomS,p1.Apellido as ApeS,npi.Obs as ObsIT,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_npedido_est e,epparticulos a,unidadesmedida um,proveedores p,personal p1,items il,unidadesmedida u2 Where np.Id=npi.IdNP and e.Id=npi.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and npi.IdProv=p.Id and np.IdPerSoli=p1.Id and npi.IdEstado=8 and npi.IdItem=il.Id and il.IdUnidad=u2.Id and (npi.NroOC='0' or npi.NroOC='') $wfechad $wfechah  Order by np.Id,a.Nombre";		
}


function MostrarTabla($conn){
	$query=$_SESSION['TxtQCOITEMS'];$query=str_replace("\\", "", $query); 
	if ( ($query!="")){		
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){
			//boton guardar
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(1110,1,0,0);
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
			$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Pedido</td>";   
			$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Cant</td>"; 
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
			$tablaclientes .="<td "."width="."420"." class="."TableShowT"."> Art&iacute;culo o Producto</td>";   
			$tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Obs.Item</td>"; 
			$tablaclientes .="<td "."width="."130"." class="."TableShowT"."> Proveedor</td>"; 
			$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Solicitante</td>"; 
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> </td>"; 
			$tablaclientes .='</tr>';             
			$recuento=0;  
			while($row=mysql_fetch_array($rs)){ 
				$idNP=$row['Id'];$idItemNP=$row['IdItemNP'];
				if(CO_BuscarCOTIZ($row['IdItemNP'],$conn)==''){$cotizado='';}else{$cotizado='COTIZADO';}
				//articulo,producto u observaciones
				$claseart="";
				if($row['IdArticuloItem']>0){
					$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
				}else{
					if($row['IdProd']>0){
						$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
					}else{$claseart=" TRed ";$textoart=$row['ObsIT'];$abr='';}	
				}

			
				$tablaclientes .='<tr '.GLO_highlight($row['IdItemNP']).'>';
				$tablaclientes .="<td class="."TableShowD"."> ".FormatoFecha($row['Fecha'])."</td>"; 
				$tablaclientes .="<td class="."TableShowD"." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .="<td class="."TableShowD"." style='text-align:right;'> ".$row['CantAutoItem']."</td>"; 
				$tablaclientes .="<td class="."TableShowD"."> ".substr($abr,0,5)."</td>"; 
				$tablaclientes .='<td class="TableShowD'.$claseart.'" title="'.$textoart.'">'.substr($textoart,0,50)."</td>"; 
				$tablaclientes .="<td  class="."TableShowD".' title="'.$row['ObsIT'].'">'.substr($row['ObsIT'],0,24)."</td>";  
				$tablaclientes .="<td class="."TableShowD"."> ".substr($row['Prov'],0,16)."</td>";  
				$tablaclientes .="<td class="."TableShowD"."> ".substr($row['ApeS'].' '.$row['NomS'],0,12)."</td>"; 
				$tablaclientes .='<td class="TableShowD TRed">'.$cotizado."</td>"; 
				$tablaclientes .='</tr>';
				$recuento=$recuento+1;
			}
			$tablaclientes .=GLO_fintabla(0,0,$recuento);
			echo $tablaclientes;	
		}mysql_free_result($rs);	
	}
}


//html
GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','zConsultaItems',0,0,0,0); 
GLO_tituloypath(0,700,'','PEDIDOS','close');
?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="80"></td><td width="110"></td><td width="80"></td><td width="100"></td><td width="30"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td align="right">Art&iacute;culo:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:90px" maxlength="30" onKeyDown="enterxtab(event)"></td>	<td  align="right">Pedido:</td><td colspan="2">&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"></td></tr>
<tr> <td height="18"  align="right">Solicitante:</td><td colspan="2">&nbsp;<select name="CbSoli" class="campos" id="CbSoli"  style="width:175px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalSoliNP($conn); ?></select></td><td  align="right">Proveedor:</td><td>&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:90px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td>	<td  align="right"></td><td align="right" colspan="2"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>
<?
GLO_Hidden('TxtQCOITEMS',0);
MostrarTabla($conn);
GLO_mensajeerror(); 
mysql_close($conn); 
GLO_cierratablaform();

GLO_initcomment(1110,0);
echo 'Los <font class="comentario2">Pedidos</font> deben estar en estado <font class="comentario3">Comprar</font><br>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>