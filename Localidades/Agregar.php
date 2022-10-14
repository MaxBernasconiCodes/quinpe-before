<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=4   and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  and $_SESSION["IdPerfilUser"]!=12   and $_SESSION["IdPerfilUser"]!=13 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



GLOF_Init('TxtNombre','BannerPopUp','zAgregar',0,'',0,0,0); 

GLO_tituloypath(0,600,'','LOCALIDADES','close');



include("zCampos.php");



GLOF_botonesform("600",0,1,2,0);

GLO_mensajeerror();

mysql_close($conn); 

GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>