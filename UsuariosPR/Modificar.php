<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;  $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Usuarios/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//Muestra datos
$query="SELECT * From usuarios where Usuario='".mysql_real_escape_string($_GET['id'])."'";$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtUsuario'] = $row['Usuario'];	
	$_SESSION['CbPerfil'] = $row['IdPerfil'];
	$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaBaja']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
}mysql_free_result($rs);





GLOF_Init('CbPerfil','BannerConMenuHV','zModificar',0,'../Usuarios/MenuH',0,0,0); 
GLO_tituloypath(0,600,'../UsuariosPR.php','USUARIOS','linksalir'); 
?>



<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Usuario:</td><td  valign="top" >&nbsp;<input name="TxtUsuario" type="text"  class="TextBoxRO"  style="width:200px" readonly="true" value="<? echo $_SESSION['TxtUsuario']; ?>">  </td></tr>
<tr><td height="21"  align="right"  >Perfil:</td><td valign="top" >&nbsp;<select name="CbPerfil"  class="campos" id="CbPerfil" style="width:200px"><? USR_ComboPerfil(3,$conn); ?> </select> <label class="MuestraError"> * </label></td></tr>
<tr><td height="21"  align="right"  >Baja:</td><td valign="top" >&nbsp;<input name="TxtFechaB" id="TxtFechaB"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"   >
<? calendario("TxtFechaB","../Codigo/","actual") ?></td></tr>
</table>


<? 
GLO_botonesform(600,0,2);
GLO_mensajeerror(); 
GLO_cierratablaform();
mysql_close($conn);	

GLO_initcomment(600,0);
echo 'El perfil <font class="comentario3">Administrador Sistema</font> tiene acceso a todos los  <font class="comentario2">Modulos</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>