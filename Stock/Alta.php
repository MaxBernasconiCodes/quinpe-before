<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}

GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaA','BannerConMenuHV','zAlta',0,0,0,0); 
include("MenuH.php");
GLO_tituloypath(950,700,'../Stock.php','MOVIMIENTO STOCK','linksalir'); 
?> 


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="90" height="3"  ></td> <td width="260"></td><td width="100"></td> <td width="250"></td> </tr>
<tr><td height="18"  align="right"  >&nbsp;N&uacute;mero:</td><td  valign="top" >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"  value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right; width:50px"> </td><td align="right">Fecha:</td><td> &nbsp; <input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   ><label class="MuestraError"> * </label><? calendario("TxtFechaA","../Codigo/","actual") ?></td></tr>

<tr><td height="18"  align="right"  >&nbsp;Tipo:</td><td  valign="top" >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:200px" onKeyDown="enterxtab(event)" onChange="this.form.submit()" ><option value=""></option><? ComboTablaRFX("stock_tipomov","CbTipo","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label></td><td align="right">Remito/Factura:</td><td> &nbsp; <input name="TxtTipo" type="text"  class="TextBox" maxlength="1" value="<? echo $_SESSION['TxtTipo']; ?>"  style="text-align:right;width:20px" onKeyUp="this.value=this.value.toUpperCase()"> <input name="TxtSuc" type="text"  class="TextBox" maxlength="4"  value="<? echo $_SESSION['TxtSuc']; ?>" onChange="this.value=validarEnteroCompletar(this.value,'0000',-4);" style="text-align:right;width:33px"> <input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>" onChange="this.value=validarEnteroCompletar(this.value,'00000000',-8);" style="text-align:right;width:60px"></td></tr>

<tr><td align="right"  >&nbsp;Dep&oacute;sito:</td><td  valign="top" >&nbsp;<select name="CbDep" class="campos" id="CbDep"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("depositos","CbDep","Tipo,Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label></td><td></td><td></td></tr>

<tr><td align="right"  >Propietario:</td><td  valign="top" >&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Interno,Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label></td><td></td><td></td></tr>
</table>

<? 
if($_SESSION['CbTipo']==3){include ("zCampo0.php");} //remito ingreso 
if($_SESSION['CbTipo']==4){include ("zCampo1.php");}//remito egreso 

GLO_obsform(700,90,'Observaciones','TxtObs',0,2);

GLO_botonesform("700",0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>