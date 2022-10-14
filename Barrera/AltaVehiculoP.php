<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);
 
//alta propios vehiculo

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}
if (empty($_SESSION['TxtHora'])){ $_SESSION['TxtHora']=date("H:i");}
$_SESSION['CbTipo']=1;//propio

//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zAltaVehiculoP',0,'',0,0,0); 
GLO_tituloypath(0,760,'Consulta.php','BARRERA','linksalir');

include ("Includes/zCamposVehiculo.php");//encabezado comun a propios y terceros

//agregar a solicitud <label class="MuestraError"> * </label> y la validacion en zalta
?>

<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td>  <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Conductor:</td><td >&nbsp;<select name="CbPersonal" style="width:240px" class="campos" tabindex="3" id="CbPersonal" ><option value=""></option><? echo ComboPersonalRFX("CbPersonal",$conn);?></select><label class="MuestraError"> * </label></td><td align="right"  >Solicitud:</td><td>&nbsp;<select name="TxtNroEntidad" style="width:200px" class="campos TL12 TBold" id="TxtNroEntidad"  tabindex="3"><option value=""></option>'<? GLO_CbComprobanteBQ("procesosop","TxtNroEntidad","a.Fecha DESC",6,"","and a.Estado=0",$conn); ?></select> </td></tr>
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