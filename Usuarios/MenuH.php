<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



echo '<table width="100%" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td class="menuhpanel">';
//opciones
echo '<a href="'.$_SESSION["NivelArbol"].'Usuarios.php"><i class="fa fa-users iconsmall"></i> PERSONAL </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'UsuariosPR.php"><i class="fa fa-user iconsmall"></i> PROVEEDORES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'UsuariosC.php"><i class="fa fa-user-tie iconsmall"></i> CLIENTES </a>';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
echo '<a href="'.$_SESSION["NivelArbol"].'Perfiles/Perfiles.php"><i class="fa fa-lock iconsmall"></i> PERFILES </a>';
//fin opciones	
echo '</td></tr></table> ';


?>