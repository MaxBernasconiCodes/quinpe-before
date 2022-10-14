<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['Id'],0,0);GLO_ValidaGET($_GET['Id2'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

$_SESSION['TxtNroEntidad2'] = str_pad($_GET['Id2'], 6, "0", STR_PAD_LEFT);



GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUp','zAltaR',0,0,0,0);



include("Includes/zCamposRESP.php");

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>