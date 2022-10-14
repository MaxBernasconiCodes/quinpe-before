<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);
 

//alta persona terceros 

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}
if (empty($_SESSION['TxtHora'])){ $_SESSION['TxtHora']=date("H:i");}
$_SESSION['CbTipo']=2;//tercero


//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zAltaPersonaT',0,'',0,0,0); 
GLO_tituloypath(0,760,'Consulta.php','BARRERA','linksalir');

include ("Includes/zCamposPersona.php");//encabezado comun a propios y terceros
?>



<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Cliente:</td><td >&nbsp;<select name="CbCliente"  tabindex="3" style="width:250px" class="campos" id="CbCliente" ><option value="">Seleccione Cliente</option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td align="right"  >DNI:</td><td>&nbsp;<input name="TxtDoc" type="text"  tabindex="4" class="TextBox"  maxlength="13"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtDoc']; ?>" /><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td >&nbsp;<select name="CbProv"  tabindex="3" style="width:250px" class="campos" id="CbProv" ><option value="">Seleccione Proveedor</option> <? ComboProveedorRFX("CbProv","",$conn); ?> </select></td><td align="right"  ></td><td></td></tr>
</table>


<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
GLO_guardar(760,4,0);
GLO_mensajeerror(); 

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>