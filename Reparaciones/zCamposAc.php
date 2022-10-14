<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,730,'','TAREAS','salir');
?>


<table width="730" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="5"  ></td> <td width="110"></td> <td width="20"></td><td width="140"></td><td width="100" ></td> <td width="260"></td> </tr>
<tr><td height="18"  align="right"  >Fecha:</td><td  valign="top" colspan="3">&nbsp;<? GLO_calendario("TxtFecha","../Codigo/","actual",1) ?></td><td height="18"  align="right"  ></td><td  valign="top" ><input name="ChkISE"  type="checkbox" tabindex="1" value="1" <? if ($_SESSION['ChkISE'] =='1') echo 'checked'; ?>>Ingreso a Servicio Externo</td></tr>
<tr> <td height="18"  align="right" >Observaciones:</td><td  valign="top"  colspan="5">&nbsp;<input name="TxtObs" type="text"  class="TextBox" style="width:590px" maxlength="100"  tabindex="1"  value="<? echo $_SESSION['TxtObs']; ?>"><label class="MuestraError"> * </label></td></tr>
</table>

<table width="730" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="5"  ></td> <td width="110"></td> <td width="20"></td><td width="140"></td><td width="100" height="3"  ></td> <td width="260"></td> </tr>
<tr>  <td height="18"  align="right"  >Hora Inicio:</td><td  valign="top" colspan="3">&nbsp;<input name="TxtHora1"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  value="<? echo $_SESSION['TxtHora1']; ?>" onChange="this.value=validarHora(this.value);" tabindex="1"><label class="MuestraError"> * </label></td><td height="18"  align="right"  ></td>  <td  valign="top" ></td></tr>
<tr>  <td height="18"  align="right"  >Hora Fin:</td><td  valign="top" colspan="3">&nbsp;<input name="TxtHora2"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  value="<? echo $_SESSION['TxtHora2']; ?>" onChange="this.value=validarHora(this.value);" tabindex="1"></td><td height="18"  align="right"  ></td><td  valign="top" >&nbsp;</td></tr>
</table>


<table width="730" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="5"  ></td> <td width="270"></td><td width="100" height="3"  ></td> <td width="260"></td> </tr>
<tr>  <td height="18"  align="right"  >Responsable:</td><td  valign="top">&nbsp;<select name="CbPersonal" style="width:220px" class="campos" tabindex="1"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn); ?></select></td><td  align="right"  >Responsable:</td>  <td  valign="top" >&nbsp;<select name="CbPersonal2" style="width:220px" class="campos" tabindex="1"><option value=""></option><? ComboPersonalRFX("CbPersonal2",$conn); ?></select></td></tr>
<tr>  <td height="18"  align="right"  >Responsable:</td><td  valign="top">&nbsp;<select name="CbPersonal1" style="width:220px" class="campos" tabindex="1"><option value=""></option><? ComboPersonalRFX("CbPersonal1",$conn); ?></select></td><td  align="right"  >Responsable:</td>  <td  valign="top" >&nbsp;<select name="CbPersonal3" style="width:220px" class="campos" tabindex="1"><option value=""></option><? ComboPersonalRFX("CbPersonal3",$conn); ?></select></td></tr>
</table>




<?
if (intval($_SESSION['TxtIdEstadoO'])!=7 and intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
GLO_botonesform("730",0,2);}

//hidden
GLO_Hidden('TxtId',0);GLO_Hidden('TxtIdOrden',0);GLO_Hidden('TxtIdEstadoO',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);

GLO_mensajeerror();
?>