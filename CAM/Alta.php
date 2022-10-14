<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (intval($_SESSION['CbPersonal'])==0){ $_SESSION['CbPersonal']=intval($_SESSION["GLO_IdPersLog"]);}
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zAlta',0,'MenuH',0,0,0); 
GLO_tituloypath(0,750,'../CAM.php','CERTIFICADO ANALISIS','linksalir');

include ("zCampos.php");
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>