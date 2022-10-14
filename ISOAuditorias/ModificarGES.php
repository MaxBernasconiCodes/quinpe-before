<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
GLO_PerfilAcceso(14);



include("Includes/zMostrarU.php");



GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','zModificarGES',0,0,0,0);



include("Includes/zCamposU.php");

?>







<table width="740" border="0"  cellspacing="0" class="Tabla TMT" >

<tr><td width="100" height="5"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="110"></td><td width="175"></td> </tr>

<tr> <td height="18"  align="right" valign="top">Dirigido a:</td><td  valign="top" colspan="4">&nbsp;<input name="TxtDir" type="text" class="TextBox" style="width:600px" maxlength="200"  value="<? echo $_SESSION[TxtDir]; ?>"> </td></tr>

<tr> <td height="18"  align="right" valign="top">Objetivos:</td><td  valign="top" colspan="4">&nbsp;<textarea name="TxtObj" style="width:600px" rows="1" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION[TxtObj]; ?></textarea> </td></tr>

</table>







<? 

GLO_botonesform("740",0,2); 

GLO_mensajeerror(); 



include("Includes/zMostrarT.php");



GLO_cierratablaform(); 

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>