<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



include ("Includes/zDatosP.php");


GLOF_Init('','BannerConMenuHV','zModificarP',0,'MenuH',0,0,0); 



include ("Includes/zCamposP.php");
GLO_botonesform("700",0,2);
GLO_mensajeerror();
?>

<!--adjuntos-->
<table width="700" border="0"  cellpadding="0" cellspacing="0" class="TMT" >
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center"><?php GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"instrumentosprog_a","700","Adjuntos/"); ?>	</td></tr>
</table> 


<?
GLO_cierratablaform(); 

mysql_close($conn);

include ("../Codigo/FooterConUsuario.php");

?>

