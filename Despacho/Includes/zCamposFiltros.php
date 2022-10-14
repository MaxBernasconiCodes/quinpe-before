<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php") ;

?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="140"></td><td width="30"></td></tr>
<tr> <td height="18"  align="right">Fecha:</td><td>&nbsp;<?php  GLO_calendario("TxtFechaD","../Codigo/","actual",1); ?></td>    <td> al&nbsp;<?php  GLO_calendario("TxtFechaH","../Codigo/","actual",1); ?></td><td align="right">Numero:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="width:70px"></td><td align="right">Accion:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:120px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("despacho_tipo","CbTipo","Orden","","",$conn); ?></select></td><td></td></tr>

<tr> <td height="18"  align="right">Cliente:</td><td   colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right">Rto:</td><td>&nbsp;<input name="TxtRto" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtRto']; ?>"  style="width:70px" onChange="this.value=validarEntero(this.value);"></td><td  align="right">Estado:</td><td >&nbsp;<select name="CbEstado" style="width:120px" class="campos" id="CbEstado" ><option value=""></option> <? DES_CbEstado("CbEstado"); ?> </select></td><td   align="right" ><? GLO_Search('CmdBuscar',0); ?></td></tr>
</table>
