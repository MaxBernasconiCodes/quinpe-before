<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





GLOF_Init('','BannerConMenuHV','',0,'MenuH',0,0,0); 

GLO_tituloypath(0,500,'','TABLAS',''); 

?>





<table  width="500" border="0" cellspacing="0" cellpadding="0" class="TablaPanel">

<tr><td width="250" height="5"></td><td width="250"></td></tr>	



<tr><td><? GLOF_buttonpanel('boton9','CONDICIONES VENTA','../ClientesCV.php',0,0,0);?></td>

<td><? GLOF_buttonpanel('boton9','GRUPOS','../ClientesGrupo.php',0,0,0);?></td></tr>



<tr><td><? GLOF_buttonpanel('boton9','CUENTAS CONTABLES','../ClientesCuentas.php',0,0,0);?></td>

<td><? GLOF_buttonpanel('boton9','LISTAS DE PRECIOS','../ClientesListas.php',0,0,0);?></td></tr>





</table>



<? 

GLO_cierratablaform(); 

include ("../Codigo/FooterConUsuario.php");

?>