<? 
echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones


if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){//3:rrhhsr
	echo '&nbsp;&nbsp;<a href="RRHH2.php"><i class="fa fa-users iconsmall"></i> NOMINA </a>';echo '&nbsp; &nbsp; &nbsp; &nbsp;';
}


//fin opciones	
echo '</td></tr></table> ';


?>