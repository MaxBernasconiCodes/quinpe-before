<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;include("../Stock/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaDST'])){	
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaDST']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$_SESSION['TxtFechaHST']=$hoy;
}


function MostrarTabla($conn){ 
$query=$_SESSION['TxtQStockDPL'];$query=str_replace("\\", "", $query);
if (  ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
			$tablaclientes='';
			$tablaclientes .=GLO_inittabla(1120,1,0,0);
			$tablaclientes .="<td "."width="."65"." class="."TableShowT"."> Fecha</td>";   
			$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";   
			$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Tipo</td>";   
			$tablaclientes .="<td "."width="."60"." class="."TableShowT"." style='text-align:right;'> Movim.</td>";   
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Ingreso</td>";   
			$tablaclientes .="<td "."width="."70"." class="."TableShowT"." style='text-align:right;'> Egreso</td>"; 
			$tablaclientes .="<td "."width="."40"." class="."TableShowT".">Unid. </td>"; 
			$tablaclientes .="<td "."width="."270"." class="."TableShowT"." >Art&iacute;culo o Producto</td>"; 
			$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Proveedor</td>";   
			$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Propietario</td>"; 
			$tablaclientes .="<td "."width="."105"." class="."TableShowT"."> Dep&oacute;sito</td>"; 
			$tablaclientes .="<td "."width="."55"." class="."TableShowT"." style='text-align:right;'> OC</td>";   
			$tablaclientes .="<td "."width="."55"." class="."TableShowT"." style='text-align:right;'> COA</td>";   
			$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Registr&oacute;</td>";
			$tablaclientes .='</tr>';    
			$recuento=0; $clase="TableShowD"; 
			$estilo=" style='cursor:pointer;' ";$_SESSION['TxtOriStock']=1;//para que vuelva a esta pagina      
			//Datos
			while($row=mysql_fetch_array($rs)){ 
				$link=" onclick="."location='Modificar.php?Flag1=True&id=".$row['Id']."'";
				//articulo,producto u observaciones
				$textoart='';$abr='';
				if($row['IdArticulo']>0){
					$textoart=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
				}
				if($row['IdProd']>0){
					$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
				}

				$ingreso="";$egreso="";
				if($row['IdTipoMov']==1 or $row['IdTipoMov']==3){$ingreso=$row['Cantidad'];}else{$egreso=$row['Cantidad'];}	
				if($row['NroOC']=='0' or $row['NroOC']==''){$oc='';}else{$oc=$row['NroOC'];}
				if($row['IdCAMi']==0){$idcam='';}else{$idcam=str_pad($row['IdCAMi'], 6, "0", STR_PAD_LEFT);}
				//muestro
				$tablaclientes .='<tr '.$estilo.GLO_highlight($row['IdIST']).'>';   
				$tablaclientes .="<td class=".$clase.$link." > ".FormatoFecha($row['Fecha'])."</td>";
				$tablaclientes .="<td class=".$clase.$link." style='text-align:center;'> ".STOCK_ColorMovimiento($row['IdTipoMov'])."</td>";
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['TipoM'],0,10)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";  
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$ingreso."</td>"; 
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$egreso."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".$abr."</td>"; 
				$tablaclientes .="<td class=".$clase.$link.' title="'.$textoart.'">'.substr($textoart,0,34)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Proveedor'],0,10)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cliente'],0,10)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Deposito'],0,12)."</td>"; 
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$oc."</td>"; 
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$idcam."</td>"; 
				$tablaclientes .="<td class=".$clase.$link." > ".substr($row['AAudi'].' '.$row['NAudi'],0,6)."</td>"; 
				$tablaclientes .='</tr>'; 
				$recuento++;
			}mysql_free_result($rs);	
			$tablaclientes .=GLO_fintabla(0,0,$recuento);
			echo $tablaclientes;	
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	
}
}


GLOF_Init('','BannerConMenuHV','zStockD',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,"Inbox.php",'MOVIMIENTOS DE STOCK DETALLE','linksalir');

?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td  height=3 width="70" ></td><td  width="100"></td><td width="130"></td><td width="70"></td><td width="100"></td><td width="60"></td><td width="70"></td><td width="100"></td></tr>
<tr><td  align="right">Fecha:</td><td width="100" >&nbsp;<input name="TxtFechaDST"  id="TxtFechaDST" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaDST']; ?>"   ><?php  calendario("TxtFechaDST","../Codigo/","actual"); ?></td><td width="140" > al&nbsp;<input name="TxtFechaHST"  id="TxtFechaHST" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaHST']; ?>"   ><?php  calendario("TxtFechaHST","../Codigo/","actual"); ?></td><td align="right">Dep&oacute;sito:</td><td>&nbsp;<select name="CbDeposito" class="campos" id="CbDeposito"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("depositos","CbDeposito","Nombre","","",$conn); ?></select></td><td align="right">COA:</td><td>&nbsp;<input  name="TxtIdCAM" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtIdCAM'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td><input name="ChkTipo"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkTipo'] =='1') echo 'checked'; ?>> Falta COA</td></tr>

<tr><td  align="right" >Art&iacute;culo:</td><td colspan="2">&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:180px" maxlength="30" onKeyDown="enterxtab(event)"></td><td align="right">Tipo:</td><td>&nbsp;<select name="CbTipoMS" class="campos" id="CbTipoMS"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("stock_tipomov","CbTipoMS","Nombre","","",$conn); ?></select></td><td align="right">Pedido:</td><td>&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td  align="right" >&nbsp;</td>	</tr>

<tr><td  align="right">Propietario:</td><td  colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right">Origen:</td><td>&nbsp;<select name="CbOrigen" class="campos" id="CbOrigen"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("stockmov_origen","CbOrigen","Nombre","","",$conn); ?></select></td><td align="right"></td><td>&nbsp;</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>

</table>



<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQStockDPL',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

PLA_verimagenplanta();//imagen planta

include ("../Codigo/FooterConUsuario.php");
?>