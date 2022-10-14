<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'CAM/Inbox.php"><i class="fa fa-inbox iconsmall"></i> PENDIENTES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'CAM.php"><i class="fa fa-file-signature iconsmall"></i> CERTIFICADOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Metodos/Consulta.php"><i class="fa fa-vial iconsmall"></i> METODOS </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'MetodosUnidades.php"><i class="fa fa-eye-dropper iconsmall"></i> UNIDADES </a>';
//fin opciones	
echo '</td></tr></table> ';
?>