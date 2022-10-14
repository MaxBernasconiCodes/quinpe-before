<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";include ("Includes/zFunciones.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//get
GLO_ValidaGET($_GET['id'],0,0);

if ($_GET['Flag1']=="True"){
$query="SELECT * From accesorios_prog where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaProg']);
	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaReal']);
	$_SESSION['CbInstrumento'] = $row['IdInstrumento'];
	$_SESSION['CbTipoCertif'] = $row['IdTipoCertif'];
	$_SESSION['TxtCertif'] = $row['Certificado'];
	$_SESSION['TxtObs'] = $row['Obs'];
	$_SESSION['TxtArchivo'] = $row['Ruta'];	
	$_SESSION['TxtNroEntidad']=str_pad($row['IdInstrumento'], 6, "0", STR_PAD_LEFT);
	$_SESSION['ChkInactivo']=  $row['Inactivo'];
}mysql_free_result($rs);
} 

GLOF_Init('CbInstrumento','BannerPopUp','zModificarCE',0,'',0,0,0); 


include ("Includes/zCamposCE.php");

GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>