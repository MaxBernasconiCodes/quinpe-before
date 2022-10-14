<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFecha1'])) { $_SESSION['TxtFecha1']=date("d-m-Y");}
$_SESSION['TxtIdEstadoS']=1;
$_SESSION['TxtIdOrden']=0;

GLOF_Init('CbUnidad','BannerConMenuHV','zAlta',1,'MenuH',0,0,0); 
GLO_tituloypath(0,750,'Solicitudes.php','SOLICITUDES MANTENIMIENTO','linksalir'); 

include ("zCampos.php");
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn);
$_SESSION['TxtOriPage'] = "";

GLO_initcomment(750,0);
echo 'Seleccione solo <font class="comentario2">una</font> de las opciones <font class="comentario3">Unidad</font> o  <font class="comentario3">Equipo</font>, <font class="comentario3">Sector</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>