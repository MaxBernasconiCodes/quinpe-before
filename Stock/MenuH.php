<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}




echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Stock.php"><i class="fa fa-dolly-flatbed iconsmall"></i> MOVIMIENTOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'StockD.php"><i class="fa fa-tag iconsmall"></i> DETALLE </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Stock/StockDeposito.php"><i class="fa fa-archive iconsmall"></i> STOCK </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Stock/Comprar.php"><i class="fa fa-shopping-cart iconsmall"></i> COMPRAR </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
//fin opciones	
echo '</td></tr></table> ';


?>