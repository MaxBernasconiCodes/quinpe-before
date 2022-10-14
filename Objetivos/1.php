<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");  include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";include("zFunciones.php");
 
 $conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	
GLOF_Init('','BannerConMenuHV','',0,'',0,0,0); 
GLO_tituloypath(0,700,'Objetivos.php','','linksalir'); 

echo '<table width="700" border="0" cellspacing="0" valign="top"><tr><td>';
OBJ_TablaMostrar(1,$conn);//vision
echo '</td></tr><tr><td height="20"></td></tr><tr><td>';
OBJ_TablaMostrar(2,$conn);//mision
echo '</td></tr></table>';

GLO_cierratablaform(); 
mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");
?>