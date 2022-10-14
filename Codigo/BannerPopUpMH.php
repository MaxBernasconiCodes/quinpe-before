<? include("Seguridad.php");?>

<!--banner-->
<table  height="100%" width="100%"  cellpadding="0"  cellspacing="0" border="0" align="center" class="fondo">
<tr> <td height="1px" style="width:30%"> </td><td style="width:70%;"></td></tr>
<tr  class="bannerIMG2"> <td class="bannerintra banner"></td><td class="banner"> 
<? 
if($_SESSION["GLO_IdSistema"]!=0){
    echo '<a href="'.$_SESSION["NivelArbol"].'Inicio.php"><i class="fa fa-home iconvsmall"></i> Inicio </a>';
    echo '&nbsp; &nbsp; &nbsp; &nbsp;';
    echo '<a href="'.$_SESSION["NivelArbol"].'CambioClave.php"><i class="fa fa-key iconvsmall"></i> Clave </a>';
    echo '&nbsp; &nbsp; &nbsp; &nbsp;';
}
echo '<a href="'.$_SESSION["NivelArbol"].'InicioIntranet.php"><i class="fa fa-sitemap iconvsmall"></i> Intranet </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Codigo/Logout.php"><i class="fa fa-sign-out-alt iconvsmall"></i> Salir </a>&nbsp;';
?>
</td></tr>


<!--cuerpo-->
<tr> <td colspan="2">     
<table  width="100%"  height="100%" cellpadding="0" cellspacing="0" border="0" align="center" >
<tr  height="100%"><td align="center" valign="top" class="fondo" colspan="2"  height="100%">