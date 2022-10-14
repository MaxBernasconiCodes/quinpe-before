<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
GLO_PerfilAcceso(14);



include("Includes/zMostrarU.php");



GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','zModificarCOM',0,0,0,0);



include("Includes/zCamposU.php");

 

GLO_botonesform("740",0,2); 

GLO_mensajeerror(); 



include("Includes/zMostrarT.php");



GLO_cierratablaform(); 

mysql_close($conn); 

?>

				

<? include ("../Codigo/FooterConUsuario.php");?>