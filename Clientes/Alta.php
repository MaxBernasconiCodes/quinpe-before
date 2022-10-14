<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',1,'MenuH',0,0,0); 



include ("Includes/zCampos.php"); 

GLO_cierratablaform(); 

mysql_close($conn);



GLO_initcomment(770,0);

echo 'Para agregar <font class="comentario2">Localidad</font> o  <font class="comentario2">Actividad</font>, haga click en <i class="fa fa-plus iconvsmallsp iconlgray"></i> y luego en <i class="fa fa-redo iconvsmallsp iconlgray"></i>';

GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");

?>