<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


//si viene de articulos valida get
$_SESSION['TxtNroEntidad']=intval($_GET['Id']);
if(intval($_SESSION['TxtOriACCCertif'])==0){
    GLO_ValidaGET($_GET['Id'],0,0);
    $_SESSION['CbInstrumento']=$_SESSION['TxtNroEntidad'];
}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLOF_Init('CbInstrumento','BannerPopUp','zAltaCE',0,'',0,0,0); 

//campos
$readonly=0;
include ("Includes/zCamposCE.php");


GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>