<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
GLO_PerfilAcceso(14);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFecha1'])){ $_SESSION['TxtFecha1']=date("d-m-Y");}

$_SESSION['TxtIdPers2']= $_SESSION["GLO_IdPersCON"]; 
$_SESSION['TxtIdPers3']= $_SESSION["GLO_IdPersAPR"]; 


GLOF_Init('TxtCod','BannerConMenuHV','zAlta',0,'MenuH',0,0,0); 
GLO_tituloypath(0,725,'../ISO_Doc.php','DOCUMENTO','linksalir');
?> 



<table width="725" border="0"  cellpadding="0" cellspacing="0" >
<tr><td class="comentario" style="text-align:left">Agregue s&oacute;lo la primer versi&oacute;n del documento. Las nuevas versiones se generan desde el &uacute;ltimo documento aprobado. </td></tr>
</table> 


<table width="725" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="4">&nbsp;<strong>Propiedades:</strong></td>  </tr>
<tr>

<td height="18"  align="right"  >Codigo:</td>
<td  valign="top" > &nbsp; <input name="TxtCod" type="text" class="TextBox" style="width:100px" maxlength="15"  value="<? echo $_SESSION['TxtCod']; ?>" onKeyUp="this.value=this.value.toUpperCase()"> <label class="MuestraError"> * </label></td><td   align="right"  ></td><td  valign="top" ></td></tr>

<tr><td height="18"  align="right"  >Versi&oacute;n:</td><td  valign="top" > &nbsp; <input name="TxtVs" type="text"  class="TextBox" style="text-align:right;width:25px" maxlength="2"  value="<? echo $_SESSION['TxtVs']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td><td height="18"  align="right"  ></td><td  valign="top" > </td></tr>

<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" > &nbsp; <select name="CbTipo" style="width:200px" class="campos"><option value=""></option><? ComboTablaRFX("iso_doc_tipo","CbTipo","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label> </td><td height="18"  align="right"  ></td><td  valign="top" >&nbsp;  </td></tr>

<tr><td height="18"  align="right"  >Sector:</td><td  valign="top" > &nbsp; <select name="CbSector" style="width:200px" class="campos"><option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select> <label class="MuestraError"> * </label> </td><td align="right"  ></td><td  valign="top" ></td></tr>

<tr><td height="18"  align="right"  >Origen:</td><td  valign="top" > &nbsp; <select name="CbOrigen" style="width:200px" class="campos"><option value=""></option><? ComboISOOrigenDoc(); ?></select> </td><td align="right"  ></td><td  valign="top" ></td></tr>
</table> 



<!-- documento -->
<table width="725" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="2" >&nbsp;<strong>Documento:</strong></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Nombre:</td><td  valign="top"  colspan="3"> &nbsp; <input name="TxtNombre" type="text" class="TextBox" style="width:600px" maxlength="200"  value="<? echo $_SESSION['TxtNombre']; ?>"> <label class="MuestraError"> * </label></td></tr>
</table>



<!-- creacion -->
<table width="725" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="80" height="5"  ></td> <td width="280"></td><td width="85" height="5"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="left" colspan="2" >&nbsp;<strong>Creaci&oacute;n:</strong></td></tr>

<tr> <td height="18"  align="right"  >Personal:</td><td> &nbsp; <select name="CbPers1" style="width:240px" class="campos"><option value=""></option><? ComboPersonalRFX('CbPers1',$conn); ?></select><label class="MuestraError"> * </label></td><td align="right">Fecha:</td><td>&nbsp; <input name="TxtFecha1" id="TxtFecha1"  type="text" class="TextBox"  style="width:70px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha1']; ?>"   ><label class="MuestraError"> * </label><? calendario("TxtFecha1","../Codigo/","actual") ?></td></tr>

<tr> <td height="18"  align="right"  >Proveedor:</td><td> &nbsp; <select name="CbProv1" style="width:240px" class="campos"><option value=""></option><? ComboProveedorRFX('CbProv1',"",$conn); ?></select><label class="MuestraError"> * </label></td><td align="right"></td><td></td></tr>

<tr> <td height="18"  align="right"  valign="top" >Comentario:</td><td colspan="3" valign="top" > &nbsp; <textarea name="TxtCom1" style="resize:none;width:600px" rows="1" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtCom1']; ?></textarea></td></tr>
</table>


<? 
GLO_Hidden('TxtIdPers2',0);GLO_Hidden('TxtIdPers3',0);
GLO_botonesform("725",0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(725,0);
echo 'En los datos de <font class="comentario3">Creacion</font> seleccione <font class="comentario2">Personal</font> o <font class="comentario2">Proveedor</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>