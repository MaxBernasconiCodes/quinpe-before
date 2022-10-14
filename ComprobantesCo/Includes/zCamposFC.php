<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4 and  $_SESSION["IdPerfilUser"]!=3 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

?>

<? GLO_tituloypath(0,720,'','FACTURA',''); ?>

<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="110" height="3"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="155"></td> </tr>
<tr><td height="18"  align="right"  >Nro.Interno:</td><td  valign="top" > &nbsp; <input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>"></td><td height="18"  align="right"  >Alta:</td>
<td  valign="top" > &nbsp; <? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top"> &nbsp; <select name="CbProv" style="width:220px" class="campos" tabindex="1" id="CbProv" ><? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';ComboProveedorRFX("CbProv","",$conn);}else{ComboProveedorRFROX("CbProv",intval($_SESSION['CbProv']),"",$conn);} ?></select><label class="MuestraError"> * </label></td>
<td height="18"  align="right"  >Estado:</td><td  valign="top" colspan="2"><select name="CbEstado" tabindex="1" style="width:120px" class="campos" id="CbEstado" > <? ComboTablaRFX("co_facturas_est","CbEstado","Id","","",$conn); ?> </select></td></tr>
<tr> <td height="18"  align="right"  >Factura:</td><td  valign="top">&nbsp; <input name="TxtTipo" type="text"  tabindex="1"  class="TextBox" maxlength="1" value="<? echo $_SESSION['TxtTipo']; ?>"   style="text-align:right;width:20px" onKeyUp="this.value=this.value.toUpperCase()"> <input name="TxtSuc" type="text"  class="TextBox" maxlength="4" tabindex="1"   value="<? echo $_SESSION['TxtSuc']; ?>" onChange="this.value=validarEnteroCompletar(this.value,'0000',-4);" style="text-align:right;width:33px"> <input name="TxtNro" type="text"  tabindex="1"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>"   onChange="this.value=validarEnteroCompletar(this.value,'00000000',-8);" style="text-align:right;width:60px"> </td><td height="18"  align="right"  ></td><td  valign="top" colspan="2">&nbsp; </td></tr>
</table> 


<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>  


<table width="720" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="110" height="3"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="155"></td> </tr>
<tr> <td height="18"  align="right"  >Tipo IVA:</td><td  valign="top">&nbsp; <input name="OptTipoIVA"  type="radio"  class="radiob"   value="1"<? if ($_SESSION['OptTipoIVA'] ==1) echo 'checked'; ?> >21%   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="OptTipoIVA"  type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptTipoIVA'] ==2) echo 'checked'; ?> >10,5%   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="OptTipoIVA"  type="radio"  class="radiob"   value="0"<? if ($_SESSION['OptTipoIVA'] ==0) echo 'checked'; ?> >Ninguno </td><td height="18"  align="right"  ></td><td  valign="top" colspan="2">&nbsp; </td></tr>
<tr> <td height="18"  align="right"  >Subtotal:</td><td  valign="top">&nbsp; <input name="TxtST" type="text"  class="TextBoxRO" style="text-align:right;width:80px"  readonly="true"  value="<? echo $_SESSION['TxtST']; ?>" > </td><td height="18"  align="right"  ></td><td  valign="top" colspan="2">&nbsp; </td></tr>
<tr> <td height="18"  align="right"  >IVA:</td><td  valign="top">&nbsp; <input name="TxtIVA" type="text"  class="TextBoxRO" style="text-align:right;width:80px" readonly="true"   value="<? echo $_SESSION['TxtIVA']; ?>" > </td><td height="18"  align="right"  ></td><td  valign="top" colspan="2">&nbsp; </td></tr>
<tr> <td height="18"  align="right"  >Otros Impuestos:</td><td  valign="top">&nbsp;  <input name="TxtOI" type="text"  class="TextBox" style="text-align:right;width:80px" maxlength="12"  tabindex="1"  value="<? echo $_SESSION['TxtOI']; ?>" onChange="this.value=validarNumero(this.value);"></td><td height="18"  align="right"  ></td><td  valign="top" colspan="2">&nbsp; </td></tr>
<tr> <td height="18"  align="right"  >Total:</td><td  valign="top">&nbsp; <input name="TxtTO" type="text"  class="TextBoxRO" style="text-align:right;width:80px" readonly="true"  value="<? echo $_SESSION['TxtTO']; ?>" > </td><td height="18"  align="right"  ></td><td  valign="top" colspan="2">&nbsp; </td></tr>
</table> 


<? 
GLO_obsform(720,110,'Observaciones','TxtObs',2,0);
GLO_Hidden('TxtId',0);
GLO_botonesform(720,0,0);
GLO_mensajeerror();
?>
