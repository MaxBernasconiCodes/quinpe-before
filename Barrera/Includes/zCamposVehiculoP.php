<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//vehiculo propios 
?>



<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Motivo:</td><td >&nbsp;<input name="TxtMotivo" type="text"  tabindex="3" class="TextBox" style="width:250px" maxlength="50"  value="<? echo $_SESSION['TxtMotivo']; ?>"  /></td><td align="right"  >Remito:</td><td>&nbsp;<input name="TxtRto" type="text"  tabindex="3" class="TextBox" style="width:120px" maxlength="13"  value="<? echo $_SESSION['TxtRto']; ?>" onkeyup="this.value=this.value.toUpperCase()" /></td></tr>
</table>

<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="100"></td> <td width="140"></td></tr>
<tr> <td height="18"  align="right"  >Conductor:</td><td >&nbsp;<select name="CbPersonal" style="width:250px" class="campos" tabindex="3" id="CbPersonal" ><option value=""></option><? echo ComboPersonalRFX("CbPersonal",$conn);?></select><label class="MuestraError"> * </label></td><td align="right"  >Temperatura</td><td>&nbsp;<input name="TxtTemp" type="text"  class="TextBox" style="width:50px;<? if (floatval($_SESSION['TxtTemp'])>=37){echo 'color:#f44336;font-weight:bold;';}?>" maxlength="5"  tabindex="3" value="<? echo $_SESSION['TxtTemp']; ?>" onChange="this.value=validarNumero(this.value);"></td><td>Olfato:&nbsp;<select name="CbOlf"  tabindex="3" style="width:50px;<? if (intval($_SESSION['CbOlf'])==2){echo 'color:#f44336;font-weight:bold;';}?>" class="campos" id="CbOlf" ><option value=""></option> <? GLO_CbSINO("CbOlf"); ?> </select></td></tr>
<tr> <td height="18"  align="right"  >Cami&oacute;n:</td><td >&nbsp;<select name="CbUnidad" style="width:250px" tabindex="3"  class="campos" id="CbUnidad" ><option value=""></option><? echo GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?></select></td><td align="right"  >Km Actual:</td><td>&nbsp;<input name="TxtKm" type="text"  class="TextBox" style="text-align:right;width:50px" maxlength="6" tabindex="3" value="<? echo $_SESSION['TxtKm']; ?>" onChange="this.value=validarEntero(this.value);" ></td></tr>
<tr> <td height="18"  align="right"  >Semirremolque:</td><td >&nbsp;<select name="CbUnidad2" style="width:250px" tabindex="3"  class="campos" id="CbUnidad2" ><option value=""></option><? echo GLO_ComboActivoUni("unidades","CbUnidad2","Dominio","","",$conn); ?></select></td><td align="right"  ></td><td>&nbsp;</td></tr>
</table>
