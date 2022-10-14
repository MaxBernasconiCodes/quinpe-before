<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT m.* From incidentes_med m where m.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdP'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] =  $row['Obs'];	
		$_SESSION['CbPersonal'] = $row['IdPersonal'];	
		$_SESSION['CbPersonal2'] = $row['IdPersonal2'];	
		$_SESSION['OptE'] =$row['Estado'];	//0 pdte, 1 realizada
		$_SESSION['TxtFecha1']=GLO_FormatoFecha($row['Fecha1']);
		$_SESSION['TxtFecha2']=GLO_FormatoFecha($row['Fecha2']);
	}mysql_free_result($rs);
}

GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUp','zModificarM',0,0,0,0);

include("Includes/zCamposM.php");
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>