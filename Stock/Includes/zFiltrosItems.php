<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}




?>


<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="80"></td><td width="120"></td><td width="70"></td><td width="90"></td><td width="40"></td></tr>
<tr> <td height="18"  align="right" >Alta OC:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td align="right">Proveedor:</td><td>&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:90px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td><td  align="right">Pedido:</td><td>&nbsp;<input   name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"></td><td></td></tr>
<tr> <td height="18"  align="right">Art&iacute;culo:</td><td colspan="2">&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:175px" maxlength="30" onKeyDown="enterxtab(event)"></td><td  align="right"></td><td>&nbsp;</td>	<td  align="right">OC:</td><td  >&nbsp;<input name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>"  style="width:60px"></td><td align="right"><? GLO_Search('CmdBuscar',0); ?></td></tr>
</table>