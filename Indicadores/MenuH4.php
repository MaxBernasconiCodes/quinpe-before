<? 
echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones


if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==9){//ope	
	echo '&nbsp;&nbsp;<a href="UNI.php"><i class="fa fa-truck iconsmall"></i> UNIDADES </a>';echo '&nbsp; &nbsp; &nbsp; &nbsp;';
}


//fin opciones	
echo '</td></tr></table> ';


?>