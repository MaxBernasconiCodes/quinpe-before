<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>

<table width="750" border="0"   cellspacing="0" class="Tabla" >

<tr><td  height=3 width="60" ></td><td width="100"></td><td width="120"></td><td width="60"></td><td width="100"></td><td width="80"></td><td width="100"></td><td width="130"></td></tr>

<tr><td  align="right" >Fecha:</td><td>&nbsp;<input name="TxtFechaD"  id="TxtFechaD" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaD']; ?>"   ><?php  calendario("TxtFechaD","../Codigo/","actual"); ?></td><td>al&nbsp;&nbsp;<input name="TxtFechaH"  id="TxtFechaH" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaH']; ?>"   ><?php  calendario("TxtFechaH","../Codigo/","actual"); ?></td><td align="right">Unidad:</td><td>&nbsp;<select name="CbUnidad" style="width:80px" class="campos" id="CbUnidad" ><? echo '<option value=""></option>';GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?> </select></td><td  align="right" >Sector:</td><td>&nbsp;<select name="CbSector" style="width:80px" class="campos" id="CbSector" > <? echo '<option value=""></option>';ComboTablaRFX("sectorm","CbSector","Nombre","","",$conn);?> </select></td><td>Estado:&nbsp;<select name="CbEstado" class="campos" id="CbEstado"  style="width:70px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("pedidosrepord_est","CbEstado","Orden","","",$conn); ?></select></td></tr>

<tr><td  align="right" >Orden:</td><td >&nbsp;<input  name="TxtNroOR" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroOR'];?>" onChange="this.value=validarEntero(this.value);" style="width:65px"></td><td></td><td  align="right" >Equipo:</td><td>&nbsp;<select name="CbInstrumento" class="campos" id="CbInstrumento"  style="width:80px" onKeyDown="enterxtab(event)"><? echo '<option value=""></option>';GLO_ComboEquipos("CbInstrumento","epparticulos",$conn); ?></select></td>

<td  align="right" ></td><td >&nbsp;</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>

</table>

