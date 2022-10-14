<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT p.*,u.Nombre,u.Apellido From personaltalles p,personal u where p.Id<>0 and p.IdEntidad=u.Id and p.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbTipo'] = $row['IdElem'];
		$_SESSION['TxtTalle'] = $row['Talle'];
		$_SESSION['TxtObs'] = $row['Obs'];
	}mysql_free_result($rs);
}


GLOF_Init('CbTipo','BannerPopUp','zModificarTalle',0,'',0,0,0); 
include("Includes/zCamposTalle.php");

GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>