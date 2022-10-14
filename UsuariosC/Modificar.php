<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get (seguridad)
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//Muestra datos
$query="SELECT * From clientes_usr where Id='".intval($_GET['id'])."'";$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = $row['Id'];	
	$_SESSION['TxtUsuario'] = $row['Usuario'];	
	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
	$_SESSION['CbCliente'] = $row['IdCliente'];
	$_SESSION['TxtNombre']=$row['Nombre'];
	$_SESSION['TxtApellido'] = $row['Apellido'];
}mysql_free_result($rs);


GLOF_Init('CbCliente','BannerConMenuHV','zModificar',0,'../Usuarios/MenuH',0,0,0); 
GLO_tituloypath(0,500,'../UsuariosC.php','USUARIOS','linksalir'); 
?>

<table width="500" border="0" cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr><td height="21"  align="right"  >Empresa:</td><td valign="top" >&nbsp;<select name="CbCliente"  tabindex="1" class="campos" id="CbCliente" style="width:350px"> <? ComboTablaRFROX("clientes","CbCliente","Nombre","",intval($_SESSION['CbCliente']),"",$conn); ?>  </select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Usuario:</td><td  valign="top" >&nbsp;<input name="TxtUsuario" type="text"  tabindex="1" class="TextBox" style="width:350px" maxlength="100" value="<? echo $_SESSION['TxtUsuario']; ?>"  onKeyDown="enterxtab(event)"><label class="MuestraError"> * </label></td></tr>
</table>


<table width="500" border="0" cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr><td height="18"  align="right"  >Apellido:</td><td  valign="top" >&nbsp;<input name="TxtApellido" type="text"  class="TextBox" style="width:350px" maxlength="50" tabindex="1" value="<? echo $_SESSION['TxtApellido']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:350px" maxlength="50" tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td></tr>
</table>



<table width="500" border="0" cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr><td height="21"  align="right"  >Baja:</td><td valign="top" >&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",1) ?></td></tr>
</table>

<? 
GLO_Hidden('TxtNumero',0);
GLO_botonesform(500,0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn);	
include ("../Codigo/FooterConUsuario.php");
?>