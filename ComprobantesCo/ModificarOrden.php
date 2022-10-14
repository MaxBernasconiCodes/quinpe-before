<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//solo agregar/eliminar items si el estado de la orden es 1
//si los items no estan asociados a mov stock, entonces puede modificar el proveedor

//mostrar campos
if ($_GET['Flag1']=="True"){
	$query="SELECT co.*,e.Nombre as Estado From co_ocompra co,co_ocompra_est e where co.Id<>0 and co.IdEstado=e.Id and co.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA'] =FormatoFecha($row['Fecha']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['TxtObs'] =$row['Obs'];
		$_SESSION['CbProv'] =$row['IdProv'];
		$_SESSION['TxtIdEstado']= $row['IdEstado'];
		$_SESSION['CbEje'] =$row['IdPerEjec'];
		$_SESSION['CbAuto'] =$row['IdPerAuto'];
		$_SESSION['ChkEfe'] =$row['Efe'];
		$_SESSION['ChkChe'] =$row['Che'];
		$_SESSION['ChkCC'] =$row['CC'];
		$_SESSION['ChkTran'] =$row['Tran'];
		$_SESSION['ChkTranD'] =$row['TranD'];
		$_SESSION['ChkF1'] =$row['Fact1'];
		$_SESSION['ChkRem'] =$row['Rem'];
		$_SESSION['TxtEfe'] =$row['Efe2'];
		$_SESSION['TxtChe'] =$row['Che2'];
		$_SESSION['TxtF1'] =$row['Fact1Nro'];
		$_SESSION['TxtRem'] =$row['RemNro'];
		$_SESSION['TxtEstado'] =$row['Estado'];
		$_SESSION['TxtNro']= str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);
	}
	mysql_free_result($rs);
	//validar si tiene RI asociado
	$idcompr=$_SESSION['TxtNumero'];
	$query="Select i.Id From stockmov_items i Where i.IdOC=$idcompr"; $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$_SESSION['TxtFCRIAsociado']=1;}else{$_SESSION['TxtFCRIAsociado']=0;}
	mysql_free_result($rs);
	
	
}



//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtNro','BannerConMenuHV2','zModificarOrden',0,0,0,0);
GLO_tituloypath(0,720,'','ORDEN DE COMPRA','salir');
?>


<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="110" height="3"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="155"></td> </tr>
<tr><td height="18"  align="right"  >O.Compra:</td><td  valign="top" >&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION[TxtNro]; ?>" tabindex="1"  onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"><label class="MuestraError"> * </label> &nbsp;&nbsp;&nbsp;&nbsp;Nro.Interno:&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION[TxtNumero]; ?>"></td><td height="18"  align="right"  >Alta:</td>
<td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:60px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION[TxtFechaA]; ?>"   ><? calendario("TxtFechaA","../Codigo/","actual") ?></td><td><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top">&nbsp;<select name="CbProv" style="width:220px" class="campos" id="CbProv" ><? if(intval($_SESSION['TxtFCRIAsociado']==1)){ComboProveedorRFROX("CbProv",intval($_SESSION['CbProv']),"",$conn);}else{ComboProveedorRFX("CbProv","",$conn);} ?></select><label class="MuestraError"> * </label></td>
<td height="18"  align="right"  >Estado:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtEstado" type="text"  class="TextBoxRO" <?  if ($_SESSION['TxtIdEstado']==2){ echo 'style="font-weight:bold;color:#4CAF50;width:150px"';}else{if ($_SESSION['TxtIdEstado']==3 or $_SESSION['TxtIdEstado']==6 ){ echo 'style="font-weight:bold;color:#f44336;width:150px"';}else{if ($_SESSION['TxtIdEstado']==5 ){ echo 'style="font-weight:bold;color:#00bcd4;width:150px"';}else{echo 'style="width:150px"';}}} ?> readonly="true" value="<? echo $_SESSION[TxtEstado]; ?>"></td></tr>
<tr> <td height="18"  align="right"  >Ejecutante:</td><td  valign="top">&nbsp;<select name="CbEje" style="width:220px" class="campos"><option value=""></option><? ComboPersonalRFX('CbEje',$conn); ?></select><label class="MuestraError"> * </label> </td><td height="18"  align="right"  >&nbsp;</td><td  valign="top" colspan="2">

