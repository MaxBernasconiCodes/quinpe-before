<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',0,'MenuH',0,0,0); 
GLO_tituloypath(0,720,'Consulta.php','ACCESORIO','linksalir');

include ("Includes/zCampos.php"); 

mysql_close($conn);
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>