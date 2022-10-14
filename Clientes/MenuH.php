<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}












echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';

//opciones

echo '&nbsp;<a href="'.$_SESSION["NivelArbol"].'Clientes.php"><i class="fa fa-user-tie iconsmall"></i> CLIENTES </a>';

echo '&nbsp; &nbsp; &nbsp; &nbsp;';

echo '<a href="'.$_SESSION["NivelArbol"].'Clientes/Tablas.php"><i class="fa fa-table iconsmall"></i> TABLAS </a>';

//fin opciones	

echo '</td></tr></table> ';





?>