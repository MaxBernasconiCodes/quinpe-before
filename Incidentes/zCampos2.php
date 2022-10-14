<?//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


GLO_tituloypath(0,840,'','AMBIENTE/MATERIAL','salir');
GLO_mensajeerror(); 
?>


<table width="840" border="0"  cellspacing="0"><tr> <td  class="encabezado">COMPLETAR EN CASO DE ACCIDENTE VEHICULAR</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="80"></td><td width="130"></td><td width="80"></td><td width="150"></td></tr>
<tr> <td colspan="2" class="TBold">&nbsp;Datos del Tercero</td><td align="right"  >Nro.Denuncia:</td><td>&nbsp;<input name="TxtNro" type="text"  tabindex="1" class="TextBox"  maxlength="10"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtNro']; ?>" /></td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Apellido y Nombre:</td><td>&nbsp;<input name="TxtNombre2" type="text"  tabindex="1" class="TextBox"  maxlength="50"  style="width:270px" value="<? echo $_SESSION['TxtNombre2']; ?>" ></td><td align="right"  >Telefono:</td><td colspan="3">&nbsp;<input name="TxtTel" type="text"  tabindex="1" class="TextBox"  maxlength="30"  style="width:330px" value="<? echo $_SESSION['TxtTel']; ?>" ></td></tr>
<tr> <td align="right"  >Nro.Licencia:</td><td>&nbsp;<input name="TxtLic2" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtLic2']; ?>" /></td><td align="right"  >Vencimiento:</td><td>&nbsp;<? GLO_calendario("TxtVto2","../Codigo/","actual",1) ?></td><td align="right"  >Categoria:</td><td>&nbsp;<input name="TxtCat2" type="text"  tabindex="1" class="TextBox"  maxlength="5"  style="width:50px" value="<? echo $_SESSION['TxtCat2']; ?>" onkeyup="this.value=this.value.toUpperCase()"></td></tr>
<tr> <td align="right"  >Nro.Patente:</td><td>&nbsp;<input name="TxtPat" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtPat']; ?>" /></td><td align="right"  >Nro.Poliza:</td><td>&nbsp;<input name="TxtPol" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtPol']; ?>" /></td><td align="right"  >Aseguradora:</td><td>&nbsp;<input name="TxtAseg" type="text"  tabindex="1" class="TextBox"  maxlength="30"  style="width:120px" value="<? echo $_SESSION['TxtAseg']; ?>" ></td></tr>
<tr> <td align="right"  >Empresa:</td><td>&nbsp;<input name="TxtEmpresa" type="text"  tabindex="1" class="TextBox"  maxlength="50"  style="width:270px" value="<? echo $_SESSION['TxtEmpresa']; ?>" ></td><td align="right"  >Veh&iacute;culo:</td><td colspan="3">&nbsp;<input name="TxtModelo" type="text"  tabindex="1" class="TextBox"  maxlength="50"  style="width:330px" value="<? echo $_SESSION['TxtModelo']; ?>" ></td></tr>
</table>

<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="80"></td><td width="130"></td><td width="80"></td><td width="150"></td></tr>
<tr> <td colspan="2" class="TBold">&nbsp;Datos del Conductor</td><td align="right"  ></td><td>&nbsp;</td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Apellido y Nombre:</td><td>&nbsp;<input  name="TxtNombre" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNombre'];?>" style="width:270px"></td><td align="right"  >DNI:</td><td>&nbsp;<input  name="TxtDNI" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtDNI'];?>" style="width:100px"></td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Nro.Licencia:</td><td>&nbsp;<input name="TxtLic" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" onchange="this.value=validarEntero(this.value);" value="<? echo $_SESSION['TxtLic']; ?>" /></td><td align="right"  >Vencimiento:</td><td>&nbsp;<? GLO_calendario("TxtVto","../Codigo/","actual",1) ?></td><td align="right"  >Categoria:</td><td>&nbsp;<input name="TxtCat" type="text"  tabindex="1" class="TextBox"  maxlength="5"  style="width:50px" value="<? echo $_SESSION['TxtCat']; ?>" onkeyup="this.value=this.value.toUpperCase()"></td></tr>
<tr> <td align="right"  >Puesto:</td><td>&nbsp;<input  name="TxtPuesto" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtPuesto'];?>" style="width:270px"></td><td align="right"  >Legajo:</td><td>&nbsp;<input  name="TxtLegajo" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtLegajo'];?>" style="width:65px"></td><td align="right"  ></td><td>&nbsp;</td></tr>
</table>

