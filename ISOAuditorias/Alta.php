<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


GLO_InitHTML($_SESSION["NivelArbol"],'CbTipo','BannerConMenuHV','zAlta',0,0,0,0);
GLO_tituloypath(950,740,'../ISO_Auditorias.php','AUDITORIA','linksalir');
?> 

<table width="740" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="5"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="185"></td> </tr>
<tr> <td height="18"  align="right"  >Tipo:</td><td  valign="top">&nbsp;<select name="CbTipo" style="width:220px"  tabindex="1" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("iso_audi_tipo","CbTipo","Id","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Programada:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",2) ?></td><td><label class="MuestraError"> * </label> </td></tr>

<tr> <td height="18"  align="right"  >Sector:</td><td  valign="top">&nbsp;<select name="CbSector" style="width:220px" class="campos" tabindex="1" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  ></td><td  valign="top">&nbsp;</td><td></td></tr>
</table> 



<table width="740" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="640"></td></tr>
<tr> <td  align="right" height="18">Nombre:</td><td >&nbsp;<input name="TxtNombre" type="text" class="TextBox"   tabindex="3"  style="width:590px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" > <label class="MuestraError"> * </label></td></tr>
</table> 

<? 
GLO_guardar("740",4,0); 
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn); 
?> 

<? include ("../Codigo/FooterConUsuario.php");?>