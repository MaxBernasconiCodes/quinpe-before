<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','',0,0,0,0); 

GLO_tituloypath(0,400,'../PSSA.php','TABLAS','linksalir'); 



?> 



<table  width="400" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">

<tr><td height="5"></td></tr>	



<tr><td><? GLOF_buttonpanel('boton9','ACTIVIDADES','../PSSAAct.php',0,0,0);?></td>

<td><? GLOF_buttonpanel('boton9','TIPO','../PSSATipo.php',0,0,0);?></td></tr>



<tr><td><? GLOF_buttonpanel('boton9','FRECUENCIA','../PSSAFrec.php',0,0,0);?></td>

<td><? GLOF_buttonpanel('boton9','TIPO ARCHIVO','../PSSATipoA.php',0,0,0);?></td></tr>



<tr><td><? GLOF_buttonpanel('boton9','RESPONSABLE','../PSSAResp.php',0,0,0);?></td>

<td></td></tr>



</table>





<? 

GLO_cierratablaform(); 

include ("../Codigo/FooterConUsuario.php");

?>