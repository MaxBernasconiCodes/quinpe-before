<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}




//muestra solo  aperfiles permitidos
//11 ADMINISTRACION
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11){
	//menu
	echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
	//opciones
	echo '&nbsp;<a href="NotasPedidoD.php"><i class="fa fa-file-alt iconsmall"></i> PEDIDOS </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="Cotizaciones.php"><i class="fa fa-file-alt iconsmall"></i> COTIZACIONES </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="AltaItemOC.php"><i class="fa fa-file-alt iconsmall"></i> COMPRAR </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="VerOC.php"><i class="fa fa-file-alt iconsmall"></i> ORDENES </a>';
	if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2){
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="Autorizantes.php"><i class="fa fa-user-tie iconsmall"></i> AUTORIZANTES </a>';
	}
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="Help.php"><i class="fa fa-question-circle iconsmall"></i> AYUDA </a>&nbsp;';
	//fin menu	
	echo '</td></tr></table> ';
}
?>