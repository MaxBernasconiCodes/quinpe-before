<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',0,'../ISODoc/MenuH',0,0,0); 
GLO_tituloypath(0,500,'../ISO_Resp.php','RESPONSABLE','linksalir');
?> 




<table width="500" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Acci&oacute;n:</td><td  valign="top" > &nbsp; <select name="CbAccion" style="width:300px" class="campos"><option value=""></option><? ComboTablaRFX("iso_doc_acciones","CbAccion","Id","","",$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Nombre:</td><td  valign="top" > &nbsp; <select name="CbPersonal" style="width:300px" class="campos"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">&nbsp;Alta:</td><td  valign="top"> &nbsp; <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   >
<? calendario("TxtFechaA","../Codigo/","actual") ?><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right">&nbsp;Baja:</td><td  valign="top"> &nbsp; <input name="TxtFechaB" id="TxtFechaB"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"   >
<? calendario("TxtFechaB","../Codigo/","actual") ?></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform("500",0,2);
GLO_mensajeerror();
mysql_close($conn);
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>