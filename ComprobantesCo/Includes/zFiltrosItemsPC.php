<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}





?>



<table width="750" border="0"  cellspacing="0" class="Tabla" >

<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="80"></td><td width="90"></td><td width="110"></td></tr>

<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td align="right">Unidad:</td><td>&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?></select></td>	<td  align="right">Pedido:</td><td>&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"></td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Sin Cotizar</td></tr>

<tr> <td height="18"  align="right">Art&iacute;culo:</td><td colspan="2">&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:175px" maxlength="30" onKeyDown="enterxtab(event)"></td><td  align="right">Proveedor:</td><td>&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td>	<td  align="right">Nro.Interno:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"></td><td><input name="ChkSA"  type="checkbox"  value="1" <? if ($_SESSION['ChkSA'] =='1') echo 'checked'; ?>> Sin Articulo</td></tr>

<tr> <td height="18"  align="right">Solicitante:</td><td colspan="2">&nbsp;<select name="CbSoli" class="campos" id="CbSoli"  style="width:175px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalSoliNP($conn); ?></select></td><td  align="right"></td><td></td><td  align="right"></td><td></td><td align="right"><? GLOF_Search('CmdBuscar',0); ?>&nbsp;</td></tr>

</table>