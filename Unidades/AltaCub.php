<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);
if (empty($_SESSION['TxtFecha'])){ $_SESSION['TxtFecha']=date("d-m-Y");}

GLOF_Init('TxtFecha','BannerPopUp','zAltaCub',0,'',0,0,0); 
include ("Includes/zCamposCub.php");

GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>