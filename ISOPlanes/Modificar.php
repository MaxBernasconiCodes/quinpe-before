<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



if ($_GET['Flag1']=="True"){

	$query="SELECT * From plan where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);

	while($row=mysql_fetch_array($rs)){

		$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);

		$_SESSION['TxtFecha'] = GLO_FormatoFecha($row['Fecha']);

		$_SESSION['TxtCodigo'] =  $row['Codigo'];	

		$_SESSION['TxtNombre'] =  $row['Nombre'];

		$_SESSION['CbSector'] =  $row['IdSector'];

	}mysql_free_result($rs);

} 



GLO_InitHTML($_SESSION["NivelArbol"],'TxtFecha','BannerConMenuHV','zModificar',0,0,0,0);



include("Includes/zCampos.php");

//GLO_exportarform(700,1,0,0,0,0);

PL_TablaParticipantes($_SESSION['TxtNumero'],$conn);

GLO_cierratablaform(); 

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>