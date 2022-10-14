<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(15);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
$query="SELECT * From iso_matriz where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtFechaA'] = FormatoFecha($row['Fecha']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
	$_SESSION['TxtFechaB'] =FormatoFecha($row['FVto']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
	$_SESSION['TxtFechaC'] =FormatoFecha($row['FEval']);if ($_SESSION['TxtFechaC']=='00-00-0000'){$_SESSION['TxtFechaC'] ="";}
	$_SESSION['CbTipo'] =$row['IdAlcance'];
	$_SESSION['CbPer'] =$row['IdPeriod'];
	$_SESSION['CbEstado'] =$row['Eval'];
	$_SESSION['TxtReq'] =$row['Req'];
	$_SESSION['TxtIdent'] =$row['Ident'];
	$_SESSION['TxtResp']= $row['Resp'];
	$_SESSION['TxtObs'] =$row['Detalle'];
	$_SESSION['TxtVerif'] =$row['Reg'];
	$_SESSION['TxtArchivo']= $row['Ruta']; 
}mysql_free_result($rs);
} 


GLOF_Init('TxtFechaA','BannerConMenuHV','zModificar',0,'',0,0,0); 

include("Includes/zCampos.php");
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>