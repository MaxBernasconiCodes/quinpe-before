<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
	$query="SELECT * From despacho where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){	include("Includes/zMostrar.php");}mysql_free_result($rs);
}

DES_Estado($_SESSION['CbEstado'],$colorrow,$colorfield,$estado);$_SESSION['TxtEstado']=$estado;

GLOF_Init('','BannerConMenuHV','zModificar',0,'',1,0,0); 
GLO_tituloypath(0,750,'','PEDIDO LOGISTICA','salir');

$esdespacho=1;

//valido si tiene items
$query="SELECT Id FROM despacho_it Where IdPadre=".intval($_SESSION['TxtNumero'])." LIMIT 1";
$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
if(mysql_num_rows($rs10)!=0){$tieneitems=1;}else{$tieneitems=0;}mysql_free_result($rs10);

include("Includes/zCampos.php"); 

GLO_Ancla('A1');include("Includes/zCamposTablas.php"); 

if(intval($_SESSION['CbServicio'])!=0){GLO_Ancla('A3');DES_TablaItemsServicio($_SESSION['TxtNumero'],0,$conn,0);}
GLO_Ancla('A2');DES_TablaItems($_SESSION['TxtNumero'],0,$conn,0);

mysql_close($conn);
GLO_cierratablaform();

GLO_initcomment(0,0);
echo 'La <font class="comentario2">Accion</font> indica los pasos a seguir con el <font class="comentario3">Pedido</font><br>';
echo 'Solo es posible modificar los <font class="comentario3">Items</font> si el pedido esta <font class="comentario2">PENDIENTE</font><br>';
echo 'Muestra el <font class="comentario2">Total</font> de productos si la <font class="comentario3">Unidad de Medida</font> coincide<br>';
echo 'Al grabar el chofer de <font class="comentario2">Terceros</font> el <font class="comentario3">DNI</font> autocompletara el Nombre<br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>