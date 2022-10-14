<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("zFunciones.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}
if (empty($_SESSION['TxtHora'])){ $_SESSION['TxtHora']=date("H:i");}

GLOF_Init(GLO_formfocus('TxtFechaA',0),'BannerConMenuHV','zAlta',0,'',0,0,0); 
GLO_tituloypath(0,750,'Consulta.php','PEDIDO LOGISTICA','linksalir');

$esdespacho=1;
include("Includes/zCampos.php");  
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(750,0);
echo 'La <font class="comentario2">Solicitud</font> se genera automaticamente al dar de alta el <font class="comentario3">Pedido</font><br>';
echo 'La <font class="comentario2">Accion</font> indica los pasos a seguir con el <font class="comentario3">Pedido</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>