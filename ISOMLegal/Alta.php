<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";

require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
GLO_PerfilAcceso(15);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}





GLOF_Init('TxtFechaA','BannerConMenuHV','zAlta',0,'',0,0,0); 



include("Includes/zCampos.php");

GLO_cierratablaform();

mysql_close($conn);

include ("../Codigo/FooterConUsuario.php");

?>