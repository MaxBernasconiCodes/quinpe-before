<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLOF_Init('','BannerConMenuHV','',0,'MenuH',0,0,0); 
GLO_tituloypath(0,500,'Solicitudes.php','TABLAS','linksalir');

?> 
<table  width="500" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">
<tr><td height="5" width="250" ></td><td width="250" ></td></tr>	

<tr>
<td><? GLOF_buttonpanel('boton9','CATEGORIA ACCION','../ReparacionesCat.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','TIPO SOLICITUD','../ReparacionesTipo.php',0,0,0);?></td>
</tr>

<tr>
<td><? GLOF_buttonpanel('boton9','CLASE ACCION','../ReparacionesClase.php',0,0,0);?></td>
<td></td>
</tr>


<tr>
<td><? GLOF_buttonpanel('boton9','TIPO ACCION','../ReparacionesTipoA.php',0,0,0);?></td>
<td></td>
</tr>


</table>

<? 
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>