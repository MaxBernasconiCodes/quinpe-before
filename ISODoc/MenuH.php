<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");



echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '&nbsp;<a href="'.$_SESSION["NivelArbol"].'ISO_Doc.php"><i class="fa fa-file-alt iconsmall"></i> DOCUMENTOS </a>';
echo '&nbsp; &nbsp; &nbsp;';

//control
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4   or $_SESSION["IdPerfilUser"]==5 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14 or $_SESSION["IdPerfilUser"]==10){
echo '&nbsp;<a href="'.$_SESSION["NivelArbol"].'ISODoc/Control.php"><i class="fa fa-clipboard-check iconsmall"></i> CONTROL </a>';
echo '&nbsp; &nbsp; &nbsp;';
}
//resp
if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){	
echo '&nbsp;<a href="'.$_SESSION["NivelArbol"].'ISO_Resp.php"><i class="fa fa-user-tie iconsmall"></i> RESPONSABLES </a>';
echo '&nbsp; &nbsp; &nbsp;';
}

echo '&nbsp;<a href="'.$_SESSION["NivelArbol"].'ISODoc/Help.php"><i class="fa fa-question-circle  iconsmall"></i> AYUDA </a>';
//fin opciones	
echo '</td></tr></table> ';


?>