<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(10);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



GLOF_Init('TxtNombre','BannerPopUp','zAlta',0,'../Personal/MenuH',0,0,0); 



include("zCampos.php");



mysql_close($conn); 

GLO_cierratablaform();



GLO_initcomment(500,0);

echo 'Las <font class="comentario2">Horas</font> representan el Turno en Horas, dato utilizado en el modulo de <font class="comentario3">Incidentes</font>';

GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");

?>