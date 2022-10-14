<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['Id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFecha'])){ $_SESSION['TxtFecha']=date("d-m-Y");}

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);



GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerConMenuHV','zAltaPendiente',0,0,0,0);



include("Includes/zCamposPEN.php");



GLO_cierratablaform();

mysql_close($conn); 

?>			

			



<? include ("../Codigo/FooterConUsuario.php");?>