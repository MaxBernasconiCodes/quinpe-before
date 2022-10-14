<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get (seguridad)
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$query="SELECT * From clientes_usr where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){	
	$_SESSION['TxtNumero'] = $row['Id'];	
	$_SESSION['TxtUsuario'] = $row['Usuario'];	
}mysql_free_result($rs);
mysql_close($conn);

GLOF_Init('TxtClave','BannerConMenuHV','zCambioClave',0,'../Usuarios/MenuH',0,0,0); 
GLO_tituloypath(0,400,'../UsuariosC.php','CLAVE DE ACCESO','linksalir'); 
?>



<table width="400" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="300"></td></tr>
<tr><td height="18"  align="right"  >Usuario:</td><td valign="top" >&nbsp;<input name="TxtUsuario" type="text" readonly="true" class="TextBoxRO"   style="width:250px" value="<? echo $_SESSION['TxtUsuario']; ?>"> </td></tr>
<tr><td height="18"  align="right"  >Clave:</td><td valign="top" >&nbsp;<input name="TxtClave" type="password"  tabindex="1" class="TextBox"  style="width:250px" maxlength="8" value="<? echo $_SESSION['TxtClave']; ?>"> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Confirmar Clave:</td><td valign="top" >&nbsp;<input name="TxtConfirmar" type="password"  class="TextBox"  style="width:250px" maxlength="8" tabindex="1" value="<? echo $_SESSION['TxtConfirmar']; ?>"> <label class="MuestraError"> * </label></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform(400,0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();

GLO_initcomment(400,0);
echo 'La Clave debe tener 8 caracteres y contener <font class="comentario3">letras</font> y <font class="comentario3">numeros</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>