<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="80"></td><td width="130"></td><td width="80"></td><td width="150"></td></tr>
<tr> <td colspan="2" class="TBold">&nbsp;Detalle del Accidente:</td><td align="right"  ></td><td>&nbsp;</td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Direccion:</td><td colspan="5">&nbsp;<input name="TxtDir" type="text"  tabindex="1" class="TextBox"  maxlength="100"  style="width:710px" value="<? echo $_SESSION['TxtDir']; ?>" ></td></tr>
<tr> <td align="right"  >Localidad:</td><td>&nbsp;<select name="CbLocalidad" style="width:270px"  tabindex="1" class="campos" id="CbLocalidad" onChange="this.form.submit()" ><option value=""></option> <? ComboTablaRFX("localidades","CbLocalidad","Nombre","","",$conn); ?> </select></td><td align="right"  >Provincia:</td><td colspan="3">&nbsp;<input name="TxtProvincia" type="text"  class="TextBoxRO" style="width:270px" maxlength="30" readonly="true" value="<? echo $_SESSION['TxtProvincia']; ?>">&nbsp;<input name="TxtCP" type="text"  class="TextBoxRO" style="width:55px"  readonly="true" value="<? echo $_SESSION['TxtCP']; ?>"></td></tr>
<tr> <td align="right"  >Estado camino:</td><td>&nbsp;<input name="TxtEstado" type="text"  tabindex="1" class="TextBox"  maxlength="30"  style="width:270px" value="<? echo $_SESSION['TxtEstado']; ?>" ></td><td align="right"  >Clima:</td><td colspan="3">&nbsp;<input name="TxtEstado2" type="text"  tabindex="1" class="TextBox"  maxlength="30"  style="width:330px" value="<? echo $_SESSION['TxtEstado2']; ?>" ></td></tr>
</table>


<table width="840" border="0"  cellspacing="0" class="TMT2"><tr> <td  class="encabezado">COMPLETAR UTILIZANDO PROCEDIMIENTO CLASIFICACION ACCIDENTES E INCIDENTES</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="80"></td><td width="130"></td><td width="80"></td><td width="150"></td></tr>
<tr> <td align="right"  >Severidad:</td><td>&nbsp;<input name="TxtS" type="text"  tabindex="1" class="TextBox"  maxlength="3"  style="width:50px" value="<? echo $_SESSION['TxtS']; ?>"  onchange="this.value=validarEntero(this.value);"></td><td align="right"  >Clasificacion:</td><td>&nbsp;<input name="TxtC" type="text"  tabindex="1" class="TextBox"  maxlength="3"  style="width:50px" value="<? echo $_SESSION['TxtC']; ?>" ></td><td align="right"  >Probabilidad:</td><td>&nbsp;<input name="TxtP" type="text"  tabindex="1" class="TextBox"  maxlength="3"  style="width:50px" value="<? echo $_SESSION['TxtP']; ?>" ></td></tr>
</table>


<table width="840" border="0"  cellspacing="0" class="TMT2"><tr> <td  class="encabezado">COMPLETAR EN CASO DE DA&Ntilde;O AMBIENTAL</td></tr></table>
<table width="840" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td><td width="80"></td><td width="130"></td><td width="80"></td><td width="150"></td></tr>
<tr> <td align="right"  >Derrame de:</td><td>&nbsp;<input name="TxtDerrame" type="text"  tabindex="1" class="TextBox"  maxlength="30"  style="width:270px" value="<? echo $_SESSION['TxtDerrame']; ?>" ></td><td align="right"  >Lugar:</td><td colspan="3">&nbsp;<input name="TxtLugar" type="text"  tabindex="1" class="TextBox"  maxlength="30"  style="width:330px" value="<? echo $_SESSION['TxtLugar']; ?>" ></td></tr>
<tr> <td align="right"  >Cantidad:</td><td>&nbsp;<input name="TxtCantidad" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" value="<? echo $_SESSION['TxtCantidad']; ?>" ></td><td align="right"  >Superficie:</td><td>&nbsp;<input name="TxtSup" type="text"  tabindex="1" class="TextBox"  maxlength="20"  style="width:100px" value="<? echo $_SESSION['TxtSup']; ?>" onchange="this.value=validarEntero(this.value);"></td><td align="right"  ></td><td>&nbsp;</td></tr>
<tr> <td align="right"  >Remediacion:</td><td colspan="5">&nbsp;<input name="TxtObs" type="text"  tabindex="1" class="TextBox"  maxlength="100"  style="width:710px" value="<? echo $_SESSION['TxtObs']; ?>" ></td></tr>
<tr> <td align="right"  >Completada:</td><td>&nbsp;<select name="CbEstado" style="width:50px" class="campos"><option value=""></option><? GLO_CbSINO("CbEstado");  ?></select></td><td align="right"  >Realizado por:</td><td colspan="3">&nbsp;<select name="CbPersonal" style="width:330px" class="campos"><option value=""></option><? ComboPersonalRFX("CbPersonal",$conn);  ?></select></td></tr>
</table>



<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_guardar("840",1,0);
GLO_mensajeerror(); 
?>	