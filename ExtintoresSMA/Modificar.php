<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



//mostrar campos

if ($_GET['Flag1']=="True"){

$query="SELECT * From extintores where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);

while($row=mysql_fetch_array($rs)){

	$_SESSION['TxtNumero'] = $row['Id'];

	$_SESSION['TxtNro'] = $row['Nro'];

	$_SESSION['CbUnidad'] = $row['IdUnidad'];

	$_SESSION['TxtUbic'] = $row['Ubicacion'];

	$_SESSION['CbProd'] = $row['IdProd'];

	$_SESSION['TxtCap'] = $row['Capacidad'];

	$_SESSION['OptA1'] = $row['Chapa'];

	$_SESSION['OptA2'] = $row['Manguera'];

	$_SESSION['OptA3'] = $row['Collarin'];

	$_SESSION['OptA4'] = $row['Precinto'];

	$_SESSION['OptA5'] = $row['Exterior'];	

	$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['Vto']);

	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['VtoPH']);

	$_SESSION['TxtObs'] = $row['Obs'];

	$_SESSION['ChkBaja']= $row['Baja'];

}mysql_free_result($rs);

} 







GLO_InitHTML($_SESSION["NivelArbol"],'TxtNro','BannerConMenuHV','zModificar',0,0,0,0); 



include("Includes/zCampos.php");



mysql_close($conn);

GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>