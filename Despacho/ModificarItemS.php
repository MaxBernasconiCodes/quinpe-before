<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Procesos/Includes/zFunciones.php") ;include("../CAM/Includes/zFunciones.php");include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT m.*,a.IdCliente,a.IdTipo,a.IdServicio,a.IdPadre as IdSoli  From despacho_it m,despacho a where m.IdPadre=a.Id and m.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['CbCliente']=$row['IdCliente'];
		$_SESSION['CbTipo'] =$row['IdTipo'];
		$_SESSION['CbServicio'] =$row['IdServicio'];
		//
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = $row['IdPadre'];
		$_SESSION['CbItem'] =  $row['IdItemServ'];//id itemscliente_serv 	
		$_SESSION['CbUnidad'] = $row['IdU'];	
		$_SESSION['TxtRes'] =$row['Cant'];	
		$_SESSION['CbEnv']=$row['IdEnv'];
		$_SESSION['TxtCant'] =$row['CantI'];
		$_SESSION['TxtVal'] =$row['Lote'];	
		$_SESSION['CbEstado'] =DES_asignar_estado($row['IdSoli'],$row['IdPadre'],$conn);//solo modifica items si el pedido es pdte	
		$_SESSION['TxtBultos'] =$row['Bultos'];
		$_SESSION['TxtObs'] =$row['Destino'];
	}mysql_free_result($rs);
}

DES_Estado($_SESSION['CbEstado'],$colorrow,$colorfield,$estado);$_SESSION['TxtEstado'] =$estado;

GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUpMH','zModificarItemS',0,0,0,0);
include("Includes/zCamposItemS.php");

//solo modifica si esta pendiente
if(intval($_SESSION['CbEstado'])<2){GLO_guardar(730,3,0);}
GLO_mensajeerror();

GLO_cierratablaform();
mysql_close($conn); 
GLO_initcomment(730,0);
echo 'Solo es posible modificar los <font class="comentario3">Items</font> si el pedido esta <font class="comentario2">PENDIENTE</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>