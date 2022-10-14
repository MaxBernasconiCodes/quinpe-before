<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}




echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';

//opciones

echo '<a href="'.$_SESSION["NivelArbol"].'Procesos/Help.php"><i class="fa fa-question-circle iconsmall"></i> AYUDA </a>&nbsp;';



echo '</td></tr></table> ';

?>