<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['Id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);



GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUp','zAltaDesarrollo',0,0,0,0);



include("Includes/zCamposDES.php");

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>