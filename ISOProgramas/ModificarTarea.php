<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);

//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

include("Includes/zMostrarTA.php");

GLO_InitHTML($_SESSION["NivelArbol"],'TxtObs2','BannerPopUp','zModificarTarea',0,0,0,0);

include("Includes/zCamposTA.php");

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>