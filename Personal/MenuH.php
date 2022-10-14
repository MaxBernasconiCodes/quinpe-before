<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '&nbsp; <a href="'.$_SESSION["NivelArbol"].'Personal.php"><i class="fa fa-users iconsmall"></i> PERSONAL </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Vencimientos.php"><i class="fa fa-traffic-light iconsmall"></i> HABILITACIONES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'PersonalCumpl.php"><i class="fa fa-birthday-cake iconsmall"></i> CUMPLEA&Ntilde;OS </a>';
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){
    echo '&nbsp; &nbsp; &nbsp; &nbsp;';
    echo '<a href="'.$_SESSION["NivelArbol"].'Personal/Tablas.php"><i class="fa fa-table iconsmall"></i> TABLAS </a>';
}
//fin opciones	
echo '</td></tr></table> ';


?>