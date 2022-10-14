<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
GLO_PerfilAcceso(16);


//get

GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT * From iso_tiporef where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] = $row['Nombre'];
		$_SESSION['TxtObs'] = $row['Obs'];
	}mysql_free_result($rs);
}



GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',0,'',0,0,0); 
GLO_tituloypath(0,550,'Consulta.php','REFERENCIA','linksalir');
?> 


<table width="550" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="450"></td></tr>
<tr><td  align="right"  >Nombre:</td><td >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:300px" maxlength="30"  value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"> <label class="MuestraError"> * </label></td></tr>
</table>


<?
GLO_obsform(550,100,'Observaciones','TxtObs',10,0);
GLO_Hidden('TxtNumero',0);
GLO_botonesform("550",0,2); 
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>