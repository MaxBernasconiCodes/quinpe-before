<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT * From iso_cambios where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
		$_SESSION['TxtFecha'] = GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtFechaE'] = GLO_FormatoFecha($row['FechaE']);
		$_SESSION['TxtFechaR'] = GLO_FormatoFecha($row['FechaR']);
		$_SESSION['TxtNombre'] =  $row['Nombre'];	
		$_SESSION['TxtRazon'] =  $row['Razon'];
		$_SESSION['TxtReq'] =  $row['Req'];
		$_SESSION['TxtObs'] =  $row['Obs'];//des cambio
		$_SESSION['TxtObs2'] =  $row['Obs2'];//des impactos
		$_SESSION['CbPersonal'] =  $row['IdPersonal'];
		$_SESSION['CbRes'] =  $row['Res'];
		$_SESSION['CbEstado'] =  $row['Estado'];
		$_SESSION['CbPrio'] =  $row['Prio'];
	}mysql_free_result($rs);
} 

GLO_InitHTML($_SESSION["NivelArbol"],'TxtFecha','BannerConMenuHV','zModificar',0,0,0,0);

include("Includes/zCampos.php");

//GLO_exportarform(750,1,0,0,0,0);
GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"iso_cambios_adj","750","SGI/","Archivos adjuntos","paperclip",0,0,1);

GLO_cierratablaform(); 
mysql_close($conn); 
?>

<? include ("../Codigo/FooterConUsuario.php");?>