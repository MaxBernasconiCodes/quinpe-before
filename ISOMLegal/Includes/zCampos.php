<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

function ComboEstadoAuditoria(){
$combo="";
if( "1" == $_SESSION['CbEstado']) { $combo .= " <option value="."'1'"." selected='selected'>"."SI"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."SI"."</option>\n";}
if( "2" == $_SESSION['CbEstado']) { $combo .= " <option value="."'2'"." selected='selected'>"."NO"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."NO"."</option>\n";}
if( "3" == $_SESSION['CbEstado']) { $combo .= " <option value="."'3'"." selected='selected'>"."N/A"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."N/A"."</option>\n";}
echo $combo;
}

GLO_tituloypath(0,720,'../ISO_MLegal.php','MATRIZ DE REQUISITOS LEGALES','linksalir');
?>

<table width="720" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="5"  ></td> <td width="320"></td><td width="100" height="3"  ></td> <td width="100"></td><td width="100"></td> </tr>
<tr><td height="18"  align="right"  >Numero:</td><td  valign="top" >&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>"></td><td height="18"  align="right"  >Fecha:</td>
<td  valign="top" >&nbsp;<input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:60px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   ><? calendario("TxtFechaA","../Codigo/","actual") ?></td><td><label class="MuestraError"> * </label> </td></tr>
<tr> <td height="18"  align="right"  >Alcance:</td><td  valign="top">&nbsp;<select name="CbTipo" style="width:250px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("iso_matriz_a","CbTipo","Id","","",$conn); ?> </select><label class="MuestraError"> * </label></td>
<td height="18"  align="right"  >Vencimiento:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtFechaB" id="TxtFechaB"  type="text" class="TextBox"  style="width:60px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"   ><? calendario("TxtFechaB","../Codigo/","actual") ?></td></tr>
<tr> <td height="18"  align="right"  >Periodicidad:</td><td  valign="top">&nbsp;<select name="CbPer" style="width:250px" class="campos" id="CbPer" ><option value=""></option> <? ComboTablaRFX("iso_matriz_p","CbPer","Nombre","","",$conn); ?> </select></td>
<td height="18"  align="right"  >Evaluaci&oacute;n:</td><td  valign="top" >&nbsp;<input name="TxtFechaC" id="TxtFechaC"  type="text" class="TextBox"  style="width:60px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaC']; ?>"   ><? calendario("TxtFechaC","../Codigo/","actual") ?></td><td><select name="CbEstado" class="campos" id="CbEstado"  style="width:60px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboEstadoAuditoria(); ?></select></td></tr>
<tr> <td height="18"  align="right"  >Archivo:</td><td  valign="top">&nbsp;<? //examinar: (si es perf.coord/admin )
if ( ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==4 or $_SESSION["IdPerfilUser"]==3  or $_SESSION["IdPerfilUser"]==9 or $_SESSION["IdPerfilUser"]==14) and ( intval($_SESSION['TxtNumero'])!=0 ) ){
echo '<input name="CmdArchivo" type="submit" class="botonexplorar" title="Agregar" value=" " onClick="document.Formulario.target='."'_self'".'">';}
//ver archivo: 
 if ( !(empty($_SESSION['TxtArchivo'])) and ( intval($_SESSION['TxtNumero'])!=0) ){echo ' <input name="CmdVerFile" type="submit" class="botonlupa" title="Ver" value=" " onClick="document.Formulario.target='."'_blank'".'">';} 
 ?> </td><td height="18"  align="right"  ></td><td  valign="top" colspan="2">&nbsp;  </td></tr>
</table> 


<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="5"  ></td> <td width="620"></td></tr>
<tr><td height="18"  align="right"  >Requisitos:</td><td  valign="top">&nbsp;<input name="TxtReq" type="text" class="TextBox" style="width:600px" maxlength="100"  value="<? echo $_SESSION['TxtReq']; ?>"></td></tr>
<tr><td height="18"  align="right"  >Identificaci&oacute;n:</td><td  valign="top">&nbsp;<input name="TxtIdent" type="text" class="TextBox" style="width:600px" maxlength="200"  value="<? echo $_SESSION['TxtIdent']; ?>"></td></tr>
<tr> <td height="18"  align="right" valign="top">Detalle:</td><td  valign="top" colspan="4">&nbsp;<textarea name="TxtObs" style="width:600px" rows="3" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObs']; ?></textarea> </td></tr>
</table>

<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="5"  ></td> <td width="620"></td></tr>
<tr><td height="18"  align="right"  >Responsables:</td><td  valign="top">&nbsp;<input name="TxtResp" type="text" class="TextBox" style="width:600px" maxlength="100"  value="<? echo $_SESSION['TxtResp']; ?>"></td></tr>
<tr> <td height="18"  align="right" valign="top">Verificaci&oacute;n:</td><td  valign="top" colspan="4">&nbsp;<textarea name="TxtVerif" style="width:600px" rows="3" class="TextBox" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtVerif']; ?></textarea> </td></tr>
</table>



<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtArchivo',0);
GLO_botonesform("720",0,2);
GLO_mensajeerror();
?>