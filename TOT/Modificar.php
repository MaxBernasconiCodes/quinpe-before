<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); 

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);

 

 

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

 

if ($_GET['Flag1']=="True"){	

	$query="SELECT a.* From tot a where a.Id<>0 and a.Id=".intval($_GET['id']);	$rs=mysql_query($query,$conn);

	while($row=mysql_fetch_array($rs)){

		$_SESSION['TxtNumero']=$row['Id'];

		$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);

		$_SESSION['CbSector']=$row['IdSector'];

		$_SESSION['CbPersonal']=$row['IdPersonal'];

		$_SESSION['CbPersonal2']=$row['IdPersonal2'];

		$_SESSION['CbCentro']=$row['IdCentro'];

		$_SESSION['CbCliente']=$row['IdCliente'];

		//

		$_SESSION['Opt1']=$row['O1'];//si:1,no:0

		$_SESSION['Opt2']=$row['O2'];//si:1,no:0

		$_SESSION['Opt3']=$row['Estado'];//estado abierto:0,cerrado:1

		//

		$_SESSION['CbCateg']=$row['IdCat'];

		$_SESSION['TxtObs3']=$row['AccionR'];

		$_SESSION['TxtObs4']=$row['Cons'];

		$_SESSION['TxtObs5']=$row['AccionCP'];

			

	}mysql_free_result($rs);	

}





//html

GLOF_Init('TxtFechaA','BannerConMenuHV','zModificar',0,'',0,0,0); 

include ("zCampos.php");

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>