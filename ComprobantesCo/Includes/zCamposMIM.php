<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4 and  $_SESSION["IdPerfilUser"]!=3 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



GLO_tituloypath(0,720,'','MIM','');

?>



<table width="720" border="0"  cellspacing="0" class="Tabla" >

<tr><td width="100" height="3"  ></td> <td width="140"></td><td width="170"></td><td width="80" height="3"  ></td> <td width="130"></td><td width="100"></td> </tr>

<tr><td height="18"  align="right"  >MIM:</td><td >&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION[TxtNumero]; ?>"></td><td></td><td height="18"  align="right"  >Alta:</td><td  >&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td></td></tr>

<tr> <td height="18"  align="right"  >Servicio/CC:</td><td colspan="2"> &nbsp;<select name="CbCentro" style="width:220px" tabindex="1"  class="campos" id="CbCentro" ><option value=""></option> <? GLO_ComboActivo("centrosoperativoscompras","CbCentro","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  ></td><td></td><td></td></tr>

<tr> <td height="18"  align="right"  ></td><td ><input name="ChkI1"  type="checkbox"  value="1" <? if ($_SESSION[ChkI1] =='1') echo 'checked'; ?>> Pedido</td><td ><input name="ChkI3"  type="checkbox"  value="1" <? if ($_SESSION[ChkI3] =='1') echo 'checked'; ?>> Devolucion</td><td align="right"  >&nbsp;</td><td> </td><td></td></tr>

<tr> <td height="18"  align="right"  ></td><td ><input name="ChkI2"  type="checkbox"  value="1" <? if ($_SESSION[ChkI2] =='1') echo 'checked'; ?>> Reparacion</td><td ><input name="ChkI4"  type="checkbox"  value="1" <? if ($_SESSION[ChkI4] =='1') echo 'checked'; ?>> Envio</td><td align="right"  >&nbsp;</td>  <td> </td>  <td></td></tr>

</table> 



<?

GLO_obsform(720,100,'Observaciones','TxtObs',2,0);

GLO_Hidden('TxtId',0);

GLO_botonesform("720",0,0);

GLO_mensajeerror(); 

?>