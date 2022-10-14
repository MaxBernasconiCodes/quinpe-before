<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==7  or $_SESSION["IdPerfilUser"]==11  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){
	//menu
	echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
	//opciones
	echo '<a href="'.$_SESSION["NivelArbol"].'Reparaciones/Solicitudes.php"><i class="fa fa-file-alt iconsmall"></i> SOLICITUDES </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="'.$_SESSION["NivelArbol"].'Reparaciones/Ordenes.php"><i class="fa fa-clipboard-check iconsmall"></i> ORDENES </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="'.$_SESSION["NivelArbol"].'Reparaciones/OrdenesT.php"><i class="fa fa-inbox iconsmall"></i> TAREAS PENDIENTES </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="'.$_SESSION["NivelArbol"].'Reparaciones/OrdenesTA.php"><i class="fa fa-tasks iconsmall"></i> TAREAS ASIGNADAS</a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="'.$_SESSION["NivelArbol"].'Reparaciones/Reportes.php"><i class="fa fa-chart-line iconsmall"></i> REPORTES </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="'.$_SESSION["NivelArbol"].'Reparaciones/Tablas.php"><i class="fa fa-table iconsmall"></i> TABLAS </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="'.$_SESSION["NivelArbol"].'Reparaciones/Help.php"><i class="fa fa-question-circle iconsmall"></i> AYUDA </a>';
	echo '&nbsp; &nbsp; &nbsp; &nbsp;';
	echo '<a href="'.$_SESSION["NivelArbol"].'ManualRep/ManualSistema.php"><i class="fa fa-book iconsmall"></i> MANUAL </a>';
	//fin menu	
	echo '</td></tr></table> ';
}
?>