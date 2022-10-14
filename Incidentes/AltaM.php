<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUp','zAltaM',0,0,0,0);

include("Includes/zCamposM.php");
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>