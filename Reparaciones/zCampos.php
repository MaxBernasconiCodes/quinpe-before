<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>

<table width="750" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="80" height="3"  ></td> <td width="270"></td><td width="110"></td> <td width="150"></td><td width="130"></td> </tr>
<tr> <td height="18"  align="right"  >Solicitud:</td><td  >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"> <? GLO_calendario("TxtFecha1","../Codigo/","actual",1) ?></td><td height="18"  align="right"  >Ingreso sugerido:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFecha2","../Codigo/","actual",1) ?></td><td class="TAR"><input  name="TxtEstadoS" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtEstadoS'];?>" style="width:100px">&nbsp;</td></tr>


<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad" tabindex="1"  style="width:250px" class="campos" id="CbUnidad" ><? if (empty($_SESSION['TxtNumero'])){echo '<option value=""></option>';GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn);}else{GLO_ComboActivoUniRO("unidades","CbUnidad","Dominio","",$_SESSION['CbUnidad'],"",$conn);} ?> </select></td><td align="right"  >Sector:</td><td colspan="2">&nbsp;<select name="CbSector" style="width:250px" class="campos" id="CbSector" > <? if (empty($_SESSION['TxtNumero'])){echo '<option value=""></option>';ComboTablaRFX("sectorm","CbSector","Nombre","","",$conn);}else{ComboTablaRFROX("sectorm","CbSector","Nombre","",intval($_SESSION['CbSector']),"",$conn);} ?> </select></td></tr>

<tr><td height="18"  align="right"  >Equipo:</td><td  valign="top" >&nbsp;<select name="CbInstrumento" class="campos" id="CbInstrumento"  style="width:250px" onKeyDown="enterxtab(event)"><? if (empty($_SESSION['TxtNumero'])){echo '<option value=""></option>';GLO_ComboEquipos("CbInstrumento","epparticulos",$conn);}else{GLO_ComboEquiposRO("CbInstrumento",intval($_SESSION['CbInstrumento']),"epparticulos",$conn);}  ?></select></td><td align="right"  ></td><td colspan="2">&nbsp;</td></tr>
</table>

<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="80" height="3"  ></td> <td width="270"></td><td width="110"></td> <td width="150"></td><td width="130"></td> </tr>
<tr>  <td height="18"  align="right"  >Solicitante:</td><td>&nbsp;<select name="CbPersonal" style="width:250px" class="campos" tabindex="1"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn); ?></select> </td><td height="18"  align="right"  >Tipo:</td><td  colspan="2" >&nbsp;<select name="CbTipo" tabindex="2"  style="width:250px" class="campos" id="CbTipo" ><option value=""></option> <? ComboTablaRFX("pedidosrep_tipo","CbTipo","Id","","",$conn); ?> </select></td></tr>
</table>


<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtOriPage',0);
GLO_Hidden('TxtTieneReq',0);GLO_Hidden('TxtIdEstadoS',0);

if( intval($_SESSION['TxtIdOrden'])==0 and (intval($_SESSION['TxtIdEstadoS'])==0 or intval($_SESSION['TxtIdEstadoS'])==1) ){
GLO_botonesform("750",0,2);}
?>

<table width="750" border="0"  cellspacing="0" class="TablaFondo" >
<td align="right"><? 
//si es pagina modificar, no tiene orden asociada, tiene req cargados y el estado es solicitado
if ( (intval($_SESSION['TxtNumero'])!=0) and (intval($_SESSION['TxtTieneReq'])!=0) and (intval($_SESSION['TxtIdOrden'])==0) and (intval($_SESSION['TxtIdEstadoS'])==1) ){ 
	echo '<input name="CmdAltaOrden" type="submit" class="boton02" value="Alta Orden" onClick="document.Formulario.target='."'_self'".'">';
	echo '&nbsp;<input name="CmdRechazar" type="submit" class="boton05" value="Rechazar" onClick="document.Formulario.target='."'_self'".'">'; 
} 
?></td> </tr>
</table>