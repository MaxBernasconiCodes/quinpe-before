<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);

GLO_tituloypath(0,750,'../Personal.php','PERSONAL','linksalir');
?>

<!-- datos personales y nacimiento -->
<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="90" height="3"  ></td>  <td width="290"></td><td width="320"></td><td width="50"></td></tr>
<tr><td height="18"  align="right"  >Legajo:</td><td >&nbsp;<input  name="TxtLegajo" type="text"   tabindex="1" class="TextBox"  maxlength="6"   value="<? echo $_SESSION['TxtLegajo'];?>" style="text-align:right;width:50px;" onchange="this.value=validarEntero(this.value);" /> <input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"><label class="MuestraError"> * </label></td><td rowspan="6" valign="middle" align="right">
<? if($_SESSION['TxtFoto']!=''){echo '<img src="'.'../Codigo/OpenImage.php?id='.'../Archivos/Fotos/'.$_SESSION['TxtFoto'].'" style="height:110px;width:auto;border-radius:4px;">';}?></td><td align="right">
<? 
//foto solo modifica rrhh
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){

    if (intval($_SESSION['TxtNumero'])!=0){echo '&nbsp;'.GLO_FAButton('CmdArchivo','submit','','self','Explorar','folder','iconbtn').'&nbsp;&nbsp;';}
}
?></td></tr>

<tr><td height="18"  align="right"  >Apellido:</td><td >&nbsp;<input name="TxtApellido" type="text"  tabindex="1" class="TextBox" style="width:240px" maxlength="30"  value="<? echo $_SESSION['TxtApellido']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td align="right">
<? 
if (intval($_SESSION['TxtNumero'])!=0 and !(empty($_SESSION['TxtFoto']))){echo GLO_FAButton('CmdVerFoto','submit','','blank','Ver','lupa','iconbtn').'&nbsp;&nbsp;';} 
?>
</td></tr>

<tr><td height="18"  align="right"  >Nombre:</td><td >&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:240px" maxlength="30"  tabindex="1" value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td align="right">
<? 
if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){
  if (intval($_SESSION['TxtNumero'])!=0 and !(empty($_SESSION['TxtFoto']))){echo ' &nbsp; '.GLO_FAButton('CmdBorrarFoto','submit','','self','Borrar','trash','iconbtn').'&nbsp;&nbsp;';}
}
?>
</td></tr>

<tr><td height="18"  align="right"  >Documento:</td><td >&nbsp;<select name="CbDocumento"  class="campos" id="CbDocumento" style="width:50px"><?  ComboDocumento();?></select> <input name="TxtDoc" type="text"  tabindex="1" class="TextBox"  maxlength="13"  style="width:90px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtDoc']; ?>" /><label class="MuestraError"> * </label><input name="ChkExtranjero"  type="checkbox" tabindex="1"  class="check"  value="1" <? if ($_SESSION['ChkExtranjero'] =='1') echo 'checked'; ?>> Extranjero</td><td></td></tr>
<tr><td height="18"  align="right"  >CUIT/CUIL:</td><td >&nbsp;<select name="CbCUIT"  class="campos" id="CbCUIT" style="width:50px"><?  ComboCUIT();?></select> <input name="TxtCUIT" type="text"  tabindex="1" class="TextBox"  maxlength="13"  style="width:90px" value="<? echo $_SESSION['TxtCUIT']; ?>" /></td><td></td></tr>
<tr><td height="18"  align="right"  >Nro Tramite DNI:</td><td >&nbsp;<input name="TxtDNITramite" type="text"  tabindex="1" class="TextBox"  maxlength="15"  style="width:143px" value="<? echo $_SESSION['TxtDNITramite']; ?>" /></td><td></td></tr>
</table>



