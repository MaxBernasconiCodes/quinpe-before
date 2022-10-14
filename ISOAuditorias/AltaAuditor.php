<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

$_SESSION['TxtNroEntidad']=str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);
$_SESSION['TxtTipo'] =$_GET['IdTipo'];

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUp','zAltaAuditor',0,0,0,0);
GLO_tituloypath(950,600,'sgi','AUDITOR','salir');
?> 

<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Personal:</td><td  valign="top" >&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:450px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Otro:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:450px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()"> </td></tr>
</table>


<? 
GLO_Hidden('TxtTipo',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("600",0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>