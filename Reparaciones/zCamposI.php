<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,730,'','INSUMOS','salir');
?>




<table width="730" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="5"  ></td> <td width="120"></td> <td width="10"></td><td width="140"></td><td width="100" height="3"  ></td> <td width="260"></td> </tr>
<tr><td height="18"  align="right"  >Cantidad:</td><td  valign="top" colspan="3">&nbsp;<input name="TxtCantidad" type="text"  tabindex="1"  class="TextBox" style="width:50px" maxlength="7"  value="<? echo $_SESSION['TxtCantidad']; ?>" onChange="this.value=validarNumero(this.value);"><label class="MuestraError"> * </label></td><td height="18"  align="right"  >&nbsp;</td><td  valign="top" >&nbsp;</td>
<tr> <td height="18"  align="right" >Art&iacute;culo:</td><td  valign="top"  colspan="5">&nbsp;<? include ("../IncludesNG/BuscadorArticulo.php");?><label class="MuestraError"> * </label>&nbsp;</td></tr>
</tr>
</table>


<table width="730" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="5"  ></td> <td width="120"></td> <td width="10"></td><td width="140"></td><td width="100" height="3"  ></td> <td width="260"></td> </tr>
<tr>  <td height="18"  align="right"  >PSI:</td><td  valign="top" colspan="3">&nbsp;<input name="TxtPSI" type="text"  tabindex="1"  class="TextBox" style="text-align:right;width:70px" maxlength="8"  value="<? echo $_SESSION['TxtPSI']; ?>" onChange="this.value=validarEntero(this.value);" >&nbsp;<input name="TxtFechaP" id="TxtFechaP"  tabindex="1"  type="text" class="TextBox"  style="width:70px;" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaP']; ?>"   > <? calendario("TxtFechaP","../Codigo/","actual") ?></td><td height="18"  align="right"  ></td>  <td  valign="top" >&nbsp;</td></tr>
<tr>  <td height="18"  align="right"  >MIM:</td><td  valign="top" colspan="3">&nbsp;<input name="TxtMIM" type="text"  tabindex="1"  class="TextBox" style="text-align:right;width:70px" maxlength="8"  value="<? echo $_SESSION['TxtMIM']; ?>" onChange="this.value=validarEntero(this.value);" >&nbsp;<input name="TxtFechaM" id="TxtFechaM"  tabindex="1"  type="text" class="TextBox"  style="width:70px;" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaM']; ?>"   > <? calendario("TxtFechaM","../Codigo/","actual") ?></td><td height="18"  align="right"  ></td>  <td  valign="top" >&nbsp;</td></tr>
</table>


<?
if (intval($_SESSION['TxtIdEstadoO'])!=7 and intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
GLO_botonesform("730",0,2);}


//hidden
GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdOrden',0);GLO_Hidden('TxtIdEstadoO',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);

GLO_mensajeerror(); 
?>