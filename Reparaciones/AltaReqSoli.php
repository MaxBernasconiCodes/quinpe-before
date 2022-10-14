<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['Id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



if (empty($_SESSION['TxtFecha'])) { $_SESSION['TxtFecha']=date("d-m-Y");}

$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);



//busco orden

$query="SELECT p.IdOrden From pedidosrep p where p.Id=".intval($_GET['Id']); $rs=mysql_query($query,$conn);

$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){	$_SESSION['TxtIdOrden'] = $row['IdOrden'];}mysql_free_result($rs);





GLOF_Init('TxtObs','BannerPopUp','zAltaReqSoli',0,'',0,0,0); 



include ("zCamposReqSoli.php");

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>