<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['ChkReq'])){ $_SESSION['ChkReq']=1;}


GLOF_Init('TxtNombre','BannerConMenuHV','zAlta',1,'MenuH',0,0,0);
GLO_tituloypath(0,720,'../Articulos.php','ARTICULOS','linksalir');

include ("zCampos.php");
GLO_botonesform("720",0,2);
GLO_mensajeerror();
mysql_close($conn);
GLO_cierratablaform(); 

GLO_initcomment(720,2);
echo 'La <font class="comentario3">Unidad de medida</font> se utiliza para registrar el <font class="comentario2">Stock</font><br>';
echo 'Los <font class="comentario2">Bienes</font> podran registrar <font class="comentario3">Asignaciones</font> y <font class="comentario3">Certificaciones</font><br>';
echo 'Para agregar <font class="comentario2">Marca</font> haga click en <i class="fa fa-plus iconvsmallsp iconlgray"></i> y luego en <i class="fa fa-redo iconvsmallsp iconlgray"></i>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>