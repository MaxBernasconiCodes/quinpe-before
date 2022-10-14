<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";
include("zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);//id registro
if(intval($_GET['ido'])==0 or intval($_GET['ido'])>5){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}//id tipo registro

$_SESSION['TxtNroEntidad'] = intval($_GET['ido']);//me dice que objetivo voy a modificar


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//buscar datos
$tablaobj=OBJ_tabla($_SESSION['TxtNroEntidad'] );//busca tabla segun tipo objetivo

$query="SELECT * From $tablaobj where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtNumero']=$row['Id'];
	$_SESSION['TxtAnio']=$row['Anio'];
	$_SESSION['TxtFechaA'] =GLO_FormatoFecha($row['Fecha']);
	$_SESSION['TxtTexto'] = $row['Nombre'];
	$_SESSION['TxtTitulo'] = $row['Titulo'];
}mysql_free_result($rs);
mysql_close($conn);

GLOF_Init('TxtAnio','BannerConMenuHV','zModificar',0,'',0,0,0); 

include ("Includes/zCamposObj.php");

GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>