<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>


<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="90" height="3"  ></td> <td width="260"></td><td width="100"></td> <td width="250"></td> </tr>
<tr><td height="18"  align="right"  >Retira:</td><td  valign="top">&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal"  style="width:200px" tabindex="3"  onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select></td><td align="right"  >Equipo:</td><td>&nbsp;<select name="CbInstrumento" style="width:200px" tabindex="3" class="campos" id="CbInstrumento" ><option value=""></option> <? GLO_ComboEquipos("CbInstrumento","epparticulos",$conn);  ?> </select></td></tr>

<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad" style="width:200px" tabindex="3"  class="campos" id="CbUnidad" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?> </select></td>
<td align="right"  >Sector:</td><td>&nbsp;<select name="CbSector2" style="width:200px" tabindex="3" class="campos" id="CbSector2" ><option value=""></option> <? ComboTablaRFX("sectorm","CbSector2","Nombre","","",$conn);  ?> </select></td></tr>
</table> 
