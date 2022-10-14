<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(12);


GLOF_Init('','BannerConMenuHV','',0,'MenuH',0,0,0); 
GLO_tituloypath(0,680,'','TABLAS',''); 
?>

<table  width="500" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">
<tr><td width="220" height="5"></td><td width="220"></td><td width="220"></td></tr>	

<tr><td><? GLOF_buttonpanel('boton9','ASEGURADORAS','../PSAseguradoras.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','FORMA ADQUISICION','../UniAdquisicion.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','POLIZAS SEGURO','../PSA.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','CATEGORIAS','../UniCategorias.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','HABILITACIONES','../TiposVtosUnidades.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','RODADOS CUBIERTAS','../UniRodados.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','ELEMENTOS','../UniElementos.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','MARCAS','../UniMarcas.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','TIPOS POLIZAS','../PSTipo.php',0,0,0);?></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','ESTADOS','../UniEstados.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','MARCAS CUBIERTAS','../UniMarcasCub.php',0,0,0);?></td>
<td></td></tr>

<tr><td><? GLOF_buttonpanel('boton9','FABRICANTES','../UniFabricantes.php',0,0,0);?></td>
<td><? GLOF_buttonpanel('boton9','MARCAS TACOGRAFOS','../UniMarcasTaco.php',0,0,0);?></td></tr>
<td></td></tr>

</table>

<? 
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>