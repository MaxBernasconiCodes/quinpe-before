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
$query=$_SESSION['TxtQCOOR'];$query=str_replace("\\", "", $query);
if ( ($query!="")){	
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .=GLO_inittabla(760,0,0,0);
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."55"." class="."TablaTituloDato"." style='text-align:right;'> OC</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Alta</td>";   
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."450"." class="."TablaTituloDato"."> Proveedor</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Estado</td>"; 
		$tablaclientes .='<td class="TablaTituloLeft"></td>';
		$tablaclientes .="<td "."width="."30"." class="."TablaTituloDato"."> </td>";   
		$tablaclientes .='<td class="TablaTituloRight"></td>';  
		$tablaclientes .='</tr>';    
		$recuento=0;           
		$estilo=" style='cursor:pointer;'";$_SESSION['TxtOriCOORD']=0;//para que vuelva a esta pgina 
		$clase="TablaDato";	 
		while($row=mysql_fetch_array($rs)){ 			
			$link=" onclick="."location='ModificarOrden.php?Flag1=True&id=".$row['Id']."'";
			//estado
			$colorest='';
			if($row['IdEstado']==2){$colorest=' style="font-weight:bold;color:#4CAF50"';}
			if($row['IdEstado']==5){$colorest=' style="font-weight:bold;color:#00bcd4"';}
			if($row['IdEstado']==3 or $row['IdEstado']==6){$colorest=' style="font-weight:bold;color:#f44336"';}				
			//muestro
			$tablaclientes .='<tr '.$estilo.'>';  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,40)."</td>";  
			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
			$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,9)."</td>";  
			$tablaclientes .="<td class="."TablaMostrarLeft"."> </td><td class="."TablaDato"." style='text-align:center;'>"; 
			$tablaclientes .='<input name="CmdBorrarFila" type="submit"  class="botonborrar" title="Eliminar" value=""  id="'.$row['Id'].'"  onclick="document.Formulario.TxtId.value=this.id;return confirm('."'Eliminar'".');">';  
			$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td>";  
			$tablaclientes .='</tr>'; 
			$recuento=$recuento+1;
		}	
		$tablaclientes .=GLO_fintabla(1,0,$recuento);
		echo $tablaclientes;
	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}
	mysql_free_result($rs);
}
}


//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaDORD','BannerConMenuHV','zOrdenes',0,0,0,0);
GLO_tituloypath(0,760,"NotasPedidoD.php",'ORDENES DE COMPRA','linksalir');
?> 


<table width="760" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="80"></td><td width="100"></td><td width="130"></td><td width="80"></td><td width="70"></td><td width="130"></td><td width="130"></td><td width="40"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaDORD","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaHORD","../Codigo/","actual",1) ?></td><td align="right">Nro.Interno:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION[TxtNroInterno];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td>Nro.OC:&nbsp;<input  name="TxtNroOC" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION[TxtNroOC];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td>Nro.Pedido:&nbsp;<input  name="TxtNroPI" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION[TxtNroPI];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td>
	<td align="right"></td></tr>
<tr> 
<td height="18"  align="right">Proveedor:</td><td   colspan="2">&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td>
<td  align="right">Estado:</td><td colspan="2">&nbsp;<select name="CbEstado" style="width:120px" class="campos" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("co_ocompra_est","CbEstado","Id","","",$conn); ?> </select></td>
<td  colspan="2" align="right"><? GLOF_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>



<!--Boton agregar y tabla-->
<table  width="760" border="0" cellspacing="0" cellpadding="0"  align="center">
<tr><td  height=3></td></tr>
<tr  valign="bottom"><td  valign="bottom" align="left"><input name="CmdAgregar" type="button" class="boton"  value="Agregar" onClick="document.Formulario.target='_self';window.location.href='AltaOrden.php'"> <input name="CmdDetalle" type="button" class="boton"  value="Detalle" onClick="document.Formulario.target='_self';window.location.href='OrdenesD.php'"> </td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQCOOR',0);GLO_Hidden('TxtQCOOREX',0);
GLO_mensajeerror(); 
MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);

GLO_initcomment(760,0);
echo 'S&oacute;lo es posible <font class="comentario2">Eliminar</font> una Orden si no tiene <font class="comentario3">Items</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>