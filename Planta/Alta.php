<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLOF_Init('TxtFechaA','BannerConMenuHV','zAlta',0,'MenuH',0,0,0); 
GLO_tituloypath(0,700,'Stock.php','MOVIMIENTO STOCK','linksalir'); 
?> 


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="90" height="3"  ></td> <td width="260"></td><td width="100"></td> <td width="250"></td> </tr>
<tr><td height="18"  align="right"  >&nbsp;N&uacute;mero:</td><td  valign="top" >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"  value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right; width:50px"> </td><td align="right">Fecha:</td><td> &nbsp; <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   ><label class="MuestraError"> * </label><? calendario("TxtFechaA","../Codigo/","actual") ?></td></tr>

<tr><td height="18"  align="right"  >&nbsp;Tipo:</td><td  valign="top" >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:200px" onKeyDown="enterxtab(event)" onChange="this.form.submit()" ><option value=""></option><? ComboTablaRFX("stock_tipomov","CbTipo","Nombre","","and Id IN(1,2)",$conn); ?></select> <label class="MuestraError"> * </label></td><td align="right"></td><td</td></tr>

<tr><td align="right"  >&nbsp;Dep&oacute;sito:</td><td  valign="top" >&nbsp;<select name="CbDep" class="campos" id="CbDep"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("depositos","CbDep","Nombre","","and Tipo=1",$conn); ?></select> <label class="MuestraError"> * </label></td><td></td><td></td></tr>

<tr><td align="right"  >Propietario:</td><td  valign="top" >&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Interno,Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label></td><td></td><td></td></tr>
</table>

<? 

GLO_obsform(700,90,'Observaciones','TxtObs',0,2);



GLO_botonesform("700",0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>