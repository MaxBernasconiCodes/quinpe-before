<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);

include("Includes/zMostrarU.php");

GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','zModificar',0,0,0,0);

include("Includes/zCamposU.php");

//ges(2)
if( intval($_SESSION['CbTipo'])==2){include("Includes/zCamposG.php");}

GLO_obs(740,100,'Conclusiones','TxtObs',2,0,4);
GLO_guardar("740",5,0);
GLO_mensajeerror(); 

include("Includes/zMostrarT.php");

GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>