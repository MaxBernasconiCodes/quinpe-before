<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',0,'../CAM/MenuH',0,0,0); 

include ("zCampos.php");

GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>