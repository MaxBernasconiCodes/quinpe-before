<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4 and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get
GLO_ValidaGET($_GET['Id'],0,0);
$_SESSION['TxtNroEntidad']=intval($_GET['Id']);//idcomprobante

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

GLO_InitHTML($_SESSION["NivelArbol"],'TxtCantidad','BannerPopUpMH','zAltaItemNP',0,0,0,0); 
GLO_tituloypath(0,720,'','DETALLE COMPROBANTE','salir');
?> 


<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td></tr>
<tr> <td height="18"  align="right"  >Cantidad:</td><td >&nbsp;<input name="TxtCantidad" type="text"  tabindex="1"  class="TextBox" style="width:50px" maxlength="7"  value="<? echo $_SESSION['TxtCantidad']; ?>" onChange="this.value=validarNumeroP(this.value);"><label class="MuestraError"> * </label></td></tr>
</table>

<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td></tr>
<tr> <td height="18"  align="right"  >Art&iacute;culo o Equipo:</td><td >&nbsp;<? include ("../IncludesNG/BuscadorArticulo2.php");?></td></tr>
<tr> <td ></td><td height="5" ></td></tr>
<tr> <td height="18"  align="right">Producto Laboratorio:</td><td>&nbsp;<? include ("../IncludesNG/BuscadorArticuloLAB.php");?></td></tr>
</table>

<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td>&nbsp;<select name="CbProv" style="width:220px"  tabindex="15"  class="campos" id="CbProv" ><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td></tr>
</table> 





<? 
GLO_obsform(720,120,'Observaciones','TxtObs',4,0); 
GLO_botonesform("720",0,2);
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_mensajeerror(); 

mysql_close($conn); 
GLO_cierratablaform();

GLO_initcomment(720,0);
echo 'Seleccione <font class="comentario3">Art&iacute;culo</font> o <font class="comentario2">Producto</font><br>';
echo 'Podr&aacute; buscar el <font class="comentario2">Art&iacute;culo</font> por <font class="comentario3">C&oacute;digo</font> o <font class="comentario3">Nombre</font><br>';
echo 'Si no encuentra el <font class="comentario3">Item</font>, puede completar en <font class="comentario2">Observaciones</font> su descripcion';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");

?>