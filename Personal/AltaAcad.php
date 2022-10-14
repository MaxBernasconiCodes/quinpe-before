<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

GLOF_Init('TxtFechaA','BannerPopUp','zAltaAcad',0,'',0,0,0); 
GLO_tituloypath(0,600,'','INFORMACION ACADEMICA','salir');
?> 


<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="110"></td><td width="390"></td></tr>
<tr><td height="18"  align="right"  >Desde:</td><td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      > <?php  calendario("TxtFechaA","../Codigo/","nac"); ?> </td><td><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Hasta:</td><td  valign="top"  colspan="2">&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      > <?php  calendario("TxtFechaB","../Codigo/","nac"); ?></td></tr>
<tr><td height="18"  align="right"  >Estudios:</td><td  valign="top" colspan="2">&nbsp;<select name="CbTipo"  tabindex="1" style="width:250px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("estudios","CbTipo","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Promedio:</td><td  valign="top" colspan="2">&nbsp;<input  name="TxtEval" type="text"  class="TextBox" style="width:60px;text-align:right" maxlength="6"  tabindex="1"   value="<? echo $_SESSION['TxtEval'];?>"  onchange="this.value=validarNumero(this.value);"></td></tr>
</table>


<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(600,100,'Institucion','TxtObs2',0,2);//ch100
GLO_obsform(600,100,'Titulo','TxtObs3',0,2);//ch100
GLO_obsform(600,100,'Observaciones','TxtObs',2,0);
GLO_botonesform("600",0,2);
GLO_mensajeerror();            
GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php"); 
?>