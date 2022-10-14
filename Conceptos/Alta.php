<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',0,'../Servicios/MenuH',0,0,0); 

include ("zCampos.php");
mysql_close($conn);
GLO_cierratablaform(); 

GLO_initcomment(600,2);
echo 'La <font class="comentario3">Unidad de medida</font> se utiliza para registrar el <font class="comentario2">Stock</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>