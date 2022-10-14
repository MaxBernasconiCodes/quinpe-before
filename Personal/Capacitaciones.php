<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$_SESSION['TxtNroEntidad']=$_GET['Id'];
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdia="01-01-".$a;$ultimodia="31-12-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdia -0 month"));
	$_SESSION['TxtFechaH']=date("d-m-Y", strtotime("$ultimodia -0 month"));
}

GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','zCapacitaciones',0,0,0,0); 
GLO_tituloypath(0,420,"Modificar.php?id=".intval($_SESSION['TxtNroEntidad'])."&Flag1=True",'CAPACITACIONES','linksalir'); 
?> 


<table width="420" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="120"></td><td width="100"></td><td width="140"></td><td width="50"></td></tr>
<tr> <td height="18"  align="right">Programadas:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1); ?></td><td> al&nbsp;<?  GLO_calendario("TxtFechaH","../Codigo/","actual",1); ?></td><td align="right" ><? GLO_Hidden('TxtNroEntidad',0);GLO_Search('CmdBuscar',0);?></td></tr>
</table>

 

<? 
MostrarTablaCap(intval($_SESSION['TxtNroEntidad']),$conn);
GLO_mensajeerror(); 
GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php"); 
?>