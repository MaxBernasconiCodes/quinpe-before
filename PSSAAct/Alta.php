<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',0,'',0,0,0); 

include ("Includes/zCampos.php");
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>