<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php");  include("Codigo/Funciones.php"); $_SESSION["NivelArbol"]="";
 
 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$query="SELECT * From usuarios where Usuario='".mysql_real_escape_string($_SESSION["login"])."'";
$rs=mysql_query($query,$conn);while($row=mysql_fetch_array($rs)){$_SESSION['TxtUsuario'] = $row['Usuario'];}mysql_free_result($rs);
mysql_close($conn);


GLOF_Init('TxtClaveActual','BannerConMenuHV','Intranet/zCambioClave',0,'',0,0,0); 
GLO_tituloypath(0,350,'Inicio.php','CLAVE DE ACCESO','linksalir'); ?>


<table width="350" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="250"></td></tr>
<tr><td height="18"  align="right"  >Usuario:</td><td valign="top" >&nbsp;<input name="TxtUsuario" type="text" readonly="true" class="TextBoxRO"    style="width:160px" value="<? echo $_SESSION['TxtUsuario']; ?>"> </td></tr>
<tr><td height="18"  align="right"  >Clave Actual:</td><td valign="top" >&nbsp;<input name="TxtClaveActual" type="password"  class="TextBox"  maxlength="8" tabindex="1" style="width:160px" value="<? echo $_SESSION['TxtClaveActual']; ?>" onKeyDown="enterxtab(event)"> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Clave Nueva:</td><td valign="top" >&nbsp;<input name="TxtClave" type="password"  class="TextBox"  maxlength="8" value="<? echo $_SESSION['TxtClave']; ?>" tabindex="2" style="width:160px"onKeyDown="enterxtab(event)"> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Confirmar Clave:</td><td  valign="top" >&nbsp;<input name="TxtConfirmar" type="password"  class="TextBox"  maxlength="8" value="<? echo $_SESSION['TxtConfirmar']; ?>" tabindex="3" style="width:160px"> <label class="MuestraError"> * </label></td></tr>
</table>


<? 
GLO_guardar(350,3,0);
GLO_mensajeerror(); 
GLO_cierratablaform();

GLO_initcomment(350,0);
echo 'La Clave debe tener 8 caracteres y contener letras y numeros';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>