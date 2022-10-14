<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,720,'Cotizaciones.php','COTIZACION','linksalir');
?>

<table width="720" border="0" cellspacing="0" class="Tabla" >
<tr><td width="105" height="3"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="160"></td> </tr>
<tr><td height="18"  align="right"  >Numero:</td><td  valign="top" >&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>"></td>
<td height="18"  align="right"  >Fecha:</td><td  valign="top" >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td><label class="MuestraError"> * </label></td></tr>

<tr> <td height="18"  align="right"  >Cliente:</td><td  valign="top">&nbsp;<select name="CbCliente" style="width:220px" class="campos" tabindex="1" id="CbCliente"> <? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn);}else{ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn);} ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Presentaci&oacute;n:</td><td  valign="top" colspan="2">&nbsp;<?php  GLO_calendario("TxtFechaP","../Codigo/","actual",1); ?></td></tr>

<tr> <td height="18"  align="right"  >Vendedor:</td><td  valign="top">&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  tabindex="1" style="width:220px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Estado:</td><td colspan="2">&nbsp;<select name="CbEstado" style="width:150px" class="campos" tabindex="1" id="CbEstado" ><option value=""></option> <? ComboTablaRFX("c_coti_estados","CbEstado","Id","","and Id<>5",$conn); ?> </select></td></tr>

<tr> <td height="18"  align="right"  >Tipo Servicio:</td><td  valign="top">&nbsp;<select name="CbTipo"  style="width:220px" class="campos" tabindex="1"  id="CbTipo" ><option value=""></option><? ComboTablaRFX("serviciostipo1","CbTipo","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Oportunidad:</td><td colspan="2">&nbsp;<input name="TxtIdOp" type="text"  class="TextBoxRO" style="text-align:right;width:65px" readonly="true" value="<? echo $_SESSION['TxtIdOp']; ?>"></td></tr>

<tr> <td height="18"  align="right"  >Tipo Contratacion:</td><td  valign="top">&nbsp;<select name="CbTipoC"  style="width:220px" class="campos" tabindex="1"  id="CbTipoC" ><option value=""></option><? ComboTablaRFX("c_oportunidad_tipoc","CbTipoC","Nombre","","",$conn); ?> </select></td><td  align="right"  ></td><td colspan="2">&nbsp;</td></tr>

</table> 




<table width="720" border="0" cellspacing="0" class="Tabla TMT" >
<tr><td width="105" height="3"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="160"></td> </tr>

<tr> <td height="18"  align="right"  >Comprador:</td><td  valign="top" colspan="4">&nbsp;<input name="TxtContacto" type="text" class="TextBox" tabindex="1" style="width:560px" maxlength="200"  value="<? echo $_SESSION['TxtContacto']; ?>" > </td></tr>

<tr> <td height="18"  align="right"  >Area:</td><td  valign="top" colspan="4">&nbsp;<input name="TxtRef" type="text" class="TextBox" tabindex="1" style="width:560px" maxlength="200"  value="<? echo $_SESSION['TxtRef']; ?>" > </td></tr>

<tr> <td height="18"  align="right"  >Locacion:</td><td  valign="top" colspan="4">&nbsp;<input name="TxtUbic" type="text" class="TextBox" tabindex="1" style="width:560px" maxlength="200"  value="<? echo $_SESSION['TxtUbic']; ?>" > </td></tr>

<tr> <td height="18"  align="right"   valign="top">Observaciones:</td><td  valign="top" colspan="4">&nbsp;<textarea name="TxtObs" style="width:560px" rows="7" class="TextBox" tabindex="1" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObs']; ?></textarea> </td></tr>
</table> 


<? 
GLO_Hidden('TxtId',0);
GLO_guardar("720",2,0);
GLO_mensajeerror();
?>