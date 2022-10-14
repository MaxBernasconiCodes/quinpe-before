<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(11);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT p.*,u.Nombre,u.Apellido From personalvtos p,personal u where p.Id<>0 and p.IdEntidad=u.Id and p.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbTipo'] = $row['IdTipo'];
		$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaE']);
		$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['Fecha']);	
	    $_SESSION['TxtArchivo'] = $row['Certif'];	
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['ChkReq'] = $row['Req'];//Mercancias Peligrosas (D.Sebesta201910)
		$_SESSION['ChkInactivo']=  $row['Inactivo'];//Cargas Generales  (D.Sebesta201910)
	}mysql_free_result($rs);
}


GLOF_Init('CbTipo','BannerPopUp','zModificarVto',1,'',0,0,0); 
include ("Includes/zCamposVtos.php");
?>

<!--adjuntos-->
<table width="700" border="0"  cellpadding="0" cellspacing="0" class="fondo" >
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center"><?php GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"personalvtos_a","700","Adjuntos/"); ?>	</td></tr>
</table>                  

<? 
GLO_cierratablaform();
mysql_close($conn);			
include ("../Codigo/FooterConUsuario.php");
?>