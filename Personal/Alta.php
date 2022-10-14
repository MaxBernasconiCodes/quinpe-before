<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");include("zFunciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(11);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('TxtLegajo','BannerConMenuHV','zAlta',0,'MenuH',0,0,0); 
include ("zCampos.php");

GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>