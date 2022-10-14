<? 
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,770,'../Proveedores.php','PROVEEDORES','linksalir');
?>


<table width="770" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="330"></td><td width="90" height="3"  ></td><td width="250"></td></tr>
<tr><td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top" >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"> <input name="OptTipo"  type="radio"  class="radiob"  tabindex="1"  value="1"<? if ($_SESSION['OptTipo'] ==1) echo 'checked'; ?> >Interno   &nbsp;&nbsp;&nbsp;<input name="OptTipo"  type="radio"  class="radiob" tabindex="1"  value="0"<? if ($_SESSION['OptTipo'] ==0) echo 'checked'; ?> >Externo</td><td height="18"  align="right"  >CUIT:</td><td  valign="top" >&nbsp;<input name="TxtCUIT" type="text"  class="TextBox"  maxlength="13"  tabindex="2"  style="width:120px" value="<? echo $_SESSION['TxtCUIT']; ?>" /><label class="MuestraError"> * </label></td>
</tr>
<tr><td height="18"  align="right"  >Raz&oacute;n Social:</td><td  valign="top" >&nbsp;<input name="TxtApellido" type="text"  tabindex="1" class="TextBox" style="width:270px" maxlength="50"  value="<? echo $_SESSION['TxtApellido']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Cond.IVA:</td><td  valign="top" >&nbsp;<select name="CbIva" style="width:120px" class="campos" id="CbIva"  tabindex="2" ><option value=""></option> <? ComboTablaRFX("condicioniva","CbIva","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Nombre Fantas&iacute;a:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text"  class="TextBox" style="width:270px" maxlength="50"  tabindex="1"  value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()" /></td><td height="18"  align="right"  >Baja:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",2); ?></td></tr>
</table>




<table width="770" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="330"></td><td width="90" height="3"  ></td><td width="250"></td></tr>
<tr><td height="18"  align="right"  >Direcci&oacute;n:</td><td  valign="top" >&nbsp;<input name="TxtDireccion" type="text"  class="TextBox" style="width:270px" maxlength="200"  tabindex="3"  value="<? echo $_SESSION['TxtDireccion']; ?>"></td><td height="18"  align="right"  >EMail:</td><td  valign="top" >&nbsp;<input name="TxtEMail" type="text"  class="TextBox" style="width:200px" tabindex="4"  maxlength="50"  value="<? echo $_SESSION['TxtEMail']; ?>" /></td></tr>
<tr><td height="18"  align="right"  >Localidad:</td><td  valign="top" >&nbsp;<select name="CbLocalidad" style="width:270px"  tabindex="3" class="campos" id="CbLocalidad" onChange="this.form.submit()" ><option value=""></option> <? ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn); ?> </select> <? GLO_CmdAddRefresh('Loc',0);?></td><td height="18"  align="right"  >P&aacute;gina WEB:</td><td  valign="top" >&nbsp;<input name="TxtPagina" type="text"  class="TextBox" style="width:200px" tabindex="4"  maxlength="30"  value="<? echo $_SESSION['TxtPagina']; ?>" /></td></tr>
<tr><td height="18"  align="right"  >Provincia:</td><td  valign="top" >&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:215px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp;<input name="TxtCP" type="text"  class="TextBoxRO" style="width:50px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"></td><td height="18"  align="right"  >Actividad:</td><td>&nbsp;<select name="CbActividad" style="width:200px" class="campos"  tabindex="4" id="CbActividad" ><option value=""></option> <? ComboTablaRFX("actividades","CbActividad","Nombre","","",$conn); ?> </select> <? GLO_CmdAddRefresh('Act',0);?></td></tr>
</table>

<table width="770" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="330"></td><td width="90" height="3"  ></td><td width="250"></td></tr>
<tr><td height="18"  align="right"  >Contacto:</td><td>&nbsp;<input name="TxtContacto" type="text"  class="TextBox" style="width:270px" tabindex="5"  maxlength="30"  value="<? echo $_SESSION['TxtContacto']; ?>" /></td><td height="18"  align="right"  ></td><td><input name="ChkC1"  type="checkbox"  class="check" tabindex="6"  value="1" <? if ($_SESSION['ChkC1'] =='1') echo 'checked'; ?>> Proveedor Cr&iacute;tico</td></tr>
<tr><td height="18"  align="right"  >Cargo:</td><td>&nbsp;<input name="TxtCargo" type="text"  class="TextBox" style="width:270px" tabindex="5"  maxlength="30"  value="<? echo $_SESSION['TxtCargo']; ?>" /></td><td height="18"  align="right"  ></td><td><input name="ChkC2"  type="checkbox"  class="check" tabindex="6"  value="1" <? if ($_SESSION['ChkC2'] =='1') echo 'checked'; ?>> Proveedor a Evaluar</td></tr>

</table>


<? 
GLO_Hidden('TxtId',0);
GLO_obs(770,100,'Observaciones','TxtObs',0,1,7);//ch200
GLO_guardar("770",8,0); 
GLO_mensajeerror();
?> 