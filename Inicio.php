<? include("Codigo/Seguridad.php") ;include("Codigo/Funciones.php");$_SESSION["NivelArbol"]="";


GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','',0,0,0,0);
GLO_tituloypath(0,'100%','','','');
GLO_cierratablaform();
include ("Codigo/FooterConUsuario.php");

?>