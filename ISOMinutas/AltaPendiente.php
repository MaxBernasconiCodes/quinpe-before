<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['Id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);



GLO_InitHTML($_SESSION["NivelArbol"],'TxtObs','BannerPopUp','zAltaPendiente',0,0,0,0);



include("Includes/zCamposPEN.php");

GLO_cierratablaform();

mysql_close($conn); 



GLO_initcomment(700,0);

echo 'Complete <font class="comentario2">Otro</font> si el responsable no pertenece al <font class="comentario3">Personal</font>';

GLO_endcomment();



include ("../Codigo/FooterConUsuario.php");

?>