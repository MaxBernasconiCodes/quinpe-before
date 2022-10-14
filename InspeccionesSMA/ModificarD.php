<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





//mostrar campos

if ($_GET['Flag1']=="True"){

$query="SELECT * From inspecciones_det where Id<>0 and Id=".intval($_GET['id']); 

$rs=mysql_query($query,$conn);

while($row=mysql_fetch_array($rs)){

	$_SESSION['TxtNumero'] =$row['Id'];

	$_SESSION['TxtNroEntidad']=$row['IdInsp'];

	$_SESSION['TxtFechaA'] = FormatoFecha($row['Fecha']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}

	$_SESSION['TxtObs'] = $row['Obs'];

	$_SESSION['CbPersonal'] =$row['IdPersonal'];

	$_SESSION['CbEstado'] =$row['IdEstado'];	

	$_SESSION['TxtFechaB'] = FormatoFecha($row['Fecha2']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}	

}mysql_free_result($rs);

} 





GLOF_Init('TxtFechaA','BannerPopUp','zModificarD',0,'',0,0,0); 



include ("Includes/zCamposD.php");

GLO_cierratablaform();

mysql_close($conn);

include ("../Codigo/FooterConUsuario.php"); 

?>