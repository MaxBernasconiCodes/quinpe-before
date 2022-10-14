<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//modificar propios persona
?>


<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="300"></td><td width="110"></td> <td width="100"></td> <td width="140"></td></tr>
<tr> <td height="18"  align="right"  >Persona:</td><td >&nbsp;<select name="CbPersonal" style="width:250px" class="campos" tabindex="3" id="CbPersonal" ><option value=""></option><? echo ComboPersonalRFX("CbPersonal",$conn);?></select><label class="MuestraError"> * </label></td><td align="right"  >Temperatura</td><td>&nbsp;<input name="TxtTemp" type="text"  class="TextBox" style="width:50px;<? if (floatval($_SESSION['TxtTemp'])>=37){echo 'color:#f44336;font-weight:bold;';}?>" maxlength="5"  tabindex="3" value="<? echo $_SESSION['TxtTemp']; ?>" onChange="this.value=validarNumero(this.value);"></td><td>Olfato:&nbsp;<select name="CbOlf"  tabindex="3" style="width:50px;<? if (intval($_SESSION['CbOlf'])==2){echo 'color:#f44336;font-weight:bold;';}?>" class="campos" id="CbOlf" ><option value=""></option> <? GLO_CbSINO("CbOlf"); ?> </select></td></tr>
</table>
