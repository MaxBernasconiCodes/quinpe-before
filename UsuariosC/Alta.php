<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ; include("../Codigo/Funciones.php") ;  $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLOF_Init('CbCliente','BannerConMenuHV','zAlta',0,'../Usuarios/MenuH',0,0,0); 
GLO_tituloypath(0,500,'../UsuariosC.php','USUARIOS','linksalir'); 
?> 


<table width="500" border="0" cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr><td height="21"  align="right"  >Empresa:</td><td valign="top" >&nbsp;<select name="CbCliente"  tabindex="1" class="campos" id="CbCliente" style="width:350px"><option value=""></option> <? ComboTablaRFX("clientes","CbCliente","Nombre","","",$conn); ?>  </select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Usuario:</td><td  valign="top" >&nbsp;<input name="TxtUsuario" type="text"  tabindex="1" class="TextBox" style="width:350px" maxlength="100" value="<? echo $_SESSION['TxtUsuario']; ?>"  onKeyDown="enterxtab(event)" placeholder="Correo electronico"><label class="MuestraError"> * </label></td></tr>
</table>


<table width="500" border="0" cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr><td height="18"  align="right"  >Apellido:</td><td  valign="top" >&nbsp;<input name="TxtApellido" type="text"  class="TextBox" style="width:350px" maxlength="50" tabindex="1" value="<? echo $_SESSION['TxtApellido']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:350px" maxlength="50" tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td></tr>
</table>



<table width="500" border="0" cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr><td height="18"  align="right"  >Clave:</td><td  valign="top" >&nbsp;<input name="TxtClave" type="password"  tabindex="1" class="TextBox"  style="width:200px" maxlength="8" value="<? echo $_SESSION['TxtClave']; ?>"> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Confirmar Clave:</td><td  valign="top" >&nbsp;<input name="TxtConfirmar" type="password"  tabindex="1" class="TextBox"  style="width:200px" maxlength="8" value="<? echo $_SESSION['TxtConfirmar']; ?>"> <label class="MuestraError"> * </label></td></tr>
</table>

<? 
GLO_botonesform(500,0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn);	

GLO_initcomment(500,0);
echo 'La Clave debe tener 8 caracteres y contener <font class="comentario3">letras</font> y <font class="comentario3">numeros</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>