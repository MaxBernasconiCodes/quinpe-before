<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4 and  $_SESSION["IdPerfilUser"]!=3 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

?>



<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>  

<table width="720" border="0"   cellspacing="0" class="Tabla" >

<tr><td width="110" height="3"  ></td> <td width="120"></td><td width="140"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="155"></td> </tr>

<tr> <td height="18"  align="right"  ><input name="ChkEfe"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkEfe'] =='1') echo 'checked'; ?>></td><td >&nbsp;Efectivo $: </td><td><input  name="TxtEfe" type="text"  class="TextBox" style="width:110px" maxlength="20"   value="<? echo $_SESSION['TxtEfe'];?>"  > </td><td height="18"  align="right"  ><input name="ChkF1"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkF1'] =='1') echo 'checked'; ?>></td><td  >&nbsp;Factura Nro: </td><td><input  name="TxtF1" type="text"  class="TextBox" style="width:130px" maxlength="20"   value="<? echo $_SESSION['TxtF1'];?>"  >    </td></tr>

<tr> <td height="18"  align="right"  ><input name="ChkChe"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkChe'] =='1') echo 'checked'; ?>></td><td >&nbsp;Cheque Nro: </td><td><input  name="TxtChe" type="text"  class="TextBox" style="width:110px" maxlength="20"   value="<? echo $_SESSION['TxtChe'];?>"  > </td> <td height="18"  align="right"  ><input name="ChkRem"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkRem'] =='1') echo 'checked'; ?>></td><td  >&nbsp;Remito Nro:</td>  <td><input  name="TxtRem" type="text"  class="TextBox" style="width:130px" maxlength="20"   value="<? echo $_SESSION['TxtRem'];?>"  ></td>

</tr>

<tr> <td height="18"  align="right"  ><input name="ChkCC"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkCC'] =='1') echo 'checked'; ?>></td><td >&nbsp;Cuenta Corriente </td><td> </td><td height="18"  align="right"  ></td><td  ></td><td>   </td></tr>

<tr> <td height="18"  align="right"  ><input name="ChkTran"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkTran'] =='1') echo 'checked'; ?>></td><td >&nbsp;Transferencia </td><td> </td><td height="18"  align="right"  ></td><td  ></td><td>   </td></tr>

<tr> <td height="18"  align="right"  ><input name="ChkTranD"  type="checkbox" class="check"  value="1" <? if ($_SESSION['ChkTranD'] =='1') echo 'checked'; ?>></td><td  colspan="2">&nbsp;Transferencia Diferida </td><td height="18"  align="right"  ></td><td  ></td><td>   </td></tr>

</table> 



<? GLO_obsform(720,110,'Observaciones','TxtObs',2,0); ?>