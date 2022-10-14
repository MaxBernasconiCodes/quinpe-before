<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
GLO_PerfilAcceso(14);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



GLOF_Init('TxtNro','BannerConMenuHV','zAlta',0,'',0,0,0); 

include ("zCampos.php");

mysql_close($conn);

include ("../Codigo/FooterConUsuario.php");

?>