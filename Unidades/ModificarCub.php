<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(12);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	//busco datos
	$query="SELECT p.* From unidades_cubiertas p where p.Id<>0  and p.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdUnidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFecha'] = GLO_FormatoFecha($row['Fecha']);
		$_SESSION['CbPersonal'] = $row['IdPersonal'];
		$_SESSION['TxtKm1'] = $row['Odo'];
		$_SESSION['TxtCant'] = $row['Cant'];
		$_SESSION['CbMarca'] = $row['IdMarca'];
	    $_SESSION['TxtMed'] = $row['Med'];	
		$_SESSION['ChkI1'] = $row['Ali'];	
		$_SESSION['ChkI2'] = $row['Bal'];
		$_SESSION['TxtUbic'] = $row['UbiR'];
		$_SESSION['TxtKm2'] = $row['KmR'];
		$_SESSION['TxtObs'] = $row['Obs'];
	}mysql_free_result($rs);
}


GLOF_Init('TxtFecha','BannerPopUp','zModificarCub',0,'',0,0,0); 
include ("Includes/zCamposCub.php");

GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>