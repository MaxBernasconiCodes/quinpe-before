<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
	include("Includes/zMostrarU.php");	
} 

GLO_InitHTML($_SESSION["NivelArbol"],'TxtNumero','BannerPopUpMH','zModificar',0,0,0,0); 
GLO_tituloypath(950,850,'../ISO_NC.php','NO CONFORMIDAD','linksalir');

include ("zCampos.php");

if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3 or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14){GLO_botonesform("850",0,2);}


//exportar e historia
echo '<table width="850" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr><tr><td align="right">'; 
echo ' '.GLO_FAButton('CmdAuditoria','submit','80','blank','Historial','clock','boton02');
echo ' '.GLO_FAButton('CmdExcel','submit','80','self','Exportar','excel','boton02');
echo '</td> </tr></table>'; 

GLO_mensajeerror();
?>


<!--adjuntos-->
<table width="600" border="0"  cellpadding="0" cellspacing="0" >
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>    
<tr> <td  align="center" ><?php NC_TablaArchivos($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
</table> 

<? 
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>