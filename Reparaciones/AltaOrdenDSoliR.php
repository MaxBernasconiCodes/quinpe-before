<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php") ;$_SESSION["NivelArbol"]="../";

require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



$_SESSION['TxtFecha1']=date("d-m-Y");

$_SESSION['CbSoli'] = str_pad(intval($_GET['id']), 6, "0", STR_PAD_LEFT);

$query="SELECT r.* From pedidosrep r where r.Id<>0 and r.Id=".intval($_GET['id']); 

$rs=mysql_query($query,$conn);

while($row=mysql_fetch_array($rs)){

	$_SESSION['CbUnidad'] = $row['IdUnidad'];

	$_SESSION['CbSector'] = $row['IdSector'];

	$_SESSION['CbInstrumento'] = $row['IdInstr'];

	$_SESSION['TxtIdOrden'] = $row['IdOrden'];

}mysql_free_result($rs);





GLOF_Init('TxtObs','BannerPopUp','zAltaOrdenDSoliR',1,'',0,0,0); 

GLO_tituloypath(0,700,'','SOLICITUD RECHAZADA','salir');



GLO_Hidden('CbSoli',0);GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdOrden',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtFecha1',0);

GLO_Hidden('CbUnidad',0);GLO_Hidden('CbSector',0);GLO_Hidden('CbInstrumento',0);



GLO_obsform(700,80,'Comentarios','TxtObs',4,0);

GLO_botonesform(700,0,2);

GLO_mensajeerror(); 

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>