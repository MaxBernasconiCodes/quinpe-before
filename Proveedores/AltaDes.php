<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include ("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['gid'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

$query="SELECT pr.Apellido From proveedores pr where pr.Id=".intval($_GET['gid']);$rs=mysql_query($query,$conn);	
$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){ $_SESSION['TxtApellido'] = substr($row['Apellido'],0,30); }mysql_free_result($rs);


$_SESSION['TxtNroEntidad'] = str_pad($_GET['gid'], 6, "0", STR_PAD_LEFT);


GLOF_Init('TxtFechaA','BannerPopUp','zAltaDes',0,'',0,0,0); 
include ("Includes/zCamposEP.php");
GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>