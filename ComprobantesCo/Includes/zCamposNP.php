<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}
?>


<table width="770" border="0" cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="290"></td><td width="100" height="3"  ></td><td width="280"></td> </tr>
<tr><td height="18"  align="right"  >Pedido:</td><td  valign="top" >&nbsp;<input name="TxtNumero" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="<? echo $_SESSION['TxtNumero']; ?>">&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td height="18"  align="right"  >Sector:</td><td>&nbsp;<select name="CbSector" style="width:240px" tabindex="2"  class="campos" id="CbSector" onChange="this.form.submit()"><? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';ComboTablaRFX("sector","CbSector","Nombre","","",$conn);}else{ComboTablaRFROX("sector","CbSector","Nombre","",intval($_SESSION['CbSector']),"",$conn);} ?> </select><label class="MuestraError"> * </label></td></tr>

<tr> <td height="18"  align="right"  >Titulo:</td><td  valign="top">&nbsp;<input name="TxtNombre" type="text"  tabindex="1" class="TextBox" style="width:250px" maxlength="40"  value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Pre-Autorizante:</td><td>&nbsp;<select name="CbPAuto" style="width:240px"  tabindex="2" class="campos"><? if(intval($tienenpipauto)==0){CO_CbAutorizante("CbPAuto",0,1,0,$conn);}else{CO_CbAutorizante("CbPAuto",intval($_SESSION['CbPAuto']),1,1,$conn);} ?></select><label class="MuestraError"> * </label></td></tr>

<tr> <td height="18"  align="right"  >Solicitante:</td><td  valign="top">&nbsp;<select name="CbSoli" style="width:250px" tabindex="1"  class="campos" id="CbSoli" > <? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';ComboPersonalRFX("CbSoli",$conn); }else{ComboPersonalRFROX('CbSoli',intval($_SESSION['CbSoli']),$conn);} ?> </select><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Autorizante:</td><td>&nbsp;<select name="CbAuto" style="width:240px" tabindex="2"  class="campos"><? if(intval($tienenpiauto)==0){CO_CbAutorizante("CbAuto",0,2,0,$conn);}else{CO_CbAutorizante("CbAuto",intval($_SESSION['CbAuto']),2,1,$conn);}  ?></select><label class="MuestraError"> * </label></td></tr>

<tr> <td height="18"  align="right"  >Registr&oacute;:</td><td  valign="top">&nbsp;<input name="TxtPersonal" type="text"  readonly="true"  class="TextBoxRO" style="width:250px" value="<? echo $_SESSION['TxtPersonal']; ?>"  ></td><td height="18"  align="right"  >Prioridad:</td><td  ><input name="OptTipoP"  type="radio" tabindex="2" class="radiob"    value="1"<? if ($_SESSION['OptTipoP'] ==1) echo 'checked'; ?> >Alta   &nbsp;&nbsp;&nbsp;<input name="OptTipoP" tabindex="2" type="radio"  class="radiob"   value="2"<? if ($_SESSION['OptTipoP'] ==2) echo 'checked'; ?> >Media &nbsp;&nbsp;&nbsp;<input name="OptTipoP" tabindex="2" type="radio"  class="radiob"   value="3"<? if ($_SESSION['OptTipoP'] ==3) echo 'checked'; ?> >Baja</td></tr>
</table> 

<table width="770" border="0" cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="290"></td><td width="100" height="3"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="right"  >Punto Pedido:</td><td  valign="top" >&nbsp;<select name="CbPPED" style="width:250px" tabindex="3"  class="campos" id="CbPPED" ><option value=""></option> <? ComboTablaRFX("puntospedido","CbPPED","Nombre","","",$conn); ?> </select></td><td align="right"  >Servicio:</td><td>&nbsp;<select name="CbCentro" style="width:240px" class="campos" tabindex="3"  id="CbCentro" ><option value=""></option> <? CompletarComboServicioRFX("CbCentro",$conn); ?> </select></td></tr>
</table>


<table width="770" border="0" cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="290"></td><td width="100" height="3"  ></td> <td width="280"></td> </tr>
<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad" style="width:250px" tabindex="4"  class="campos" id="CbUnidad" ><option value=""></option> <? GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?> </select></td><td align="right"  >Equipo:</td><td>&nbsp;<select name="CbInstrumento" style="width:240px" tabindex="5" class="campos" id="CbInstrumento" ><option value=""></option> <? GLO_ComboEquipos("CbInstrumento","epparticulos",$conn);  ?> </select></td></tr>

<tr><td height="18"  align="right"  >Personal:</td><td  valign="top" >&nbsp;<select name="CbPersonal" style="width:250px" tabindex="4" class="campos" id="CbPersonal" ><option value=""></option> <? ComboPersonalRFX("CbPersonal",$conn);  ?> </select></td>
<td align="right"  >Sector:</td><td>&nbsp;<select name="CbSector2" style="width:240px" tabindex="5" class="campos" id="CbSector2" ><option value=""></option> <? ComboTablaRFX("sectorm","CbSector2","Nombre","","",$conn);  ?> </select></td></tr>
</table>



<?
GLO_obs(770,100,'Observaciones','TxtObs',3,0,6); 
GLO_guardar("770",7,0);
GLO_Hidden('TxtId',0);GLO_Hidden('TxtUsuario',0);

if(intval($_SESSION['TxtNumero'])!=0){
    GLO_exportarform(770,0,0,1,0,0);
    //adjuntos
    MostrarTablaItems($_SESSION['TxtNumero'],$conn);
    GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"co_npedido_archivos","1000","Comprobantes/","Archivos adjuntos","paperclip",0,0,1);
}

GLO_mensajeerror(); 
?>