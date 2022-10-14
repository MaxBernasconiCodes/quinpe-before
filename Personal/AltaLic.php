<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

GLOF_Init('TxtFechaA','BannerPopUp','zAltaLic',0,'',0,0,0); 
GLO_tituloypath(0,600,'','LICENCIAS','salir');
?> 


<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="110"></td><td width="390"></td></tr>
<tr><td height="18"  align="right"  >Desde:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?> </td><td><label class="MuestraError"> * </label></td></tr>

<tr><td height="18"  align="right"  >Hasta:</td><td  colspan="2">&nbsp;<?php  GLO_calendario("TxtFechaB","../Codigo/","actual",1); ?></td></tr>

<tr><td height="18"  align="right"  >Dias gozados:</td><td  colspan="2">&nbsp;<input  name="TxtCant" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtCant'];?>" style="text-align:right;width:65px"></td></tr>

<tr><td height="18"  align="right"  >Licencia:</td><td  colspan="2">&nbsp;<select name="CbTipo"  tabindex="1" style="width:250px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("personal_lictipo","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obs(600,100,'Observaciones','TxtObs',3,0,2);
GLO_guardar("600",2,0);
GLO_mensajeerror();            
GLO_cierratablaform(); 
mysql_close($conn); 

GLO_initcomment(600,0);
echo 'La cantidad de <font class="comentario2">Dias </font> gozados son dias <font class="comentario3">corridos</font> e incluyen los dias <font class="comentario3">desde</font> y <font class="comentario3">hasta</font> en el recuento';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>