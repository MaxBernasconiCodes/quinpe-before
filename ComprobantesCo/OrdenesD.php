<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION[TxtFechaDORD])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;$mesrestar=1;
	$_SESSION[TxtFechaDORD]=date("d-m-Y", strtotime("$primerdiames -$mesrestar month"));$_SESSION[TxtFechaHORD]=$hoy;
}




function MostrarTabla($conn){
$query=$_SESSION['TxtQuery19'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(1120,0,0,0);
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> OC</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .='<td width="60" class="TablaTituloDato"> Alta</td>';  
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."90"." class="."TablaTituloDato"."> Proveedor</td>"; 		
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."90"." class="."TablaTituloDato"."> Solicitante</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Cant</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato"."> </td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."270"." class="."TablaTituloDato"."> Art&iacute;culo</td>";
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."90"." class="."TablaTituloDato"."> Marca</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."90"." class="."TablaTituloDato"."> Modelo</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"." style='text-align:right;'>Pedido</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato".">Rem.Ingreso</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato"."> Estado OC</td>"; 
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0; 
		$estilo=" style='cursor:pointer;' ";  $_SESSION['TxtOriCOORD']=1;//para que vuelva a esta pgina
		$clase="TablaDato";	       
		while($row=mysql_fetch_array($rs)){ 
			$link=" onclick="."location='ModificarOrden.php?Flag1=True&id=".$row['Id']."'";
			//estado
			$colorest='';
			if($row['IdEstado']==2){$colorest=' style="font-weight:bold;color:#4CAF50"';}
			if($row['IdEstado']==5){$colorest=' style="font-weight:bold;color:#00bcd4"';}
			if($row['IdEstado']==3 or $row['IdEstado']==6){$colorest=' style="font-weight:bold;color:#f44336"';}				
			//obtengo REMITO INGRESO
			$remitoingreso='';$nroremitoingreso=0;$pdte=0;
			$query="SELECT r.*,ri.Cantidad,npi.CantAuto  From stockmov r,stockmov_items ri,co_npedido_it npi,co_ocompra_it coi Where ri.IdMov=r.Id and ri.IdItemOC=coi.Id and r.IdTipoMov=3 and coi.IdItemNP=npi.Id and ri.IdItemOC=".$row['IdItemOC'];
			$rs2=mysql_query($query,$conn);
			while($row2=mysql_fetch_array($rs2)){
				$remitoingreso=$row2['Tipo'].str_pad($row2['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row2['Nro'], 8, "0", STR_PAD_LEFT);
				$nroremitoingreso=$row2['Id'];
				$pdte=0;$pdte=$row2['CantAuto']-$row2['Cantidad'];
				if($pdte>0){$colorrem=' style="color:#f44336"';}else{$colorrem='';}
			}mysql_free_result($rs2);	
			if(($_SESSION['ChkPE']=="1" and $nroremitoingreso>0) or ($_SESSION['ChkRE']=="1" and $nroremitoingreso==0) or ($_SESSION['ChkPA']=="1" and $pdte<=0)){}
			else{				
				$tablaclientes .='<tr '.$estilo.'>';  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
				$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
				$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,10)."</td>";  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['ApeS'].' '.$row['NomS'],0,10)."</td>";  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".$row['CantAutoItem']."</td>"; 
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Abr'],0,5)."</td>";  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link.' title="'.$row['Articulo'].'">'.str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.substr($row['Articulo'],0,20)."</td>";  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Marca'],0,9)."</td>";  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
				$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Modelo'],0,9)."</td>";  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['NroNP'], 8, "0", STR_PAD_LEFT)."</td>"; 
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link.$colorrem."> ".$remitoingreso."</td>";  
				$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
				$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,9)."</td>";  
				$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
				$tablaclientes .='</tr>'; 
				$recuento=$recuento+1;
			}
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}





//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaDORD','BannerConMenuHV','zOrdenesD',0,0,0,0);
GLO_tituloypath(0,780,"Ordenes.php",'ORDENES DE COMPRA DETALLE','linksalir');
?> 


<table width="780" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="210"></td><td width="70"></td><td width="70"></td><td width="30"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaDORD","../Codigo/","actual",1) ?></td>
     <td> al&nbsp;<? GLO_calendario("TxtFechaHORD","../Codigo/","actual",1) ?></td><td align="right">Servicio/CC:</td><td>&nbsp;<select name="CbCentro" class="campos" id="CbCentro"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? CompletarComboServicioRFX("CbCentro",$conn); ?></select></td><td  align="right">Nro.Int.OC:</td><td colspan="2">&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION[TxtNroInterno];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:70px"></td> </tr>
<tr> 
<td height="18"  align="right">Sector:</td><td   colspan="2">&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td>
<td  align="right">Unidad:</td><td >&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?></select></td>
<td  align="right">OC:</td><td  colspan="2">&nbsp;<input  name="TxtNroOC" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION[TxtNroOC];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:70px"></td></tr>
<tr><td height="18"  align="right">Punto Pedido:</td><td   colspan="2">&nbsp;<select name="CbPPED" class="campos" id="CbPPED"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("puntospedido","CbPPED","Nombre","","",$conn); ?></select></td>
<td  align="right">Proveedor:</td><td >&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td><td  align="right">Pedido:</td><td  colspan="2">&nbsp;<input  name="TxtNroPI" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION[TxtNroPI];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:70px"></td></tr>
<tr><td height="18"  align="right">Solicitante:</td><td   colspan="2">&nbsp;<select name="CbSoli" class="campos" id="CbSoli"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalSoliNP($conn); ?></select></td>
<td  align="right">Art&iacute;culo:</td><td >&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:180px" maxlength="30" onKeyDown="enterxtab(event)"></td><td  align="right">Estado:</td><td  colspan="2">&nbsp;<select name="CbEstado" style="width:70px" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("co_ocompra_est","CbEstado","Id","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right">Autorizante:</td><td   colspan="2">&nbsp;<select name="CbAuto" class="campos" id="CbAuto"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalAutoNP($conn); ?></select></td>
<td  align="right"></td><td   colspan="2"><input name="ChkPE"  type="checkbox"  value="1" <? if ($_SESSION[ChkPE] =='1') echo 'checked'; ?>>OC Pendientes &nbsp;&nbsp;&nbsp;<input name="ChkRE"  type="checkbox"  value="1" <? if ($_SESSION[ChkRE] =='1') echo 'checked'; ?>>Realizadas &nbsp;&nbsp;&nbsp;<input name="ChkPA"  type="checkbox"  value="1" <? if ($_SESSION[ChkPA] =='1') echo 'checked'; ?>>Parciales</td>
<td   align="right" colspan="2"><? GLOF_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>



<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQuery19',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);

GLO_initcomment(1120,0);
echo 'Las <font class="comentario2">OC Pendientes</font> no tienen <font class="comentario3">Remito Ingreso</font> asociado.<br>';
echo 'Las <font class="comentario2">OC Realizadas</font> tienen <font class="comentario3">Remito Ingreso</font> asociado.<br>';
echo 'Las <font class="comentario2">OC Parciales</font> tienen <font class="comentario3">Art&iacute;culos</font> pendientes de ingresar a stock.';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>