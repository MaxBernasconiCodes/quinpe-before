<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('CbSector','BannerConMenuHV','zAltaAuto',0,'MenuH',0,0,0);
GLO_tituloypath(0,600,'Autorizantes.php','AUTORIZANTE','linksalir');
?> 

<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr > <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Sector:</td><td  valign="top" >&nbsp;<select name="CbSector" style="width:350px" class="campos"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<select name="CbPersonal" style="width:350px" class="campos"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">Alta:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">Baja:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",1) ?></td></tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" >&nbsp;<input name="OptTipo"  type="radio"  class="radiob"    value="1"<? if ($_SESSION['OptTipo'] =='1') echo 'checked'; ?> >PreAutorizante   &nbsp;&nbsp;&nbsp;<input name="OptTipo"  type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptTipo'] =='2') echo 'checked'; ?> >Autorizante &nbsp;&nbsp;<label class="MuestraError"> * </label></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform("600",0,2);
GLO_mensajeerror(); 
mysql_close($conn); 
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>