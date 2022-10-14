<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}
if (empty($_SESSION['CbSoli'])){$_SESSION['CbSoli']=$_SESSION["GLO_IdPersLog"];;}


GLOF_Init('TxtNombre','BannerConMenuHV','zAltaNotaPedido',0,'MenuH',0,0,0);
GLO_tituloypath(0,770,'NotasPedidoD.php','NOTA DE PEDIDO','linksalir'); 

include("Includes/zCamposNP.php");

GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(770,0);
echo 'Los <font class="comentario2">PreAutorizantes</font> y <font class="comentario2">Autorizantes</font> deben ser ingresados en la Intranet por el <font class="comentario3">Administrador del Sistema</font>.<br>';
echo 'Al seleccionar el <font class="comentario3">Sector</font> se cargar&aacute; por defecto el <font class="comentario2">PreAutorizante</font> correspondiente. <br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>