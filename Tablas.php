<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_InitHTML($_SESSION["NivelArbol"],'','BannerConMenuHV','',0,0,0,0);
GLO_tituloypath(0,400,'Inicio.php','TABLAS','linksalir');
?>

<table  width="500" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">
<tr><td width="250" height="5"></td><td width="250"></td></tr>
<tr><td class="TBold" >GENERAL</td><td class="TBold">STOCK</td></tr>	
<tr><td  height="5"></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','ACTIVIDADES','Actividades.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','DEPOSITOS','Depositos.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','LOCALIDADES','Localidades.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','ENVASES','Envases.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','LUGARES','Yacimientos.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','MARCAS','Marcas.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','PROVINCIAS','Provincias.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','RUBROS','Rubros.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','SECTOR','Sector.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','UNIDADES MEDIDA','UnidadesMed.php',0,0,0);?></td></tr>

</table>

<? 
GLO_cierratablaform(); 
include ("Codigo/FooterConUsuario.php");
?>