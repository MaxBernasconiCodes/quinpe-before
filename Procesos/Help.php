<? include("../Codigo/Seguridad.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
//perfiles 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUpMH','',0,0,0,0); 
GLO_tituloypath(0,900,'Procesos.php','CIRCUITO OPERACIONES','linksalir');


?>

<table width="900" border="0"  cellpadding="0" cellspacing="0" class="TablaFormulario2" >
<tr> <td height="5" ></td></tr>
<tr><td align="center"><img src="Circuito.jpg" title="Circuito" align="absmiddle"></img></td></tr>
</table>

<? 

GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>