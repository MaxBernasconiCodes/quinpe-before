<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}
if (intval($_SESSION['TxtNro'])==0){$_SESSION['TxtNro']=str_pad(GLO_Correlativo('co_ocompra','Nro',$conn), 8, "0", STR_PAD_LEFT);}


//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtNro','BannerConMenuHV2','zAltaOrden',0,0,0,0);
GLO_tituloypath(950,720,'Ordenes.php','ORDEN DE COMPRA','linksalir');
?> 

<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="110" height="3"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="155"></td> </tr>
<tr><td height="18"  align="right"  >O.Compra:</td><td  valign="top" >&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION[TxtNro]; ?>" tabindex="1"  onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"><label class="MuestraError"> * </label> &nbsp;&nbsp;&nbsp;&nbsp;Nro.Interno:&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION[TxtNumero]; ?>"></td><td height="18"  align="right"  >Alta:</td><td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:60px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION[TxtFechaA]; ?>"   ><? calendario("TxtFechaA","../Codigo/","actual") ?></td><td align="right"><input name="CmdItems" type="submit" class="boton02" value="Pedidos" onClick="document.Formulario.target='_blank'">&nbsp;</td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top">&nbsp;<select name="CbProv" style="width:220px" class="campos" id="CbProv" ><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select><label class="MuestraError"> * </label></td>
<td height="18"  align="right"  ></td><td  valign="top" colspan="2"></td></tr>
<tr> <td height="18"  align="right"  >Ejecutante:</td><td  valign="top">&nbsp;<select name="CbEje" style="width:220px" class="campos"><option value=""></option><? ComboPersonalRFX('CbEje',$conn); ?></select><label class="MuestraError"> * </label> </td><td height="18"  align="right"  >&nbsp;</td><td  valign="top" colspan="2"> </td></tr>
<tr> <td height="18"  align="right"  >Autorizante:</td><td  valign="top">&nbsp;<select name="CbAuto" style="width:220px" class="campos"><? NP_AutorizanteRF("CbAuto",$conn); ?></select><label class="MuestraError"> * </label> </td><td height="18"  align="right"  >&nbsp;</td><td  valign="top" colspan="2"> </td></tr>
</table> 


<? 
include("Includes/zCamposOC.php");
GLO_botonesform("720",0,2);
GLO_Hidden('TxtId',0);
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>