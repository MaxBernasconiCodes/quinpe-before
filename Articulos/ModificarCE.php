<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//get
GLO_ValidaGET($_GET['id'],0,0);

if ($_GET['Flag1']=="True"){
$query="SELECT * From instrumentosprog where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaProg']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
	$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaReal']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
	$_SESSION['CbInstrumento'] = $row['IdInstrumento'];
	$_SESSION['CbTipoCertif'] = $row['IdTipoCertif'];
	$_SESSION['TxtCertif'] = $row['Certificado'];
	$_SESSION['TxtObs'] = $row['Obs'];
	$_SESSION['TxtArchivo'] = $row['Ruta'];	
	$_SESSION['TxtNroEntidad']=str_pad($row['IdInstrumento'], 6, "0", STR_PAD_LEFT);
	$_SESSION['ChkInactivo']=  $row['Inactivo'];
}mysql_free_result($rs);
} 

GLOF_Init('','BannerPopUp','zModificarCE',0,'',0,0,0); 

//campos
$readonly=0;
include ("Includes/zCamposCE.php");


GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>
