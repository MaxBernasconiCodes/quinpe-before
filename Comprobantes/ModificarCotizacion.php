<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
	$query="SELECT * From c_cotizaciones where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbCliente'] =$row['IdCliente'];
		$_SESSION['CbPersonal'] =$row['IdPersonal'];		
		$_SESSION['CbTipo'] = $row['IdTipo'];
		$_SESSION['CbTipoC'] = $row['IdTipoC'];		
		$_SESSION['CbEstado'] =$row['IdEstado'];
		$_SESSION['TxtFechaA'] =GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtFechaP'] =GLO_FormatoFecha($row['FechaPre']);
		$_SESSION['TxtContacto'] =$row['Contacto'];
		$_SESSION['TxtRef'] =$row['Ref'];
		$_SESSION['TxtUbic'] =$row['Loc'];
		$_SESSION['TxtObs'] =$row['Obs'];
		$_SESSION['TxtIdOp'] =GLO_SinCeroSTRPAD($row['IdOp'],6);
	}
	mysql_free_result($rs);
}


GLOF_Init('TxtFechaA','BannerConMenuHV','zModificarCotizacion',0,'MenuH',0,0,0); 


include("Includes/zCamposCOTIZ.php");  

GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"c_coti_archivos","720","Comprobantes/","Archivos adjuntos","paperclip",0,0,1);

mysql_close($conn);
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>