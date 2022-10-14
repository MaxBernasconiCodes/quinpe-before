<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";



//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





GLOF_Init('','BannerConMenuHV','',0,'MenuH',0,0,0);

GLO_tituloypath(0,400,'Solicitudes.php','REPORTES','linksalir'); 

?> 



<table  width="500" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">

<tr><td width="250" height="5"></td><td width="250"></td></tr>	



<tr><td><? GLOF_buttonpanel('boton8','ACCIONES','Acciones.php',0,0,0);?></td>

<td><? GLOF_buttonpanel('boton8','REQUERIMIENTOS','Requerimientos.php',0,0,0);?></td></tr>



<tr><td><? GLOF_buttonpanel('boton8','INSUMOS','Insumos.php',0,0,0);?></td>

<td><? GLOF_buttonpanel('boton8','TAREAS','Tareas.php',0,0,0);?></td></tr>



</table>



<? 

GLO_cierratablaform(); 

include ("../Codigo/FooterConUsuario.php");

?>