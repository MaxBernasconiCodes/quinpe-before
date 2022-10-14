<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

//busco datos
$query="SELECT p.IdUnidad,p.FechaI,p.Km,p.Hs,u.Dominio,p.IdEstado as IdEstadoO From pedidosrepord p,unidades u where p.IdUnidad=u.Id and p.Id=".intval($_GET['Id']); 
$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtPRUnidad'] =$row['Dominio'];
	$_SESSION['TxtPRIdUnidad'] = str_pad($row['IdUnidad'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtIdEstadoO'] = $row['IdEstadoO'];
	$_SESSION['TxtPRFechaI'] =GLO_FormatoFecha($row['FechaI']);
	$_SESSION['TxtPRKm'] = $row['Km'];if ($_SESSION['TxtPRKm']==0){$_SESSION['TxtPRKm'] ="";}
	$_SESSION['TxtPRHs'] = $row['Hs'];if ($_SESSION['TxtPRHs']==0){$_SESSION['TxtPRHs'] ="";}
}mysql_free_result($rs);


GLOF_Init('','BannerPopUp','zAltaReq',0,'',0,0,0); 
GLO_tituloypath(0,750,'','ACCION A IMPLEMENTAR','salir');

include ("zCamposReq.php");                
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>