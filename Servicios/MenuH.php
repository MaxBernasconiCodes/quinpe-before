<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}






echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';

//opciones

echo '<a href="'.$_SESSION["NivelArbol"].'Servicios.php"><i class="fa fa-clipboard-check iconsmall"></i> SERVICIOS </a>';

echo '&nbsp; &nbsp; &nbsp; &nbsp;';

echo '<a href="'.$_SESSION["NivelArbol"].'TipoServicioA.php"><i class="fa fa-bookmark iconsmall"></i> LINEA A </a>';

echo '&nbsp; &nbsp; &nbsp; &nbsp;';

echo '<a href="'.$_SESSION["NivelArbol"].'TipoServicioB.php"><i class="far fa-bookmark iconsmall"></i> LINEA B </a>';

echo '&nbsp; &nbsp; &nbsp; &nbsp;';

echo '<a href="'.$_SESSION["NivelArbol"].'Conceptos.php"><i class="fa fa-tag iconsmall"></i> ITEMS </a>';

echo '&nbsp; &nbsp; &nbsp; &nbsp;';

echo '<a href="'.$_SESSION["NivelArbol"].'TipoContrato.php"><i class="fa fa-file iconsmall"></i> CONTRATACION </a>';

//fin opciones	

echo '</td></tr></table> ';

?>