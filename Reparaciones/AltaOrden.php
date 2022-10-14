<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";

require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php") ;

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



if (empty($_SESSION['TxtFecha1'])) { $_SESSION['TxtFecha1']=date("d-m-Y");}



GLOF_Init('CbUnidad','BannerConMenuHV','zAltaOrden',1,'MenuH',0,0,0);

GLO_tituloypath(0,750,'Ordenes.php','ORDENES MANTENIMIENTO','linksalir'); 



include ("zCamposOrden.php");



GLO_botonesform(750,0,2);

GLO_mensajeerror(); 

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>