<table width="750" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="90" height="3"  ></td><td width="100"></td><td width="190"></td><td width="100"  ></td><td width="270"></td></tr>
<tr><td height="18"  align="right"  >Fecha Nac.:</td><td >&nbsp;<? GLO_calendario("TxtFecha","../Codigo/","nac",1) ?><td>&nbsp;<input name="TxtEdad" type="text"  readonly="true"  class="TextBoxRO"  style="width:45px"  value="<? echo $_SESSION['TxtEdad']; ?>" >&nbsp; Sexo:<input name="OptTipoG"  type="radio"  class="radiob"  tabindex="1"   value="M"<? if ($_SESSION['OptTipoG'] =='M') echo 'checked'; ?> >M <input name="OptTipoG"  type="radio"  class="radiob"  tabindex="1"    value="F"<? if ($_SESSION['OptTipoG'] =='F') echo 'checked'; ?> >F</td><td height="18"  align="right"  >Estado Civil:</td><td >&nbsp;<select name="CbEC"  tabindex="2" style="width:120px" class="campos" id="CbEC"  ><option value=""></option> <?  ComboEstadoCivil(); ?> </select>&nbsp;&nbsp;Carga:&nbsp;<input name="TxtCarga" type="text"  class="TextBox" maxlength="2"  tabindex="2"  value="<? echo $_SESSION['TxtCarga']; ?>" onchange="this.value=validarEntero(this.value);" style="text-align:right;width:30px"></td></tr>
<tr><td height="18"  align="right"  >Lugar Nac.:</td><td  colspan="2">&nbsp;<input name="TxtLN" type="text"  tabindex="1"  class="TextBox" style="width:240px" maxlength="50"  value="<? echo $_SESSION['TxtLN']; ?>"  ></td><td height="18"  align="right"  >Estudios:</td><td >&nbsp;<select name="CbEstudios" style="width:240px"  tabindex="2" class="campos" id="CbEstudios" ><option value=""></option> <? ComboTablaRFX("estudios","CbEstudios","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Nacionalidad:</td><td  colspan="2">&nbsp;<input name="TxtNacionalidad" type="text"  tabindex="1"  class="TextBox" style="width:240px" maxlength="20"  value="<? echo $_SESSION['TxtNacionalidad']; ?>"></td><td height="18"  align="right"  >EMail:</td><td >&nbsp;<input name="TxtEMail" type="text"  class="TextBox" tabindex="2"  style="width:240px" maxlength="50"  value="<? echo $_SESSION['TxtEMail']; ?>"></td></tr>
</table>




<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="90" height="3"  ></td>  <td width="290"></td><td width="100"  ></td><td width="270"></td></tr>
<tr><td height="18"  align="right"  >Direcci&oacute;n Real:</td><td >&nbsp;<input name="TxtDireccion"  tabindex="3"  type="text"  class="TextBox" style="width:240px" maxlength="200"  value="<? echo $_SESSION['TxtDireccion']; ?>"></td><td height="18"  align="right"  >Direcci&oacute;n Legal:</td><td >&nbsp;<input name="TxtDireccionL" type="text"  tabindex="4"  class="TextBox" style="width:240px" maxlength="200"  value="<? echo $_SESSION['TxtDireccionL']; ?>"></td></tr>
<tr> <td height="18"  align="right"  >Localidad:</td><td >&nbsp;<select name="CbLocalidad" style="width:240px" class="campos" id="CbLocalidad"  tabindex="3" onChange="this.form.submit()" ><option value=""></option> <? $Flag=false; ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn);$Flag=true; ?> </select></td><td height="18"  align="right"  >Localidad:</td><td >&nbsp;<select name="CbLocalidadL" style="width:240px" class="campos"  tabindex="4" id="CbLocalidad" onChange="this.form.submit()" ><option value=""></option> <? $Flag=false; ComboTablaRFX("localidades","CbLocalidadL","Nombre","","",$conn);$Flag=true; ?> </select></td>
</tr>
<tr> <td height="18"  align="right"  >Provincia:</td><td >&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:185px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp;<input name="TxtCP" type="text"  class="TextBoxRO" style="width:50px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"></td><td height="18"  align="right"  >Provincia:</td><td >&nbsp;<input name="TxtProvinciaL" type="text"  class="TextBoxRO" style="width:185px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvinciaL']; ?>">&nbsp;<input name="TxtCPL" type="text"  class="TextBoxRO" style="width:50px"  readonly="true" value="<? echo $_SESSION['TxtCPL']; ?>"></td></tr>
</table> 

<table width="750" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="90" height="3"  ></td> <td width="130"></td><td width="160"></td><td width="100" height="3"  ></td> <td width="270"></td> </tr>

