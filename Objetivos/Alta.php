<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
include("zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
if(intval($_GET['ido'])==0 or intval($_GET['ido'])>5){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$_SESSION['TxtNroEntidad'] = intval($_GET['ido']);//me dice que objetivo voy a modificar


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('TxtAnio','BannerConMenuHV','zAlta',0,'',0,0,0);

include ("Includes/zCamposObj.php");

GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>