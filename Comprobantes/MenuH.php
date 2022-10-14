<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


//menu
echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Comprobantes/Oportunidades.php"><i class="fa fa-file-alt iconsmall"></i> OPORTUNIDADES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Comprobantes/Cotizaciones.php"><i class="fa fa-file-alt iconsmall"></i> COTIZACIONES </a>';
//fin menu	
echo '</td></tr></table> ';

?>