<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('TxtFechaA','BannerConMenuHV','zAltaCotizacion',0,'MenuH',0,0,0);
GLO_tituloypath(950,720,'Cotizaciones.php','COTIZACION','linksalir');
?> 

<table width="720" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="310"></td><td width="70" height="3"  ></td><td width="240"></td> </tr>
<tr><td height="18"  align="right"  >Cotizaci&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>">&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td height="18"  align="right"  ></td>
<td align="right"><input name="CmdItems" type="submit" class="boton02" style="height:18px" value="Pedidos" onClick="document.Formulario.target='_blank'">&nbsp;</td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top"> &nbsp; <select name="CbProv" style="width:270px" class="campos" id="CbProv" ><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select><label class="MuestraError"> * </label></td><td align="right"></td><td></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top"> &nbsp; <input name="TxtObs2" type="text"  class="TextBox" style="width:270px" maxlength="50"  value="<? echo $_SESSION['TxtObs2']; ?>" onkeyup="this.value=this.value.toUpperCase()" ></td><td align="right"></td><td></td></tr>
<tr> <td height="18"  align="right"  >Estado:</td><td  valign="top">&nbsp; <select name="CbEstado" style="width:100px" class="campos"><option value=""></option> <? ComboTablaRFX("co_pcotiz_est","CbEstado","Id","","",$conn); ?></select> </td><td align="right"></td><td></td></tr>
</table> 
  
<? 
GLO_Hidden('TxtId',0);
GLO_obsform(720,100,'Observaciones','TxtObs',2,0);
GLO_botonesform("720",0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(720,0);
echo 'Se puede registrar un <font class="comentario2">Proveedor</font> <font class="comentario3">existente</font> en el sistema, o uno <font class="comentario3">sugerido</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php"); 
?>