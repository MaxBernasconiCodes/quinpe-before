<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Barrera/Consulta.php"><i class="fa fa-truck iconsmall"></i> BARRERA </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Barrera/ConsultaC.php"><i class="fa fa-walking iconsmall"></i> CONTROL </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Barrera/InboxP.php"><i class="fa fa-file-alt iconsmall"></i> PEDIDOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Barrera/Items.php"><i class="fa fa-dolly-flatbed iconsmall"></i> PRODUCTOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
//fin opciones	
echo '</td></tr></table> ';
?>