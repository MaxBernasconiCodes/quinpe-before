<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Unidades.php"><i class="fa fa-truck iconsmall"></i> UNIDADES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'VencimientosU.php"><i class="fa fa-traffic-light iconsmall"></i> HABILITACIONES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Unidades/Cubiertas.php"><i class="fa fa-ring iconsmall"></i> CUBIERTAS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Unidades/Tablas.php"><i class="fa fa-table iconsmall"></i> TABLAS </a>';
//fin opciones	
echo '</td></tr></table> ';


?>