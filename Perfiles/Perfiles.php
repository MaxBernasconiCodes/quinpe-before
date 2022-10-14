<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../"; include("../Codigo/Funciones.php"); 
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if($_SESSION['TxtIdManual']==0){$_SESSION['TxtIdManualT']='Administracion';}
GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','zPerfiles',0,0,0,0);
GLO_tituloypath(0,'100%','../Usuarios.php',$_SESSION['TxtIdManualT'],'linksalir');
?>

<table  width="100%"  height="100%" cellpadding="0" cellspacing="0" border="0" align="center" ><tr>
<?php include ("Menu.php");?><td align="center" valign="top" colspan="2">


<table width="100%" border="0"  cellpadding="0" cellspacing="0"  >
<tr> <td height="5"></td></tr>
<tr><td>

<? 

$perfil=intval($_SESSION['TxtIdManual']);
include("zPermisos.php");
?>
</td></tr></table>
<?
GLO_Hidden('TxtIdManual',0);GLO_Hidden('TxtIdManualT',0);
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>