<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,750,'../InspeccionesSMA.php','INSPECCIONES','linksalir'); 
?>



<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="280"></td><td width="90" height="3"  ></td> <td width="100"></td><td width="180"></td></tr>
<tr><td height="18"  align="right"  >Area:</td><td  valign="top" >&nbsp;<select name="CbYac" tabindex="1"  style="width:220px" class="campos" id="CbYac" ><option value=""></option> <? ComboTablaRFX("yacimientos","CbYac","Nombre","","",$conn); ?> </select> <label class="MuestraError"> * </label></td><td align="right">Fecha:</td><td>&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td><input name="TxtHora" id="time" tabindex="1" type="text"  class="TextBox"  style="width:50px" maxlength="5"  value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);"></td></tr>
<tr><td height="18"  align="right"  >Equipo:</td><td  valign="top">&nbsp;<select name="CbCentro" tabindex="1"  style="width:220px" class="campos" id="CbCentro" ><option value=""></option> <? GLO_ComboEquipos("CbCentro","epparticulos",$conn); ?> </select> <label class="MuestraError"> * </label></td><td align="right">Foto:</td><td colspan="2">&nbsp;<input name="TxtFoto" type="hidden" value="<? echo $_SESSION['TxtFoto']; ?>" />&nbsp; <? if (($_SESSION['TxtNumero']!="" and $_SESSION['TxtNumero']!="0") ){echo '<input name="CmdArchivo" type="submit" class="botonexplorar" title="Agregar" value=" " onClick="document.Formulario.target='."'_self'".'">&nbsp;&nbsp;';	}	if ($_SESSION['TxtNumero']!="" and $_SESSION['TxtNumero']!="0" and !(empty($_SESSION['TxtFoto']))){echo '<input name="CmdVerFoto" type="submit" class="botonlupa" title="Ver Foto" value=" " onClick="document.Formulario.target='."'_blank'".'"> &nbsp; '.GLO_FAButton('CmdBorrarFoto','submit','','self','Borrar','trash','iconbtn');}?></td></tr>
</table>


<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	



<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="280"></td><td width="90" height="3"  ></td> <td width="280"></td></tr>
<tr><td height="18"  align="right"  >Operador:</td><td  valign="top" >&nbsp;<select name="CbP1" tabindex="1"  style="width:220px" class="campos" id="CbP1" ><option value=""></option> <? ComboPersonalRFX("CbP1",$conn); ?> </select> </td><td align="right">Ayudante:</td><td>&nbsp;<select name="CbP3" tabindex="1"  style="width:220px" class="campos" id="CbP3" ><option value=""></option> <? ComboPersonalRFX("CbP3",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Chofer:</td><td  valign="top" >&nbsp;<select name="CbP2" tabindex="1"  style="width:220px" class="campos" id="CbP2" ><option value=""></option> <? ComboPersonalRFX("CbP2",$conn); ?> </select> </td><td></td><td></td></tr>
</table>


<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	


<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="370"></td> <td width="280" height="3"  ></td>  </tr>
<tr><td height="18"  align="right"  >HWO/HWOD:</td><td  valign="top" >&nbsp;<select name="CbU1" tabindex="1"  style="width:220px" class="campos" id="CbU1" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU1","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU1" tabindex="1"  style="width:220px" class="campos" id="CbEU1" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU1","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >GV:</td><td  valign="top" >&nbsp;<select name="CbU2" tabindex="1"  style="width:220px" class="campos" id="CbU2" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU2","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU2" tabindex="1"  style="width:220px" class="campos" id="CbEU2" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU2","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >CL:</td><td  valign="top" >&nbsp;<select name="CbU3" tabindex="1"  style="width:220px" class="campos" id="CbU3" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU3","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU3" tabindex="1"  style="width:220px" class="campos" id="CbEU3" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU3","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >UL:</td><td  valign="top" >&nbsp;<select name="CbU4" tabindex="1"  style="width:220px" class="campos" id="CbU4" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU4","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU4" tabindex="1"  style="width:220px" class="campos" id="CbEU4" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU4","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >PC:</td><td  valign="top" >&nbsp;<select name="CbU5" tabindex="1"  style="width:220px" class="campos" id="CbU5" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU5","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU5" tabindex="1"  style="width:220px" class="campos" id="CbEU5" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU5","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >RECUPERADOR:</td><td  valign="top" >&nbsp;<select name="CbU6" tabindex="1"  style="width:220px" class="campos" id="CbU6" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU6","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU6" tabindex="1"  style="width:220px" class="campos" id="CbEU6" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU6","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >BASE/COC:</td><td  valign="top" >&nbsp;<select name="CbU7" tabindex="1"  style="width:220px" class="campos" id="CbU7" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU7","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU7" tabindex="1"  style="width:220px" class="campos" id="CbEU7" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU7","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >OBRADORES/PTP:</td><td  valign="top" >&nbsp;<select name="CbU8" tabindex="1"  style="width:220px" class="campos" id="CbU8" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbU8","Nombre","","",$conn); ?> </select> </td><td >&nbsp;<select name="CbEU8" tabindex="1"  style="width:220px" class="campos" id="CbEU8" ><option value=""></option> <? ComboTablaRFX("inspecciones_est","CbEU8","Nombre","","",$conn); ?> </select></td></tr>
</table>

