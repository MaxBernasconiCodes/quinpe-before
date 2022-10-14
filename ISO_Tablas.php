<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php");$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','',0,0,0,0);
GLO_tituloypath(0,400,'Inicio.php','TABLAS','linksalir');
?>

<table  width="500" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">
<tr><td width="250" height="5"></td><td width="250"></td></tr>	

<tr><td><? GLOF_buttonpanel('boton9','ALCANCE MATRIZ LEGAL','ISO_MLegalAlcance.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','PROCESOS','ISO_Procesos.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','DOCUMENTOS','ISO_TipoDoc.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','REQUISITOS','ISO_Requisitos.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','NORMAS','ISO_Norma.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','TIPO NC','ISO_TipoNC.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','ORIGEN NC','ISO_OrigenNC.php',0,0,0);?></td>
<td></td></tr>

</table>


<? 
GLO_cierratablaform(); 
include ("Codigo/FooterConUsuario.php");
?>