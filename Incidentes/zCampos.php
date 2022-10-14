<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,850,'../Incidentes.php','INCIDENTES/ACCIDENTES','linksalir');
?>




<table width="850" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="100"></td><td width="300"></td><td width="70"></td><td width="150"></td><td width="150"></td></tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td>Hora:&nbsp;<input name="TxtHora"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);" tabindex="1"><label class="MuestraError"> * </label></td><td align="right">Estado:</td><td  >&nbsp;<select name="CbEstado" tabindex="2"  style="width:100px" class="campos" id="CbEstado" ><? INC_cbestado("CbEstado"); ?> </select></td><td></td></tr>

<tr> <td height="18"  align="right"  >Sector:</td><td colspan="2">&nbsp;<select name="CbSector" style="width:250px" class="campos" id="CbSector"  tabindex="1"><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td></td><td valign="top"><input name="Chk1"  type="checkbox"  class="check" tabindex="2"  value="1" <? if ($_SESSION['Chk1'] =='1') echo 'checked'; ?>> Laboral</td><td align="right"><? if (intval($_SESSION['TxtNumero'])!=0){ echo '<input name="CmdI1" type="submit" class="boton02"  value="Informe Accidente" style="width:115px;height:18px" onClick="document.Formulario.target='."'_self'".'">&nbsp;'; } ?></td></tr>

<tr> <td height="18"  align="right"  >Lugar:</td><td colspan="2">&nbsp;<select name="CbYac" class="campos" id="CbYac"  style="width:250px" onKeyDown="enterxtab(event)"  tabindex="1"><option value=""></option><? ComboTablaRFX("yacimientos","CbYac","Nombre","","",$conn); ?></select></td><td></td><td valign="top"><input name="Chk2"  type="checkbox"  class="check" tabindex="2"  value="1" <? if ($_SESSION['Chk2'] =='1') echo 'checked'; ?>> In Itinere</td><td align="right"><? if (intval($_SESSION['TxtNumero'])!=0){ echo '<input name="CmdI2" type="submit" class="boton02"  value="Informe Ambiental" style="width:115px;height:18px" onClick="document.Formulario.target='."'_self'".'">&nbsp;'; } ?></td></tr>

<tr> <td height="18"  align="right"  >Denunciante:</td><td colspan="2">&nbsp;<select name="CbPersonal" style="width:250px" class="campos"  tabindex="1"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn);  ?></select></td><td></td><td valign="top"></td></tr>

</table>


<table width="850" border="0"  cellspacing="0" class="Tabla TMT">
<tr> <td width="100" height="5"  ></td> <td width="750"></td></tr>
<tr> <td height="18"  align="right"></td><td><input name="ChkC2"  type="checkbox"  class="check"  tabindex="3" value="1" <? if ($_SESSION['ChkC2'] =='1') echo 'checked'; ?>> 1) Incidentes sin lesi&oacute;n con p&eacute;rdida de materiales</td></tr>
<tr> <td height="18"  align="right"></td><td><input name="ChkC1"  type="checkbox"  class="check" tabindex="3" value="1" <? if ($_SESSION['ChkC1'] =='1') echo 'checked'; ?>> 2) Incidentes con lesi&oacute;n sin p&eacute;rdida de dias. Se reintegra al trabajo en menos de 48hs</td>
</tr>
<tr> <td height="18"  align="right"></td><td><input name="ChkC4"  type="checkbox"  class="check" tabindex="3"  value="1" <? if ($_SESSION['ChkC4'] =='1') echo 'checked'; ?>> 3) Incidentes con lesi&oacute;n con p&eacute;rdidas de d&iacute;as, debe ausentarse por mas de 48hs a la actividad laboral</td></tr>
<tr> <td height="18"  align="right"></td><td><input name="ChkC5"  type="checkbox"  class="check" tabindex="3"  value="1" <? if ($_SESSION['ChkC5'] =='1') echo 'checked'; ?>> 4) Incidentes con lesi&oacute;n donde el operador sufre una incapacidad permanente o fatalidad</td></tr>
<tr> <td height="18"  align="right"></td><td><input name="ChkC3"  type="checkbox"  class="check" tabindex="3"  value="1" <? if ($_SESSION['ChkC3'] =='1') echo 'checked'; ?>> 5) Todo derrame no contenidos, sin importar su estado de agregaci&oacute;n</td></tr>
</table>


<table width="850" border="0"  cellspacing="0" class="Tabla TMT">
<tr> <td width="100" height="5"  ></td> <td width="750"></td></tr>
<tr> <td height="18"  align="right" valign="top" >Descripcion:</td><td  valign="top">&nbsp;<textarea name="TxtObs" style="width:710px" rows="7" class="TextBox" onKeyPress="event.cancelBubble=true;"  tabindex="3"><? echo $_SESSION['TxtObs']?></textarea></td></tr>
</table>


<table width="850" border="0"  cellspacing="0" class="Tabla TMT">
<tr> <td width="100" height="5"  ></td> <td width="750"></td></tr>
<tr> <td height="18"  align="right" valign="top" >Da&ntilde;os:</td><td  valign="top">&nbsp;<textarea name="TxtObs1" style="width:710px" rows="2" class="TextBox" onKeyPress="event.cancelBubble=true;"  tabindex="3"><? echo $_SESSION['TxtObs1']?></textarea></td></tr>
<tr> <td height="18"  align="right" valign="top" >Condiciones peligrosas:</td><td  valign="top">&nbsp;<textarea name="TxtObs2" style="width:710px" rows="2" class="TextBox" onKeyPress="event.cancelBubble=true;"  tabindex="3"><? echo $_SESSION['TxtObs2']?></textarea></td></tr>
<tr> <td height="18"  align="right" valign="top" >Actos inseguros:</td><td  valign="top">&nbsp;<textarea name="TxtObs3" style="width:710px" rows="2" class="TextBox" onKeyPress="event.cancelBubble=true;"  tabindex="3"><? echo $_SESSION['TxtObs3']?></textarea></td></tr>
<tr> <td height="18"  align="right" valign="top" >Causa ra&iacute;z:</td><td  valign="top">&nbsp;<textarea name="TxtObs4" style="width:710px" rows="2" class="TextBox" onKeyPress="event.cancelBubble=true;"  tabindex="3"><? echo $_SESSION['TxtObs4']?></textarea></td></tr>
</table>


<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_guardar("850",5,0);
if( intval($_SESSION['TxtNumero'])!=0 ){GLO_exportarform(850,1,0,0,0,0);}
GLO_mensajeerror(); 
?>	