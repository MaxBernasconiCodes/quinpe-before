<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}







echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Articulos.php"><i class="fa fa-tag iconsmall"></i> ARTICULOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Articulos/Asignaciones.php"><i class="fa fa-truck iconsmall"></i> ASIGNACIONES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Articulos/Certificaciones.php"><i class="fa fa-award iconsmall"></i> CERTIFICACIONES </a>';
//fin opciones	
echo '</td></tr></table> ';





?>