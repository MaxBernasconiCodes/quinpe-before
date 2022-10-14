<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
GLO_PerfilAcceso(16);



GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',0,'',0,0,0); 
GLO_tituloypath(0,550,'Consulta.php','REFERENCIA','linksalir');
?> 


<table width="550" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="450"></td></tr>
<tr><td  align="right"  >Nombre:</td><td >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:300px" maxlength="30"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"> <label class="MuestraError"> * </label></td></tr>
</table>


<?
GLO_obsform(550,100,'Observaciones','TxtObs',10,0);
GLO_Hidden('TxtNumero',0);
GLO_botonesform("550",0,2); 
GLO_mensajeerror();
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>