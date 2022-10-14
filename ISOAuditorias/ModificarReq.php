<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT c.* From iso_audi_progreq c Where  c.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtNroEntidad']=str_pad($row['IdAudiP'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbReq'] =$row['IdReq'];
		$_SESSION['OptTipo'] =$row['Tipo'];
		$_SESSION['TxtObs'] =  $row['Obs'];	
		$_SESSION['CbNC'] =  $row['IdNC'];	
	}mysql_free_result($rs);
}


GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','zModificarReq',0,0,0,0);

include ("Includes/zCamposR.php");

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>