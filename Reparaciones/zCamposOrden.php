<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


?>



<table width="750" border="0"  cellspacing="0" class="Tabla" >

<tr><td width="100" height="3"  ></td> <td width="270"></td><td width="110"></td> <td width="150"></td><td width="110"></td> </tr>

<tr> <td height="18"  align="right"  >Orden:</td><td  >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"> <? GLO_calendario("TxtFecha1","../Codigo/","actual",1) ?></td><td height="18"  align="right"  >Estado:</td><td  valign="top"  colspan="2">&nbsp;<input  name="TxtEstadoO" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtEstadoO'];?>" style="width:230px"></td></tr>

<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad" tabindex="1"  style="width:250px" class="campos" id="CbUnidad" ><? if (empty($_SESSION['TxtNumero'])){echo '<option value=""></option>';GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn);}else{GLO_ComboActivoUniRO("unidades","CbUnidad","Dominio","",$_SESSION['CbUnidad'],"",$conn);} ?> </select></td><td align="right"  >Sector:</td><td colspan="2">&nbsp;<select name="CbSector" style="width:230px" class="campos" id="CbSector" > <? if (empty($_SESSION['TxtNumero'])){echo '<option value=""></option>';ComboTablaRFX("sectorm","CbSector","Nombre","","",$conn);}else{ComboTablaRFROX("sectorm","CbSector","Nombre","",intval($_SESSION['CbSector']),"",$conn);} ?> </select></td></tr>

<tr><td height="18"  align="right"  >Equipo:</td><td  valign="top" >&nbsp;<select name="CbInstrumento" class="campos" id="CbInstrumento"  style="width:250px" onKeyDown="enterxtab(event)"><? if (empty($_SESSION['TxtNumero'])){echo '<option value=""></option>';GLO_ComboEquipos("CbInstrumento","epparticulos",$conn);}else{GLO_ComboEquiposRO("CbInstrumento",intval($_SESSION['CbInstrumento']),"epparticulos",$conn);}  ?></select> <? if(intval($_SESSION['CbInstrumento'])!=0){echo GLO_FAButton('CmdVerEq','submit','','blank','Ver Equipo','lupa','iconbtn');} ?></td><td align="right"  ></td><td colspan="2">&nbsp;</td></tr>

</table>





<?

GLO_Hidden('TxtId',0);GLO_Hidden('TxtOriPage',0);GLO_Hidden('CbSoli1',0);

GLO_Hidden('TxtIdEstadoS',0);GLO_Hidden('TxtIdEstadoO',0);GLO_Hidden('TxtIdAccCumpl',0);

?>