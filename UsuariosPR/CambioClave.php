<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT Usuario From usuarios where Usuario<>'admin' and Usuario='".mysql_real_escape_string($_GET['id'])."'";
$rs=mysql_query($query,$conn);while($row=mysql_fetch_array($rs)){$_SESSION['TxtUsuario'] = $row['Usuario'];}mysql_free_result($rs);
mysql_close($conn);



GLOF_Init('TxtClave','BannerConMenuHV','zCambioClave',0,'../Usuarios/MenuH',0,0,0); 
GLO_tituloypath(0,500,'../UsuariosPR.php','CLAVE DE ACCESO','linksalir'); 
?>



<table width="500" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td></tr>
<tr><td height="18"  align="right"  >Usuario:</td><td valign="top" >&nbsp;<input name="TxtUsuario" type="text" readonly="true" class="TextBoxRO"   style="width:160px" value="<? echo $_SESSION['TxtUsuario']; ?>"> </td></tr>
<tr><td height="18"  align="right"  >Clave:</td><td valign="top" >&nbsp;<input name="TxtClave" type="password"  class="TextBox"  style="width:160px" maxlength="8" value="<? echo $_SESSION['TxtClave']; ?>"> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Confirmar Clave:</td><td valign="top" >&nbsp;<input name="TxtConfirmar" type="password"  class="TextBox"  style="width:160px" maxlength="8" value="<? echo $_SESSION['TxtConfirmar']; ?>"> <label class="MuestraError"> * </label></td></tr>
</table>

<? 
GLO_botonesform(500,0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();

GLO_initcomment(500,0);
echo 'La Clave debe tener 8 caracteres y contener letras y numeros';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>