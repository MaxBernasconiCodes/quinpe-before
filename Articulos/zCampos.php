<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



?>

<table width="720" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> <td width="60"></td><td width="160"></td></tr>
<tr><td height="18"  align="right"  >Descripci&oacute;n:</td><td colspan="2">&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:350px" maxlength="50"   tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"><label class="MuestraError"> * </label></td><td><input name="ChkReq"  tabindex="1"  class="check" type="checkbox"  value="1" <? if ($_SESSION['ChkReq'] =='1') echo 'checked'; ?>> <? GLO_CheckColor('Modifica Stock',$_SESSION['ChkReq'],0);?> </td></tr>
</table>


<table width="720" border="0" cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="260"></td> <td width="100"></td><td width="260"></td></tr>
<tr><td align="right"  >Tipo:</td><td >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  tabindex="1"  style="width:230px" onKeyDown="enterxtab(event)"><option value=""></option><? ART_CbTipo('CbTipo'); ?></select><label class="MuestraError"> * </label></td><td align="right">Marca:</td><td>&nbsp;<select name="CbMarca" class="campos" id="CbMarca"  tabindex="2"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("marcas","CbMarca","Nombre","","",$conn); ?></select> <? if($ver!=1){GLO_CmdAddRefresh('Mar',0);} ?></td></tr>
<tr><td align="right"  >&nbsp;Rubro:</td><td  >&nbsp;<select name="CbRubro" class="campos" id="CbRubro"  tabindex="1"  style="width:230px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("rubros","CbRubro","Nombre","","",$conn); ?></select></td><td align="right">Modelo:</td><td>&nbsp;<input name="TxtModelo" type="text"  tabindex="2"  class="TextBox" style="width:200px" maxlength="30"  value="<? echo $_SESSION['TxtModelo']; ?>" ></td></tr>
<tr><td align="right"  >Unidad de medida:</td><td  >&nbsp;<select name="CbUnidad" class="campos" id="CbUnidad"  tabindex="1"  style="width:230px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("unidadesmedida","CbUnidad","Nombre","","",$conn); ?></select><label class="MuestraError"> * </label></td><td align="right">NSE:</td><td>&nbsp;<input name="TxtNSE" type="text"  tabindex="2"  class="TextBox" style="width:200px" maxlength="30"  value="<? echo $_SESSION['TxtNSE']; ?>" ></td></tr>
</table>

<table width="720" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="260"></td> <td width="100"></td><td width="260"></td></tr>
<tr><td height="18"  align="right"  >TAG:</td><td>&nbsp;<input name="TxtTAG" type="text"  class="TextBox" style="width:220px" maxlength="20"  tabindex="3"  value="<? echo $_SESSION['TxtTAG']; ?>"></td><td height="18"  align="right"  >Rango Min:</td><td >&nbsp; <input name="TxtRango1" type="text"  class="TextBox" style="width:200px" maxlength="20"  tabindex="4"  value="<? echo $_SESSION['TxtRango1']; ?>"> </td></tr>
<tr><td height="18"  align="right"  >Verificaci&oacute;n:</td><td>&nbsp;<select name="CbTipoC" tabindex="3"  style="width:100px" class="campos" id="CbTipoC" ><option value=""></option> <? ComboVerifInstrumentos("CbTipoC"); ?> </select></td><td height="18"  align="right"  >Rango Max:</td><td >&nbsp; <input name="TxtRango2" type="text"  class="TextBox" style="width:200px" maxlength="20"  tabindex="4"  value="<? echo $_SESSION['TxtRango2']; ?>"> </td></tr>
<tr><td height="18"  align="right"  >Unidad Medici&oacute;n:</td><td>&nbsp;<select name="CbUnM" tabindex="3"  style="width:100px" class="campos" id="CbUnM" ><option value=""></option> <? ComboUnidMedInstrumentos("CbUnM"); ?> </select></td><td height="18"  align="right"  >Imagen:</td><td >&nbsp;<? GLO_Hidden('TxtFoto',0);
if (intval($_SESSION['TxtNumero'])!=0 and $ver!=1){echo GLO_FAButton('CmdArchivo','submit','','self','Explorar','folder','iconbtn').'&nbsp;&nbsp;';}
if (intval($_SESSION['TxtNumero'])!=0  and $ver!=1 and !(empty($_SESSION['TxtFoto']))){echo GLO_FAButton('CmdVerFoto','submit','','blank','Ver','lupa','iconbtn').' &nbsp; '.GLO_FAButton('CmdBorrarFoto','submit','','self','Borrar','trash','iconbtn');}
?>    
</td></tr>
</table>


<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="120"></td> <td width="100"></td><td width="120"></td><td width="110"></td><td width="170"></td></tr>
<tr><td height="18"  align="right"  >Fecha Vto:</td><td  >&nbsp;<? GLO_calendariovto("TxtFechaV","../Codigo/","actual",6) ?></td><td   align="right"  >Fecha Baja:</td><td  >&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",6) ?></td><td align="right"> Frecuencia EPP:</td><td  >&nbsp;<input name="TxtFrec" type="text"  tabindex="6"  class="TextBox" style="width:30px;text-align:right;" maxlength="6"  value="<? echo $_SESSION['TxtFrec']; ?>" onChange="this.value=validarEntero(this.value);" ><span class="comentario"> en d&iacute;as</span>  </td></tr>
</table>



<?
GLO_obsform(720,100,'Observaciones','TxtObs',3,0); 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
?>