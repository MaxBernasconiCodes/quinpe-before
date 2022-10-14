<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

?> 



<? GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerConMenuHV','zAlta',0,0,0,0); ?>



<? 

include("Includes/zCampos.php");

GLO_botonesform("700",0,2);

GLO_mensajeerror(); 

GLO_cierratablaform(); 

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>