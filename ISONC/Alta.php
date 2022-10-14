<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFecha'])){ $_SESSION['TxtFecha']=date("d-m-Y");}
?> 

<? GLO_InitHTML($_SESSION["NivelArbol"],'TxtNumero','BannerPopUpMH','zAlta',0,0,0,0); ?>
<? GLO_tituloypath(950,850,'../ISO_NC.php','NO CONFORMIDAD','linksalir'); 

include ("zCampos.php");

if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){GLO_botonesform("850",0,2);}

GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>