<? 
//solo cambia estado si no tiene asociado RI
if($_SESSION['TxtFCRIAsociado']==0){
//1.Abierto apr/rech/anular
if ($_SESSION['TxtIdEstado']==1){
	echo '&nbsp;<input name="CmdAuto" type="submit" class="boton02"  value="Aprobar" style="color:#4CAF50; border-color:#4CAF50;width:70px" onClick="document.Formulario.target='."'_self'".'">';
	echo '&nbsp;<input name="CmdRech" type="submit" class="boton02"  value="Rechazar" style="color:#f44336; border-color:#f44336;width:70px" onClick="document.Formulario.target='."'_self'".'">';
		echo '&nbsp;<input name="CmdAnular" type="submit" class="boton02"  value="Anular" style="color:#f44336; border-color:#f44336;width:70px" onClick="document.Formulario.target='."'_self'".'">';
}
//2.Aprobado  enviar/abrir(atras)/anular
if ($_SESSION['TxtIdEstado']==2){
	echo '&nbsp;<input name="CmdEnviar" type="submit" class="boton02"  value="Enviar" style="color:#00bcd4; border-color:#00bcd4;width:70px" onClick="document.Formulario.target='."'_self'".'">';
	echo '&nbsp;<input name="CmdAbrir" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';
		echo '&nbsp;<input name="CmdAnular" type="submit" class="boton02"  value="Anular" style="color:#f44336; border-color:#f44336;width:70px" onClick="document.Formulario.target='."'_self'".'">';
}
//3.Rechazado abrir(atras)/anular
if ( $_SESSION['TxtIdEstado']==3){
	echo '&nbsp;<input name="CmdAbrir" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';
		echo '&nbsp;<input name="CmdAnular" type="submit" class="boton02"  value="Anular" style="color:#f44336; border-color:#f44336;width:70px" onClick="document.Formulario.target='."'_self'".'">';
}
//4.Enviado cerrar/anular/aprobar(atras)
if ($_SESSION['TxtIdEstado']==4){
	echo '&nbsp;<input name="CmdCerrar" type="submit" class="boton02"  value="Cerrar" style="color:#00bcd4; border-color:#00bcd4;width:70px" onClick="document.Formulario.target='."'_self'".'">';
	echo '&nbsp;<input name="CmdAuto" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';
	echo '&nbsp;<input name="CmdAnular" type="submit" class="boton02"  value="Anular" style="color:#f44336; border-color:#f44336;width:70px" onClick="document.Formulario.target='."'_self'".'">';
}

//5.Cerrado enviar(atras)
if ($_SESSION['TxtIdEstado']==5){
	echo '&nbsp;<input name="CmdEnviar" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';
}

//6.Anulado enviar(atras)
if ($_SESSION['TxtIdEstado']==6){
	echo '&nbsp;<input name="CmdAuto" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';
}
}
?>
 </td></tr>
<tr> <td height="18"  align="right"  >Autorizante:</td><td  valign="top">&nbsp;<select name="CbAuto" style="width:220px" class="campos"><? NP_AutorizanteRF("CbAuto",$conn); ?></select><label class="MuestraError"> * </label> </td><td height="18"  align="right"  >&nbsp;</td><td  valign="top" colspan="2"> </td></tr>
</table> 


<? include("Includes/zCamposOC.php");?>

<!-- firma digital -->
<table width="720" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td align="right"><input name="ChkFirma"  type="checkbox"  value="1" <? if ($_SESSION[ChkFirma] =='1') echo 'checked'; ?>>Firma Autorizante en PDF &nbsp;&nbsp;&nbsp;<input name="ChkVer"  type="checkbox"  value="1" <? if ($_SESSION['ChkVer'] =='1') echo 'checked'; ?>>Observaciones Items en PDF &nbsp; </td></tr>
</table>

<?
//guardar cambios : si estado no es ni auto ni rech
if(intval($_SESSION['TxtIdEstado'])<=1){GLO_botonesform("720",0,2);}


GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdEstado',0);GLO_Hidden('TxtFCRIAsociado',0);
GLO_mensajeerror();
OC_TablaItems($_SESSION['TxtNumero'],$conn); 
OC_VerObsNP($_SESSION['TxtNumero'],$conn);
OC_VerObsNPI($_SESSION['TxtNumero'],$conn);
OC_VerArchivosNP($_SESSION['TxtNumero'],$conn);
GLO_cierratablaform(); 
mysql_close($conn);

GLO_initcomment(950,0);
echo 'Solo se pueden <font class="comentario3">Agregar</font> y  <font class="comentario3">Eliminar</font> Pedidos, si la Orden est&aacute; <font class="comentario2">Abierta</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>