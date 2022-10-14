<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLOF_Init('TxtAnio','BannerConMenuHV','zAlta',0,'',0,0,0);
GLO_tituloypath(0,700,'../PSSA.php','PSSA','linksalir');
?> 

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="80" height="3"  ></td> <td width="130"></td><td width="70" height="3"  ></td><td width="130"></td><td width="100"></td> <td width="190"></td></tr>
<tr> <td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top">&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:60px"><input  name="TxtId"   type="hidden"   value="<? echo $_SESSION['TxtId']; ?>"></td><td align="right"  >A&ntilde;o:</td><td  valign="top">&nbsp;<input name="TxtAnio" type="text"  tabindex="1"  class="TextBox" style="width:65px" maxlength="4"  value="<? echo $_SESSION['TxtAnio']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Actualizado:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?> </td></tr>
</table>



<?
GLO_botonesform("700",0,2);
GLO_mensajeerror();
mysql_close($conn); 
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php")
?>