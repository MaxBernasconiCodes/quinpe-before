<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";

require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");

//perfiles
GLO_PerfilAcceso(14);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFecha'])){ $_SESSION['TxtFecha']=date("d-m-Y");}



GLO_InitHTML($_SESSION["NivelArbol"],'TxtFecha','BannerConMenuHV','zAlta',0,0,0,0);



include("Includes/zCampos.php");



GLO_cierratablaform();

mysql_close($conn); 

?> 



<? include ("../Codigo/FooterConUsuario.php");?>