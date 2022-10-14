<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

include("Includes/zMostrarU.php");	

GLO_InitHTML($_SESSION["NivelArbol"],'TxtNumero','BannerPopUp','',0,0,0,0); 
GLO_tituloypath(950,850,'','NO CONFORMIDAD','close');

include ("zCampos.php");

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>