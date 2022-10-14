<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Procesos/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFecha'])){ $_SESSION['TxtFecha']=date("d-m-Y");}
$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

//cliente Solicitud
$query="SELECT a.IdCliente,a.IdTipo From despacho a where a.Id<>0 and a.Id=".intval($_GET['Id']);	
$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
    $_SESSION['CbCliente']=$row['IdCliente'];
    $_SESSION['CbTipo'] =$row['IdTipo'];
}mysql_free_result($rs);	


GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUpMH','zAltaItem',0,0,0,0);

include("Includes/zCamposItem.php");
GLO_guardar(730,3,0);

GLO_mensajeerror();

GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(730,0);
echo 'Permite seleccionar <font class="comentario2">Items</font> tipo <font class="comentario3">Producto</font><br>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>