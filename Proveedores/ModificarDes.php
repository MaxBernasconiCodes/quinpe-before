<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include ("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['gid'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (intval($_GET['gidf'])==1){
	$query="SELECT p.*,pr.Apellido From proveedores_des p,proveedores pr where p.IdEntidad=pr.Id and p.Id<>0 and p.Id=".intval($_GET['gid']);
	$rs=mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtApellido'] = substr($row['Apellido'],0,30);
		$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['Fecha']);
		$_SESSION['CbPersonal1'] = $row['IdP1'];
		$_SESSION['CbPersonal2'] = $row['IdP2'];
		//eval
		$_SESSION['CbEP1'] = $row['E1'];
		$_SESSION['CbEP2'] = $row['E2'];
		$_SESSION['CbEP3'] = $row['E3'];
		$_SESSION['CbEP4'] = $row['E4'];
		$_SESSION['CbEP5'] = $row['E5'];
		$_SESSION['CbEP6'] = $row['E6'];
		$_SESSION['CbEP7'] = $row['E7'];
		$_SESSION['CbEP8'] = $row['E8'];
		$_SESSION['CbEP9'] = $row['E9'];
		$_SESSION['CbEP10'] = $row['E10'];
		$_SESSION['CbEP11'] = $row['E11'];
		$_SESSION['CbEP12'] = $row['E12'];
		//obs
		$_SESSION['TxtI1'] = $row['I1'];
		$_SESSION['TxtI2'] = $row['I2'];
		$_SESSION['TxtI3'] = $row['I3'];
		$_SESSION['TxtI4'] = $row['I4'];
		$_SESSION['TxtI5'] = $row['I5'];
		$_SESSION['TxtI6'] = $row['I6'];
		$_SESSION['TxtI7'] = $row['I7'];
		$_SESSION['TxtI8'] = $row['I8'];
		$_SESSION['TxtI9'] = $row['I9'];
		$_SESSION['TxtI10'] = $row['I10'];
		$_SESSION['TxtI11'] = $row['I11'];
		$_SESSION['TxtI12'] = $row['I12'];
		//label
		include ("Includes/zTotales.php");
		$_SESSION['TxtTotal'] =$t1;	$_SESSION['TxtTotal2'] =$t2;$_SESSION['TxtTotal3'] =$t3;
		$_SESSION['TxtTexto']=PROV_EPlabel($_SESSION['TxtTotal3']);
	}mysql_free_result($rs);
}

GLOF_Init('TxtFechaA','BannerPopUp','zModificarDes',0,'',0,0,0); 
include ("Includes/zCamposEP.php");
GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>