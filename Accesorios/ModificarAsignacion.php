<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);

//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From accesorios_asig where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['CbInstrumento']=$row['IdInstrumento'];
	$_SESSION['TxtNroEntidad'] = str_pad($row['IdInstrumento'], 5, "0", STR_PAD_LEFT);
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
	//
	$_SESSION['CbUnidad'] =$row['IdUnidad'];
	$_SESSION['CbPersonal'] =$row['IdPersonal'];
	//
	$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaD']);//entrega
	$_SESSION['TxtFechaE'] = GLO_FormatoFecha($row['FechaE']);//devolucion pactada
	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaH']);//devolucion realizada
	//
	$_SESSION['TxtObs'] = $row['Obs'];
	$_SESSION['ChkReq'] = $row['TIndef'];
}mysql_free_result($rs);


GLOF_Init('','BannerPopUp','zModificarAsignacion',0,'',0,0,0); 
include ("Includes/zCamposAsig.php");
?>