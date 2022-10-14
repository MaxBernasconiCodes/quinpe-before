<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



?>






<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	                    



<table width="730" border="0"  cellspacing="0" class="Tabla" >

<tr ><td width="100" height="3"  ></td> <td width="100"></td> <td width="30"></td><td width="140"></td><td width="100" height="3"  ></td> <td width="260"></td> </tr>

<tr> <td height="18"  align="right"  >Valor:</td><td  valign="top"  colspan="3">&nbsp; <input name="TxtPrecio" type="text"  class="TextBox" style="text-align:right;width:100px" maxlength="14" tabindex="6"  value="<? echo $_SESSION['TxtPrecio']; ?>" onChange="this.value=validarMoneda(this.value);"></td><td height="18"  align="right"  >Meses Amortiz:</td><td  valign="top" >&nbsp; <input name="TxtMes" type="text"  tabindex="7"  class="TextBox" style="text-align:right;width:50px" maxlength="5"  value="<? echo $_SESSION['TxtMes']; ?>" onChange="this.value=validarEntero(this.value);" >&nbsp;&nbsp;Amortiz.Mensual:&nbsp;<input  name="TxtAMes" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtAMes'];?>" style="text-align:right;width:80px"></td></tr>

<tr> <td height="18"  align="right"  >Valor Residual:</td><td  valign="top"  colspan="3">&nbsp; <input name="TxtPrecioR" type="text"  class="TextBox" style="text-align:right;width:100px" maxlength="14"  tabindex="6" value="<? echo $_SESSION['TxtPrecioR']; ?>" onChange="this.value=validarMoneda(this.value);"></td><td height="18"  align="right"  >Adquisicion:</td><td  valign="top" >&nbsp; <select name="CbFAdq" style="width:225px" class="campos" id="CbFAdq"  tabindex="7"><option value=""></option> <? ComboTablaRFX("unidadesadquisicion","CbFAdq","Nombre","","",$conn); ?> </select></td></tr>

</table> 