<tr> <td height="18"  align="right"  >Raz&oacute;n Social:</td><td  colspan="2">&nbsp;<select name="CbRS" style="width:240px" class="campos" tabindex="5"  id="CbRS" ><option value=""></option> <? ComboTablaRFX("parametrosrs","CbRS","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >ART:</td><td >&nbsp;<select name="CbART" style="width:240px" tabindex="6"  class="campos" id="CbART" ><option value=""></option> <? ComboTablaRFX("art","CbART","Nombre","","",$conn); ?> </select></td></tr>

<tr> <td height="18"  align="right"  >Funcion:</td><td colspan="2">&nbsp;<select name="TxtFuncion"  tabindex="5" style="width:240px" class="campos" id="TxtFuncion" ><option value=""></option> <? ComboTablaRFX("funcion","TxtFuncion","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Obra Social:</td><td >&nbsp;<input name="TxtOSocial" type="text"  tabindex="6"  class="TextBox" style="width:240px" maxlength="30"  value="<? echo $_SESSION['TxtOSocial']; ?>"></td></tr>

<tr> <td height="18"  align="right"  >Categoria:</td><td colspan="2">&nbsp;<select name="CbCateg"  tabindex="5" style="width:240px" class="campos" id="CbCateg" ><option value=""></option> <? ComboTablaRFX("categorias","CbCateg","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Categoria:</td><td >&nbsp;<input name="TxtCatOS" type="text"  tabindex="6"  class="TextBox" style="width:240px" maxlength="30"  value="<? echo $_SESSION['TxtCatOS']; ?>"></td></tr>

<tr> <td height="18"  align="right"  >Contratacion:</td><td>&nbsp;<select name="CbContrato"  tabindex="5" style="width:100px" class="campos" id="CbContrato" ><option value=""></option> <? PE_CbContrato("CbContrato"); ?> </select></td><td >Fin:&nbsp;&nbsp;&nbsp;<? GLO_calendario("TxtFechaF","../Codigo/","actual",5) ?></td><td height="18"  align="right"  >Convenio:</td><td >&nbsp;<input name="TxtConv" type="text"  tabindex="6"  class="TextBox" style="width:240px" maxlength="30"  value="<? echo $_SESSION['TxtConv']; ?>"></td></tr>

<tr><td height="18"  align="right"  >Fecha Alta:</td><td >&nbsp;<input name="TxtFechaA" id="TxtFechaA"  tabindex="5"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   ><? calendario("TxtFechaA","../Codigo/","actual") ?></td><td >Baja:&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",5) ?></td><td height="18"  align="right"  ></td><td >&nbsp;</td></tr>
</table> 



<table width="750" border="0"   cellspacing="0" class="Tabla TMT" >
<tr><td width="90" height="3"  ></td> <td width="130"></td><td width="160"></td><td width="100" height="3"  ></td> <td width="270"></td> </tr>
<tr> <td height="18"  align="right"  >Sector:</td><td colspan="2">&nbsp;<select name="CbSector"  tabindex="7" style="width:240px" class="campos" id="CbSector" ><option value=""></option> <? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?> </select></td><td height="18"  align="right"  >Turno:</td><td >&nbsp;<select name="TxtTurno"  tabindex="8" style="width:240px" class="campos" id="TxtTurno" ><option value=""></option> <? ComboTablaRFX("turnos","TxtTurno","Nombre","","",$conn); ?> </select></td></tr>

</table> 


<? 
GLO_obs(750,90,'Observaciones','TxtObs',0,1,9);
GLO_Hidden('TxtFoto',0);GLO_Hidden('TxtId',0);
?>


<!-- datos obs -->
<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td height="3"></td></tr>
<tr> <td width="275"></td><td width="300"  align="center" valign="middle" ><? 
echo '<input name="CmdAceptar" type="submit"  tabindex="10" class="boton"  value="Guardar" onClick="document.Formulario.target='."'_self'".'">&nbsp;';?> </td><td width="275" align="right">
<? 
if (($_SESSION['TxtNumero']!="" and $_SESSION['TxtNumero']!="0") ){ 
    //legajo solo ve rrhh
    if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){
        echo '<input name="CmdRankVial" type="submit" class="boton02"  value="Ranking Vial" onClick="document.Formulario.target='."'_self'".'">&nbsp;';
    }
} 
?></td></tr>
</table>


