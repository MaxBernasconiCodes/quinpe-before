<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('TxtFechaA','BannerConMenuHV','zAltaOportunidad',0,'MenuH',0,0,0); 

include("Includes/zCamposOPO.php");  
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(720,0);
//echo 'S&oacute;lo considera <font class="comentario2">Solicitudes</font> del Cliente <font class="comentario3">Aceptadas</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>