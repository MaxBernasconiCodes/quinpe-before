<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php") ; require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['ChkReq'])){ $_SESSION['ChkReq']=1;}

GLOF_Init('TxtNombre','BannerPopUp','zAgregar',0,'',0,0,0);
GLO_tituloypath(0,720,'','ARTICULOS','close');


include ("zCampos.php");
GLO_botonesform("720",0,2);
GLO_mensajeerror();
mysql_close($conn);
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>