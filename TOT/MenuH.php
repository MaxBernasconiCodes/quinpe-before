<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}




echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';

//opciones

echo '<a href="'.$_SESSION["NivelArbol"].'TOT.php"><i class="fa fa-address-card iconsmall"></i> TOT </a>';

echo '&nbsp; &nbsp; &nbsp; &nbsp;';

echo '<a href="'.$_SESSION["NivelArbol"].'TOTCategoria.php"><i class="fa fa-shield-alt iconsmall"></i> CATEGORIA </a>';

echo '&nbsp; &nbsp; &nbsp; &nbsp;';

echo '<a href="'.$_SESSION["NivelArbol"].'TOTTipo.php"><i class="fa fa-list iconsmall"></i> TIPO </a>';

//fin opciones	

echo '</td></tr></table> ';

?>