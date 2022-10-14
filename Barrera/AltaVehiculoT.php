<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);
 
//alta terceros vehiculo

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}
if (empty($_SESSION['TxtHora'])){ $_SESSION['TxtHora']=date("H:i");}
$_SESSION['CbTipo']=2;//terceros

//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zAltaVehiculoT',0,'',0,0,0); 
GLO_tituloypath(0,760,'Consulta.php','BARRERA','linksalir');

include ("Includes/zCamposVehiculo.php");//encabezado comun a propios y terceros

//agregar a solicitud <label class="MuestraError"> * </label> y la validacion en zalta
?>

<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Propietario Camion:</td><td >&nbsp;<select name="CbCliente"  tabindex="3" style="width:250px" class="campos" id="CbCliente" ><option value="">Seleccione Cliente</option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td align="right"  >DNI Conductor:</td><td>&nbsp;<input name="TxtDoc" type="text"  tabindex="4" class="TextBox"  maxlength="13"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtDoc']; ?>" /><label class="MuestraError"> * </label></td></tr>

<tr> <td height="18"  align="right"  >Propietario Camion:</td><td >&nbsp;<select name="CbProv"  tabindex="3" style="width:250px" class="campos" id="CbProv" ><option value="">Seleccione Proveedor</option> <? ComboProveedorRFX("CbProv","",$conn); ?> </select></td><td align="right"  >Solicitud:</td><td>&nbsp;<select name="TxtNroEntidad" style="width:200px" class="campos TL12 TBold" id="TxtNroEntidad"  tabindex="4"><option value=""></option>'<? GLO_CbComprobanteBQ("procesosop","TxtNroEntidad","a.Fecha DESC",6,"","and a.Estado=0",$conn); ?></select></td></tr>
</table>


<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
GLO_guardar(760,4,0);
GLO_mensajeerror(); 

GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(760,0);
echo 'Escriba el numero de <font class="comentario2">Solicitud</font> para buscarlo mas facilmente en la lista<br>';
echo 'Solo muestra las <font class="comentario3">Solicitudes</font> que estan <font class="comentario2">Abiertas</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>