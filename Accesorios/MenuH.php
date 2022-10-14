<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Accesorios/Consulta.php"><i class="fa fa-clipboard-check iconsmall"></i> ACCESORIOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Accesorios/Asignaciones.php"><i class="fa fa-truck iconsmall"></i> ASIGNACIONES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Accesorios/Certificaciones.php"><i class="fa fa-award iconsmall"></i> CERTIFICACIONES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'UniAccesorios.php"A><i class="fa fa-plug iconsmall"></i> ELEMENTOS </a>';
//fin opciones	
echo '</td></tr></table> ';


?>