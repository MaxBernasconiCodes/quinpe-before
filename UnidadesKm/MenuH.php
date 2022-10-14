<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}




echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'UnidadesKm/Consulta.php"><i class="fa fa-truck iconsmall"></i> CONTROL </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'UnidadesKm/Importar.php"><i class="fa fa-upload iconsmall"></i> IMPORTAR </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'UnidadesKm/ConsultaB.php"><i class="fa fa-trash iconsmall"></i> ELIMINAR </a>';
//fin opciones	
echo '</td></tr></table> ';


?>