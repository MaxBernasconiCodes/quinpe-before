<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(950,740,'../ISO_Auditorias.php','AUDITORIA','linksalir');?>


<table width="740" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="5"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="185"></td> </tr>
<tr><td height="18"  align="right"  >Tipo:</td><td  valign="top" >&nbsp;<select name="CbTipo" style="width:220px" class="campos"  id="CbTipo" ><? ComboTablaRFROX("iso_audi_tipo","CbTipo","Id","",$_SESSION['CbTipo'],"",$conn); ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Programada:</td><td  valign="top" > &nbsp; <? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td><label class="MuestraError"> * </label> </td></tr>

<tr> <td height="18"  align="right"  >Sector:</td><td  valign="top">&nbsp;<select name="CbSector" style="width:220px" class="campos" tabindex="1" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Realizada:</td><td  valign="top"> &nbsp; <? GLO_calendario("TxtFechaB","../Codigo/","actual",2) ?></td><td>Hora:&nbsp;<input name="TxtHora"   id="time" type="text"  class="TextBox"  style="width:40px" maxlength="5"  tabindex="2"  value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);" >&nbsp;&nbsp;&nbsp;Duraci&oacute;n:&nbsp;<input name="TxtHoraD"   id="time" type="text"  class="TextBox"  style="width:40px" maxlength="5"  tabindex="2" value="<? echo $_SESSION['TxtHoraD']; ?>" onChange="this.value=validarHora(this.value);" ></td></tr>

<tr> <td height="18"  align="right"  ></td><td  valign="top"><input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"  value="1"<? if ($_SESSION['OptTipo'] ==1) echo 'checked'; ?> >Interna   &nbsp;&nbsp;&nbsp;<input name="OptTipo"  type="radio"  class="radiob" tabindex="1"  value="2"<? if ($_SESSION['OptTipo'] ==2) echo 'checked'; ?> >Externa</td><td height="18"  align="right"  >Reprogramada</td><td  valign="top" colspan="2"> &nbsp; <? GLO_calendario("TxtFechaRP","../Codigo/","actual",2) ?></td></tr>
</table> 

<table width="740" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="640"></td></tr>
<tr> <td  align="right" height="18">Nombre:</td><td >&nbsp;<input name="TxtNombre" type="text" class="TextBox"   tabindex="3"  style="width:600px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" > <label class="MuestraError"> * </label></td></tr>
</table> 



<table width="740" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="260"></td><td width="95" ></td> <td width="285"></td> </tr>
<tr> <td height="18"  align="right"  >Lugar:</td><td  valign="top">&nbsp;<select name="CbYac" style="width:220px" class="campos" tabindex="3"  id="CbYac" ><option value=""></option><? ComboTablaRFX("yacimientos","CbYac","Nombre","","",$conn); ?> </select> </td><td height="18"  align="right"  ></td><td  valign="top" ><input name="ChkAnul"  type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkAnul'] =='1') echo 'checked'; ?>> Anulada &nbsp;<input name="TxtEstado" type="text"  class="TextBoxRO" <?  echo $colorestado; ?> readonly="true" value="<? echo $_SESSION['TxtEstado']; ?>"></td></tr>
</table> 



<table width="740" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="640"></td></tr>
<tr> <td  align="right" height="18" valign="top">Alcance:</td><td >&nbsp;<textarea name="TxtAlc" style="width:600px" rows="2"  tabindex="4" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtAlc']; ?></textarea></td></tr>

<tr> <td  align="right" height="18" valign="top">Metodologia:</td><td >&nbsp;<textarea name="TxtMet" style="width:600px" rows="2"  tabindex="4" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtMet']; ?></textarea></td></tr>

<tr> <td  align="right" height="18" valign="top">Responsabilidad:</td><td >&nbsp;<textarea name="TxtRes" style="width:600px" rows="2"  tabindex="4" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtRes']; ?></textarea></td></tr>
<tr> <td  align="right" height="18" valign="top">Criterios:</td><td >&nbsp;<textarea name="TxtCri" style="width:600px" rows="2"  tabindex="4" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtCri']; ?></textarea></td></tr>
</table> 



<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
?>