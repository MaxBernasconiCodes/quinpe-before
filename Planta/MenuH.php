<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Planta/Inbox.php"><i class="fa fa-inbox iconsmall"></i> INGRESOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Planta/InboxP.php"><i class="fa fa-file-alt iconsmall"></i> PEDIDOS</a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Planta/Stock.php"><i class="fa fa-dolly-flatbed iconsmall"></i> MOVIMIENTOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Planta/StockD.php"><i class="fa fa-tag iconsmall"></i> DETALLE </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Planta/StockDeposito.php"><i class="fa fa-warehouse iconsmall"></i> STOCK </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
//fin opciones	
echo '</td></tr></table> ';
?>