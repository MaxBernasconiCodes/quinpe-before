<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(11);


GLOF_Init('','BannerConMenuHV','',0,'MenuH',0,0,0); 
GLO_tituloypath(0,500,'','TABLAS',''); 
?>


<table  width="500" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">
<tr><td width="250" height="5"></td><td width="250"></td></tr>	

<tr><td><? GLOF_buttonpanel('boton9','ART','../ART.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','HABILITACIONES','../TiposVtosPersonal.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','CARGAS FAMILIARES','../CargasFamiliares.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','LICENCIAS','../TipoLicencia.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','CATEGORIAS','../Categorias.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','NOVEDADES DESEMPE&Ntilde;O','../NovedadesDesemp.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','ESTUDIOS','../Estudios.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','TALLES','../Talles.php',0,0,0);?></td></tr>


<tr><td><? GLOF_buttonpanel('boton9','FUNCION','../Funcion.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','TURNOS','../Turnos.php',0,0,0);?></td></tr>

</table>

<? 
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>