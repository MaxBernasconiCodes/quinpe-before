<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);

GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',0,'',0,0,0); 
GLO_tituloypath(0,550,'../ISO_Norma.php','NORMAS DE CALIDAD','linksalir');
?> 

<table width="550" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="450"></td></tr>
<tr><td  align="right"  >Nombre:</td><td >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:300px" maxlength="30"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"> <label class="MuestraError"> * </label></td></tr>
<tr><td  align="right"  >Baja:</td><td >&nbsp;<?  GLO_calendario("TxtFechaB","../Codigo/","actual",1); ?></td></tr>
</table>

<?
GLO_Hidden('TxtNumero',0);
GLO_botonesform("550",0,2); 
GLO_mensajeerror();
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>