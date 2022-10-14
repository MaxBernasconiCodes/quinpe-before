<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

GLO_tituloypath(0,770,'../Clientes.php','CLIENTE','linksalir');
?>


<table width="770" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="330"></td><td width="90" height="3"  ></td><td width="250"></td></tr>
<tr><td height="18"  align="right"  >N&uacute;mero:</td><td  valign="top" >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td><td height="18"  align="right"  >CUIT:</td><td  valign="top" >&nbsp;<input name="TxtCUIT" type="text"  class="TextBox"  maxlength="13"  tabindex="2"  style="width:120px" value="<? echo $_SESSION['TxtCUIT']; ?>" /><label class="MuestraError"> * </label></td>
</tr>
<tr><td height="18"  align="right"  >Raz&oacute;n Social:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text"  tabindex="1" class="TextBox" style="width:270px" maxlength="100"  value="<? echo $_SESSION['TxtNombre']; ?>" onkeyup="this.value=this.value.toUpperCase()" /><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Cond.IVA:</td><td  valign="top" >&nbsp;<select name="CbIva" style="width:120px" class="campos" id="CbIva"  tabindex="2" ><option value=""></option> <? ComboTablaRFX("condicioniva","CbIva","Nombre","","",$conn); ?> </select></td></tr>
<tr><td height="18"  align="right"  >Nombre Fantas&iacute;a:</td><td  valign="top" >&nbsp;<input name="TxtApellido" type="text"  class="TextBox" style="width:270px" maxlength="100"  tabindex="1"  value="<? echo $_SESSION['TxtApellido']; ?>" onkeyup="this.value=this.value.toUpperCase()" /></td><td height="18"  align="right"  >Baja:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",2); ?></td></tr>
</table>


<table width="770" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="330"></td><td width="90" height="3"  ></td><td width="250"></td></tr>
<tr><td  align="right"  >Codigo:</td><td  valign="top" >&nbsp;<input name="TxtCodigo" type="text"  tabindex="3"  class="TextBox" style="text-align:right;width:50px" maxlength="6"  value="<? echo $_SESSION['TxtCodigo']; ?>" onChange="this.value=validarEntero(this.value);" ></td><td  align="right"  >Vendedor:</td><td  valign="top" >&nbsp;<input name="TxtObs2" type="text"  class="TextBox" style="width:200px" tabindex="4"  maxlength="30"  value="<? echo $_SESSION['TxtObs2']; ?>" /></td></tr>
<tr><td  align="right"  >Cta.Contable:</td><td  valign="top" >&nbsp;<select name="CbCC" style="width:200px" class="campos"  tabindex="3" id="CbCC" ><option value=""></option> <? ComboTablaRFX("clientes_ctas","CbCC","Nombre","","",$conn); ?> </select></td><td  align="right"  >Grupo:</td><td  valign="top" >&nbsp;<select name="CbGrupo" style="width:200px" class="campos"  tabindex="4" id="CbGrupo" ><option value=""></option> <? ComboTablaRFX("clientes_grupos","CbGrupo","Nombre","","",$conn); ?> </select></td></tr>
<tr><td  align="right"  >Lista Precios:</td><td  valign="top" >&nbsp;<select name="CbLista" style="width:200px" class="campos"  tabindex="3" id="CbLista" ><option value=""></option> <? ComboTablaRFX("clientes_listas","CbLista","Nombre","","",$conn); ?> </select></td><td  align="right"  >Cond.Vta:</td><td  valign="top" >&nbsp;<select name="CbCV" style="width:200px" class="campos"  tabindex="4" id="CbCV" ><option value=""></option> <? ComboTablaRFX("clientes_cond","CbCV","Nombre","","",$conn); ?> </select></td></tr>
</table>

<table width="770" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="330"></td><td width="90" height="3"  ></td><td width="250"></td></tr>
<tr><td height="18"  align="right"  >Direcci&oacute;n:</td><td  valign="top" >&nbsp;<input name="TxtDireccion" type="text"  class="TextBox" style="width:270px" maxlength="200"  tabindex="5"  value="<? echo $_SESSION['TxtDireccion']; ?>"></td><td height="18"  align="right"  >EMail:</td><td  valign="top" >&nbsp;<input name="TxtEMail" type="text"  class="TextBox" style="width:200px" tabindex="6"  maxlength="50"  value="<? echo $_SESSION['TxtEMail']; ?>" /></td></tr>
<tr><td height="18"  align="right"  >Localidad:</td><td  valign="top" >&nbsp;<select name="CbLocalidad" style="width:270px"  tabindex="5" class="campos" id="CbLocalidad" onChange="this.form.submit()" ><option value=""></option> <? ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn); ?> </select> <? GLO_CmdAddRefresh('Loc',0);?></td><td height="18"  align="right"  >Actividad:</td><td  valign="top" >&nbsp;<select name="CbActividad" style="width:200px" class="campos"  tabindex="6" id="CbActividad" ><option value=""></option> <? ComboTablaRFX("actividades","CbActividad","Nombre","","",$conn); ?> </select> <? GLO_CmdAddRefresh('Act',0);?></td></tr>
<tr><td height="18"  align="right"  >Provincia:</td><td  valign="top" >&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:215px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp;<input name="TxtCP" type="text"  class="TextBoxRO" style="width:50px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"></td><td height="18"  align="right"  ></td><td  valign="top" >&nbsp;</td></tr>
</table>



<? 
GLO_Hidden('TxtId',0);
GLO_obs(770,100,'Observaciones','TxtObs',0,1,7);//ch200
GLO_guardar("770",8,0); 
GLO_mensajeerror();
?> 