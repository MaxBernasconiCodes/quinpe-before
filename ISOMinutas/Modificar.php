<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT * From iso_minutas where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
		$_SESSION['TxtFecha'] = FormatoFecha($row['Fecha']);if ($_SESSION['TxtFecha']=='00-00-0000'){$_SESSION['TxtFecha'] ="";}
		$hora1=date("H:i",strtotime($row['Hora'])); if ($hora1=='00:00'){$hora1="";}$_SESSION['TxtHora1']=$hora1;
		$_SESSION['TxtNombre'] =  $row['Nombre'];	
	}mysql_free_result($rs);
} 

GLO_InitHTML($_SESSION["NivelArbol"],'TxtFecha','BannerConMenuHV','zModificar',0,0,0,0);

include("Includes/zCampos.php");

?> 


<table width="750" border="0"  cellpadding="0" cellspacing="0"  class="fondo">
<!--asistentes-->
<tr ><td height="18" ><i class="fa fa-users iconsmallsp iconlgray"></i> <strong>Asistentes:</strong></td></tr>
<tr> <td  align="center" ><?php MIN_TablaAsistentes($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15" ></td></tr>
<!--actividades des-->
<tr ><td height="18" ><i class="fa fa-tasks iconsmallsp iconlgray"></i> <strong>Actividades Desarrolladas:</strong></td></tr>
<tr> <td  align="center" ><?php MIN_TablaDesarrollo($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15" ></td></tr>
<!--actividades pend-->
<tr ><td height="18" ><i class="fa fa-tasks iconsmallsp iconlgray"></i> <strong>Actividades Pendientes:</strong></td></tr>
<tr> <td  align="center" ><?php MIN_TablaPendientes($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15" ></td></tr>
<!--Archivos-->
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_VerTablaArchivos($_SESSION['TxtNumero'],$conn,"iso_minutasarchivos","750","",'1'); ?>	</td></tr>
</table>

<? 
GLO_cierratablaform(); 
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>