<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	                    




<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="190" height="3"  ></td><td width="60" ></td> <td width="160"></td><td width="60" ></td> <td width="190" ></td><td width="60" ></td> <td width="30" ></td> </tr>
<tr><td height="18"  align="right"  >EQUIPO (CHEQUEO GENERAL)</td><td align="center" ><input name="ChkI1"  type="checkbox"  value="1" <? if ($_SESSION['ChkI1'] =='1') echo 'checked'; ?>></td><td  align="right"  >EPP</td><td align="center"><input name="ChkI2"  type="checkbox"  value="1" <? if ($_SESSION['ChkI2'] =='1') echo 'checked'; ?>></td><td height="18"  align="right"  >DOCUMENTACION</td><td align="center"><input name="ChkI3"  type="checkbox"  value="1" <? if ($_SESSION['ChkI3'] =='1') echo 'checked'; ?>></td><td></td></tr>
<tr><td height="18"  align="right"  >EXTINTORES</td><td align="center" ><input name="ChkI4"  type="checkbox"  value="1" <? if ($_SESSION['ChkI4'] =='1') echo 'checked'; ?>></td><td  align="right"  >AUDITORIAS</td><td align="center"><input name="ChkI5"  type="checkbox"  value="1" <? if ($_SESSION['ChkI5'] =='1') echo 'checked'; ?>></td><td height="18"  align="right"  >SIMULACROS</td><td align="center"><input name="ChkI6"  type="checkbox"  value="1" <? if ($_SESSION['ChkI6'] =='1') echo 'checked'; ?>></td><td></td></tr>
<tr><td height="18"  align="right"  >INSTALACION ELECTRICA</td><td align="center" ><input name="ChkI7"  type="checkbox"  value="1" <? if ($_SESSION['ChkI7'] =='1') echo 'checked'; ?>></td><td  align="right"  >MEDICIONES</td><td align="center"><input name="ChkI8"  type="checkbox"  value="1" <? if ($_SESSION['ChkI8'] =='1') echo 'checked'; ?>></td><td height="18"  align="right"  >BOTIQUINES</td><td align="center"><input name="ChkI9"  type="checkbox"  value="1" <? if ($_SESSION['ChkI9'] =='1') echo 'checked'; ?>></td><td></td></tr>
<tr><td height="18"  align="right"  > DE MEDICION</td><td align="center" ><input name="ChkI10"  type="checkbox"  value="1" <? if ($_SESSION['ChkI10'] =='1') echo 'checked'; ?>></td><td  align="right"  >CAPACITACION</td><td align="center"><input name="ChkI11"  type="checkbox"  value="1" <? if ($_SESSION['ChkI11'] =='1') echo 'checked'; ?>></td><td height="18"  align="right"  >ELEMENTOS AUXILIARES</td><td align="center"><input name="ChkI12"  type="checkbox"  value="1" <? if ($_SESSION['ChkI12'] =='1') echo 'checked'; ?>></td><td></td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
GLO_obsform(750,100,'Detalle','TxtObs',2,0);  
GLO_botonesform("750",0,2);
GLO_mensajeerror();
?>