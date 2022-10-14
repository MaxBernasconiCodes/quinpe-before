<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);

//si viene de accesorios valida get
$_SESSION['TxtNroEntidad']=intval($_GET['Id']);
if(intval($_SESSION['TxtOriACCAsig'])==0){
    GLO_ValidaGET($_GET['Id'],0,0);
    $_SESSION['CbInstrumento']=$_SESSION['TxtNroEntidad'];
}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}


GLOF_Init('','BannerPopUp','zAltaAsignacion',0,'',0,0,0); 
include ("Includes/zCamposAsig.php");
?>