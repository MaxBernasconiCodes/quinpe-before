<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['id'],0,0);
$_SESSION['TxtNumero']=$_GET['id'];

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLOF_Init('','BannerPopUp','zRankingVial',0,'',0,0,0); 
GLO_tituloypath(0,700,'','RANKING VIAL','salir');

GLO_files($_SESSION['TxtNumero'],$conn,"personalarchivosrv","700","Archivos adjuntos","paperclip",0,0,0,1);

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_mensajeerror(); 
GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>