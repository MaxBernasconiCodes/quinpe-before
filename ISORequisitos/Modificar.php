<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT * From iso_nc_req where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] = $row['Nombre'];
		$_SESSION['TxtNro'] = $row['Nro'];
		$_SESSION['CbNorma'] = $row['IdNorma'];
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
	}mysql_free_result($rs);
}


GLOF_Init('TxtNro','BannerConMenuHV','zModificar',0,'',0,0,0); 
include ("zCampos.php");
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>